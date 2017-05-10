#!/usr/bin/python
import MySQLdb
import logging
import sys
import time


class Database(object):
	"""
		Database class that manages the connection and "most" queries
	"""
	
	OPEN = 1
	CLOSED = 0
	
	# Constructor, calls connect() on initialisation
	def __init__(self):
		self.log = logging.getLogger(__name__)
		self.log.debug("Initialising Database")
		self.cur_time = int(time.time() + 3600)
		
		# Database settings
		from main import config
		self.db_host = config.get("Database", "db_host")
		self.db_port = config.getint("Database", "db_port")
		self.db_user = config.get("Database", "db_user")
		self.db_pass = config.get("Database", "db_pass")
		self.db_name = config.get("Database", "db_name")
		
		# Connect
		self.connect()
	
	# Connects to the remote database server
	def connect(self):
		try:
			self.db_connect = MySQLdb.connect(host = self.db_host, port = self.db_port, user = self.db_user, passwd = self.db_pass, db = self.db_name)
			self.log.debug("Initiated MySQL connection to %s as user %s" % (self.db_host, self.db_user))
		except MySQLdb.Error, e:
			self.log.critical("Could not initiate MySQL connection to %s: %s" % (self.db_host, e))
			self.db_connect = False
			sys.exit()
	
	# Updates the state of an appliance
	def updateState(self, appliance, state):
		# Update appliances current state
		try:
			if self.query("UPDATE DEVICES SET state = %s, date_time = %s WHERE id = %s" % (self.getBoolState(state), int(time.time() + 3600), appliance)):
				self.log.debug("Updating state of appliance %s to: %s" % (appliance, self.getBoolState(state)))
			else:
				self.log.debug("Could not update state of appliance %s to: %s" % (appliance, self.getBoolState(state)))
		except Exception, e:
			self.log.critical("Failed to update appliance %s state to %s. Error: %s" % (appliance, state, e))
		
		# Update appliances state history
		try:
			if self.query("INSERT INTO DEVICE_HISTORY (device_id, state, date_time) VALUES (%s, %s, %s)" % (appliance, self.getBoolState(state, True), int(time.time() + 3600))):
				self.log.debug("Adding to appliance history state: %s for appliance %s" % (self.getBoolState(state, True), appliance))
			else:
				self.log.debug("Could not add to appliance %s history for state: %s" % (appliance, self.getBoolState(state, True)))
		except Exception, e:
			self.log.critical("Failed to update appliance %s history to %s. Error: %s" % (appliance, self.getBoolState(state, True), e))
	
	# Get boolean version of the expression
	def getBoolState(self, state, invert = False):
		if state:
			if not invert:
				return self.OPEN
			else:
				return self.CLOSED
		else:
			if not invert:
				return self.CLOSED
			else:
				return self.OPEN
	
	# Execute a SQL query
	def query(self, query):
		self.log.debug("Running query: %s" % query)
		cursor = self.db_connect.cursor()
		# Try and execute the query
		try:
			cursor.execute(query)
			self.db_connect.commit()
		except(AttributeError, MySQLdb.OperationalError), e:
		   self.log.error("Exception generated during SQL connection: %s" % e) 
		   self.connect()
		   cursor = self.db_connect.cursor()
		   cursor.execute(query)
		cursor.close()
		return cursor
	
	# Deconstructor
	def __del__(self):
		self.log.debug("Cleaning up Database")
		if self.db_connect:
			self.db_connect.close()
	
