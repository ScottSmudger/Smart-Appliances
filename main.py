<<<<<<< HEAD
#!/usr/bin/python
=======
#!/usr/bin/env python
>>>>>>> 316dc7366d7d9d810cc08feb625d8ecae2d073f8
# Local modules
import database
import notify
from devices import buzzer
# Python modules
import RPi.GPIO as GPIO
import time
from datetime import datetime
import os
<<<<<<< HEAD
import logging
import ConfigParser
=======
import sys
import logging
>>>>>>> 316dc7366d7d9d810cc08feb625d8ecae2d073f8
"""
Level		Numeric value
CRITICAL	50
ERROR		40
WARNING		30
INFO		20
DEBUG		10
NOTSET		0
"""

# We define config here so other modules can import it
config = ConfigParser.ConfigParser()
config.read("config.ini")


class Main(object):
	"""
		Main class that manages the state of the door and initiates any libraries/classes
	"""
	running = True
	
	# Setup GPIO, logging and initialise any external classes/modules
	def __init__(self):
		# Config settings
		self.fridge = config.getint("Pins", "fridge")
		self.buzzer = config.getint("Pins", "buzzer")
		self.logs_dir = os.getcwd() + "/" + config.get("Other", "logs_dir")

		# Logging
		self.initLogger()
		self.log.debug("Initialising door")

		# Setup GPIO
		GPIO.setmode(GPIO.BCM)
		GPIO.setup(config.getint("Pins", "fridge"), GPIO.IN, GPIO.PUD_UP)

		# Initialise module classes
		self.database = database.Database()
		self.notify = notify.Notify()

	# Configures and initiates the Logging library
	def initLogger(self):
		date = datetime.now().strftime("%d_%m_%y")
		month = datetime.now().strftime("%m")
		day = datetime.now().strftime("%d")
		# Logging
		self.log = logging.getLogger()
		self.log.setLevel(logging.DEBUG)
		format = logging.Formatter(fmt = "%(asctime)s - %(module)s - %(levelname)s: %(message)s", datefmt = "%d-%m-%Y %T")
		# For screen logging
		screen = logging.StreamHandler()
		screen.setLevel(logging.DEBUG)
		screen.setFormatter(format)
		self.log.addHandler(screen)
		# Check if log folder exists, create it if not
		if not os.path.exists(self.logs_dir):
			os.makedirs(self.logs_dir)
			self.log.debug("Creating log dir: %s" % self.logs_dir)
		# For file logging
		logfile = logging.FileHandler(self.logs_dir + "/door-%s.log" % date)
		logfile.setLevel(logging.WARNING)
		logfile.setFormatter(format)
		self.log.addHandler(logfile)
	
	# Send an SMS or email
	def sendNotify(self, **kwargs):
		return self.notify.sendNotification(**kwargs)

	# Updates the door status
	def updateDoorState(self, state):
		return self.database.updateState(1, state)
	
	# Human version of the state
	def getHumanState(self, state):
		if state:
			return "Open"
		else:
			return "Closed"

	# Initiates the main loop that tests the GPIO pins
	def start(self):
		prev_state = None
		open_length = 0
		try:
			while self.running:
				state = GPIO.input(self.fridge)
				
				if state:
					# Door is open
					self.log.debug("Door is open!: %s" % state)
					# While door is start timer and wait
					while GPIO.input(self.fridge):
						if open_length == 5:
								# For now texts can only be sent to my number (scott) EDIT: Due to Twilio trial limitations, it will only be to my number.
								self.sendNotify(phone_number="+447714456013", message="Fridge door has been open for %s seconds!" % open_length)
						elif open_length == 15:
							buzzer.Buzzer(self.buzzer).buzz(5)

						open_length += 1
						time.sleep(1)
					self.log.debug("Door was open for %s seconds" % open_length)
					self.sendNotify(phone_number="+447714456013", message="Fridge door has been closed after %s seconds!" % open_length)
				else:
					# Door is closed
					if prev_state:
						self.log.debug("Door is closed!: %s" % state)
				
				# We only want to insert data during the change of the door state,
				# otherwise we will be inserting data forever (which is bad)
				if state != prev_state:
					prev_state = state
					self.updateDoorState(state)
					self.log.info("prev_state updated to: %s %s" % (self.getHumanState(prev_state), prev_state))
					
		except KeyboardInterrupt:
			self.log.info("Program interrupted")
	
	# Cleans up GPIO when the script closes down
	# Deconstructor
	def __del__(self):
		self.log.debug("Cleaning up Main")
		GPIO.cleanup()
	

# Start it
if __name__ == "__main__":
	Main().start()
