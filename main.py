#!/usr/bin/python
# Local modules
import database
import notify
from devices import buzzer
# Python modules
import RPi.GPIO as GPIO
import time
from datetime import datetime
import os
import logging
import ConfigParser
import requests
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
		# Average stuff
		self.averages = self.getAvgs()

	# Configures and initiates the Logging library
	def initLogger(self):
		# For log name (1 per day)
		date = datetime.now().strftime("%d_%m_%y")
		# Root logger
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
				
				self.state = GPIO.input(self.fridge)
				
				# When not in the expected time period
				# i.e. When the fridge is not opened in an expected period of time
				if self.inRange():
					self.log.debug("Fridge is not open when it should be")
				
				if self.state:
					# Door is open
					self.log.debug("Door is open!: %s" % self.state)
					# While door is start timer and wait
					while GPIO.input(self.fridge):
						if open_length == 5:
							# Texts can now be sent to any number (I think)
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
						self.log.debug("Door is closed!: %s" % self.state)
				
				# We only want to insert data during the change of the door state,
				# otherwise we will be inserting data forever (which is bad)
				if self.state != prev_state:
					prev_state = self.state
					self.updateDoorState(self.state)
					self.log.info("Updating device state to: %s (%s)" % (self.getHumanState(prev_state), prev_state))
					
		except KeyboardInterrupt:
			self.log.info("Program interrupted")
	
	# Gets the averages from the PHP API
	def getAvgs(self):
		avgs = requests.get("http://uni.scottsmudger.website/api").json()
		no_avgs = len(avgs)
		
		counter = 0
		self.avgs_time = []
		for avg_hour, avg in avgs.iteritems():
			if counter == no_avgs - 1:
				break
			temp = {} # Re-declare the temp dictionary while resetting it
			
			# Calculate the hour and minute for each average
			# append to the final list
			hour = datetime.fromtimestamp(avg).strftime("%H")
			minute = datetime.fromtimestamp(avg).strftime("%M")
			
			temp["hour"] = hour
			temp["minute"] = minute
			self.avgs_time.append(temp)

			counter += 1
			
		return avgs
	
	def genState(self):
		state = randint(0, 1)
		return state
	
	# If in range of 10 mins before and after the average time
	def inRange(self):
		# 900 = 15 mins
		# 600 = 10 mins
		cur_time = time.time()
		cur_time_hr = datetime.fromtimestamp(cur_time).strftime("%H")
		
		# If it's in range
		if cur_time_hr in self.avgs_time:
			avg_time = self.avgs_time[int(cur_time_hr)]
			start_period_min = datetime.fromtimestamp(avg_time - 600).strftime("%M")
			end_period_min = datetime.fromtimestamp(avg_time + 600).strftime("%M")
			for hour, avg in self.averages.iteritems():
				if cur_time >= start_period_min and cur_time <= end_period_min \
				and not self.state:
					# The fridge has been opened during the time frame
					return True
				else:
					# The fridge hasn't been opened during the time frame
					return False
				
	# Cleans up GPIO when the script closes down
	# Deconstructor
	def __del__(self):
		self.log.debug("Cleaning up Main")
		GPIO.cleanup()
	

# Start it
if __name__ == "__main__":
	Main().start()





