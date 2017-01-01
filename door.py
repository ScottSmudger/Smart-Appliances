#!/usr/bin/env python
# Local modules

# Python modules
from random import randint
#import RPi.GPIO as GPIO
import time
from datetime import datetime
import os
import argparse
import logging
"""
Level               Numeric value
CRITICAL        50
ERROR               40
WARNING         30
INFO               20
DEBUG            10
NOTSET            0
"""


class Main(object):
    """
        Main class that manages the state of the door and initiates any libraries/classes
    """
    
    running = True
    
    def __init__(self):
        # Set constants
        self.fridge = 18
        # Logging
        self.initLogger()
        self.log.debug("Initialising door")
        # Setup GPIO
        #GPIO.setmode(GPIO.BCM)
        #GPIO.setup(self.fridge, GPIO.IN, GPIO.PUD_UP)
        # Initialise module classes
        #self.camera = camera.Camera()
        #self.database = database.Database()
        # Decide on logging
        self.logging = True
    
    # Configures and initiates the Logging library
    def initLogger(self):
        date = datetime.now().strftime("%d_%m_%y")
        month = datetime.now().strftime("%m")
        day = datetime.now().strftime("%d")
        # Logging
        self.log = logging.getLogger()
        self.log.setLevel(logging.DEBUG)
        format = logging.Formatter(fmt = "%(asctime)s - %(module)s - %(levelname)s: %(message)s", datefmt = "%d-%m-%Y %H:%M")
        # For file logging
        logfile = logging.FileHandler("logs/door-%s.log" % (date))
        logfile.setLevel(logging.WARNING)
        logfile.setFormatter(format)
        self.log.addHandler(logfile)
        # For screen logging
        screen = logging.StreamHandler()
        screen.setLevel(logging.DEBUG)
        screen.setFormatter(format)
        self.log.addHandler(screen)
    
    # Updates the door status
    # Will be used in final version
    def updateDoorState(self, state):
        return self.database.updateState(state)
    
    # Initiates the main loop that tests the GPIO pin
    def start(self):
        prev_state = None
        try:
            while self.running:
                state = randint(0,1) # GPIO.input(self.fridge)
                if state: # Real version: if state:
                    # Door is open
                    self.log.debug("Door is open!: %s" % (state))
                    # While door is open start recording and wait
                    time_start = time.time()
                    # while state: #GPIO.input(self.fridge):
                        # time.sleep(1)
                    time_end = time.time()
                    vid_length = round(time_end - time_start)
                else:
                    # Door is closed
                    if prev_state:
                        self.log.debug("Door is closed!: %s" % (state))
                
                if state != prev_state:
                    prev_state = state
                    #self.updateDoorState(state)
                    self.log.info("prev_state updated to: %s" % (prev_state))
                time.sleep(1)
                
        except KeyboardInterrupt:
            self.log.info("Program interrupted")
    
    # Cleans up GPIO when the script closes down
    def __del__(self):
        self.log.debug("Cleaning up door")
        #GPIO.cleanup()
    


# Start it
Main().start()



