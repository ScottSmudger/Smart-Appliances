#!/usr/bin/env python
# Local modules
import database
import notify
from devices import buzzer
# Python modules
import RPi.GPIO as GPIO
import time
from datetime import datetime
import os
import sys
import logging
"""
Level		Numeric value
CRITICAL	50
ERROR		40
WARNING		30
INFO		20
DEBUG		10
NOTSET		0
"""


class Main(object):
	"""
		Main class that manages the state of the door and initiates any libraries/classes
	"""
	running = True
	fridge_door = 18
	buzzer = 17
	
	# Setup GPIO, logging and initialise any external classes/modules
	def __init__(self):
		# Add current directory to PYTHONPATH
		sys.path.append(".")
		# Logging
		self.initLogger()
		self.log.debug("Initialising door")
		# Setup GPIO
		GPIO.setmode(GPIO.BCM)
		GPIO.setup(self.fridge_door, GPIO.IN, GPIO.PUD_UP)
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
		log_dir = os.getcwd() + "/logs"
		if not os.path.exists(log_dir):
			os.makedirs(log_dir)
			self.log.debug("Creating log dir: %s" % log_dir)
		# For file logging
		logfile = logging.FileHandler("logs/door-%s.log" % date)
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
		prev_state = 0
		open_length = 0
		try:
			while self.running:
				state = GPIO.input(self.fridge_door)
				
				if state:
					# Door is open
					self.log.debug("Door is open!: %s" % state)
					# While door is start timer and wait
					while GPIO.input(self.fridge_door):
						if open_length == 5:
								# For now texts can only be sent to my number (scott) EDIT: Due to Twilio trial limitations, it will only be to my number.
								self.sendNotify(phone_number = "+447714456013", message = "Fridge door has been open for %s seconds!" % open_length)
						elif open_length == 15:
							buzzer.Buzzer(self.buzzer).buzz(5)

						open_length += 1
						time.sleep(1)
					self.log.debug("Door was open for %s seconds" % open_length)
					self.sendNotify(phone_number = "+447714456013", message = "Fridge door has been closed after %s seconds!" % open_length)
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
