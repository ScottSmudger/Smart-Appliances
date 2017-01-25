#!/usr/bin/env python
import MySQLdb
import logging
import sys
import time


class Database(object):
    """
        Database class that manages the connection, details and any queries
    """
    def __init__(self):
        self.log = logging.getLogger(type(self).__name__)
        self.log.debug("Initialising Database")
        self.connect()
    
    def connect(self):
        db_host = 'ftp.ar51.eu'
        db_port = 3306
        db_user = 'pi'
        db_pass = 'MUpxryhsDmRQbG3m'
        db_name = 'pi'
        try:
            self.log.debug("Initiated MySQL connection on %s as user %s" % (db_host, db_user))
            self.db_connect = MySQLdb.connect(host = db_host, port = db_port, user = db_user, passwd = db_pass, db = db_name)
        except MySQLdb.Error, e:
            self.log.critical("Could not initiate MySQL connection: %s" % (e))
            sys.exit()
    
    def updateState(self, state):
        if self.query("INSERT INTO bedroom_door (state, time) VALUE (%s, %s)" % (state, time.time())):
            self.log.info("Updating door state to: %s" % (state))
            return True
        else:
            self.log.info("Could not update door state to: %s" % (state))
            return False
    
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
    
    def __del__(self):
        self.log.debug("Cleaning up Database")
        self.db_connect.close()
    
