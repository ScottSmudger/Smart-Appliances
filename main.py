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
	appliance = 1
	
	# Setup GPIO, logging and initialise any external classes/modules
	def __init__(self):
		# Config settings
		self.fridge = config.getint("Pins", "fridge")
		self.buzzer = config.getint("Pins", "buzzer")
		# Logging
		self.initLogger()
		self.log.debug("Initialising door")
		self.debug = config.getboolean("Other", "debug")
		# Setup GPIO
		GPIO.setmode(GPIO.BCM)
		GPIO.setup(config.getint("Pins", "fridge"), GPIO.IN, GPIO.PUD_UP)
		# Initialise module classes
		self.database = database.Database()
		self.notify = notify.Notify()
		# Average stuff
		#self.averages = self.getAvgs(self.appliance)
		#self.averages = {9:20, 9:40, 10:20, 10:40, 11:20, 11:40, 12:20}
		self.averages = {10: 19}
	
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
		logs_dir = os.getcwd() + "/" + config.get("Other", "logs_dir")
		if not os.path.exists(logs_dir):
			os.makedirs(logs_dir)
			self.log.debug("Creating log dir: %s" % logs_dir)
		# For file logging
		logfile = logging.FileHandler(logs_dir + "/fridge-%s.log" % date)
		logfile.setLevel(logging.DEBUG)
		logfile.setFormatter(format)
		self.log.addHandler(logfile)
	
	# Send an SMS or email
	def sendNotify(self, **kwargs):
		if self.debug:
			self.log.debug("Not sending SMS due to debug being enabled")
			return True
		else:
			return self.notify.sendNotification(**kwargs)
	
	# Updates the door status
	def updateDoorState(self, state):
		return self.database.updateState(self.appliance, state)
	
	# Human version of the state
	def getHumanState(self, state):
		if state:
			return "Open"
		else:
			return "Closed"
	
	# Initiates the main loop that tests the GPIO pins
	def start(self):
		self.prev_state = None
		self.prev_check = None
		self.door_opened = None
		self.door_changed = None
		self.check = False
		try:
			# Just say what the current state is
			self.log.debug("Current fridge state: %s (%s)" % (self.getHumanState(GPIO.input(self.fridge)), GPIO.input(self.fridge)))
			
			while self.running:
				self.state = GPIO.input(self.fridge)
				
				# When not in the expected time period
				# i.e. When the fridge is closed during the expected period of time
				self.inRange()
				
				if self.state:
					# Door is open
					self.log.debug("Fridge is open!: %s (%s)" % (self.getHumanState(self.state), self.state))
					# While door is open, start the timer and wait
					open_length = 0
					while GPIO.input(self.fridge):
						if open_length == 5:
							# Texts can now be sent to any number
							self.sendNotify(phone_number="+447714456013", message="Fridge has been open for %s seconds!" % open_length)
						elif open_length == 15:
							buzzer.Buzzer(self.buzzer).buzz(5)
							
						open_length += 1
						time.sleep(1)
					self.log.debug("Fridge was open for %s seconds" % open_length)
					
				else:
					# Door is closed
					if self.prev_state:
						self.log.debug("Fridge is closed!: %s (%s)" % (self.getHumanState(self.state), self.state))
				
				# We only want to insert data during the change of the door state,
				# otherwise we will be inserting data forever (which is bad)
				if self.prev_state != self.state:
					self.door_changed = True
					self.prev_state = self.state
					self.updateDoorState(self.state)
					self.log.info("Updating device state to: %s (%s)" % (self.getHumanState(self.prev_state), self.prev_state))
				else:
					self.door_changed = False
			
		except KeyboardInterrupt:
			self.log.info("Program interrupted")
	
	# Get the averages from the PHP API
	def getAvgs(self, device):
		# The indexes of the array are strings, making it an associate dict.
		# Needs converting to integers
		stringavgs = requests.get("http://uni.scottsmudger.website/api/" + str(device)).json()
		# Convert all keys to an integer
		intavg = {}
		for hour, avg in stringavgs.iteritems():
			intavg[int(hour)] = avg
		
		return intavg
	
	# If in range of 10 mins before and after the average time
	def inRange(self):
		# 900 = 15 mins
		# 600 = 10 mins
		cur_time = int(time.time() + 3600)
		# Current time as an object
		cur_time_hr_date = datetime.utcfromtimestamp(cur_time)
		# Current hour (in unix time) e.g. 16:00 = 1493828460
		cur_hr_unix = int(self.timestampFromDT(cur_time_hr_date) - ((cur_time_hr_date.minute * 60) + cur_time_hr_date.second))
		# Current hour
		cur_time_hr = int(datetime.utcfromtimestamp(cur_time).strftime("%H"))
		# If it's in the current hour
		if cur_time_hr in self.averages:
			# Get the current average for this hour
			avg = self.averages[cur_time_hr]
			# Current 
			time_hr = int(cur_hr_unix + (avg * 60))
			# Start and end periods
			start_period = int(self.timestampFromDT(datetime.utcfromtimestamp(time_hr)) - 30)
			end_period = int(self.timestampFromDT(datetime.utcfromtimestamp(time_hr)) + 30)
			# Check if the current time is between the range
			if cur_time >= start_period and cur_time <= end_period:
				# The fridge has been opened during the time range
				if self.state:
					self.door_opened = True
				self.check = True
			else: # Not in range
				#if self.check != self.prev_check and self.check is not None and self.prev_check:
				#	self.check = False
				#	self.prev_check = self.check
				
				# Do not touch this line \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/ \/
				if self.door_opened is None or not self.door_opened and self.door_changed is None or not self.door_changed and not self.state and self.prev_state:
					self.log.debug("======================================================= Fridge has not been opened during the expected time range =======================================================")
					self.sendNotify(phone_number="+447714456013", message="Fridge has not been opened when expected")
					
				self.door_opened = False
				#self.door_changed = False
	
	# Calculates the timestamp from the DT object
	def timestampFromDT(self, dt):
		return time.mktime(dt.timetuple()) + 3600
	
	# Cleans up GPIO when the script closes down
	# Deconstructor
	def __del__(self):
		self.log.debug("Cleaning up Main")
		GPIO.cleanup()
	

# Start it
if __name__ == "__main__":
	Main().start()
