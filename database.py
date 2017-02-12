#!/usr/bin/env python
import MySQLdb
import logging
import sys
import time


class Database(object):
	"""
		Database class that manages the connection and any queries
	"""
	# Constructor, calls connect() on initialisation
	def __init__(self):
		self.log = logging.getLogger(type(self).__name__)
		self.log.debug("Initialising Database")
		self.connect()
	
	# Connects to the remote database server
	def connect(self):
		db_host = 'ftp.ar51.eu'
		db_port = 3306
		db_user = 'group11'
		db_pass = 'glyndwrgroup11'
		db_name = 'group11'
		try:
			self.log.debug("Initiated MySQL connection on %s as user %s" % (db_host, db_user))
			self.db_connect = MySQLdb.connect(host = db_host, port = db_port, user = db_user, passwd = db_pass, db = db_name)
		except MySQLdb.Error, e:
			self.log.critical("Could not initiate MySQL connection: %s" % (e))
			self.db_connect = False
			sys.exit()
	
	# Updates the state of an appliance
	def updateState(self, device, state):
		# Update devices current state
		try:
			if self.query("UPDATE DEVICES SET state = %s, date_time = %s WHERE id = %s" % (state, time.time(), device)):
				self.log.debug("Updating state of appliance %s to: %s" % (device, state))
			else:
				self.log.debug("Could not update state of appliance %s to: %s" % (device, state))
		except Exception, e:
			self.log.critical("Failed to update device %s state to %s. Error: %s" % (device, state, e))

		try:
			if self.query("INSERT INTO DEVICE_HISTORY (device_id, state, date_time, device_history) VALUES (%s, %s, %s, %s)" % (not state, time.time(), device, "Not sure what this is for yet")):
				self.log.debug("Adding to device history state: %s for device %s" % (not state, device))
			else:
				self.log.debug("Could not add to device %s history for sate: %s" % (device, not state))
		except Exception, e:
			self.log.critical("Failed to update device %s history to %s. Error: %s" % (device, not state, e))
	
	# Executes a SQL query
	def query(self, query):
		self.log.debug("Running query: %s" % (query))
		try:
		   cursor = self.db_connect.cursor()
		   cursor.execute(query)
		except(AttributeError, MySQLdb.OperationalError), e:
		   self.log.error("Exception generated during SQL connection: %s" % (e))
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
	
