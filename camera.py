#!/usr/bin/python
from picamera import PiCamera
from datetime import datetime
import logging
import os


class Camera(object):
	"""
		Camera class that manages the recording and photos
		Not used for our purposes, but still functional
	"""
	# Constructor
	def __init__(self):
		date = datetime.now().strftime("%d_%m_%y")
		month = datetime.now().strftime("%m")
		day = datetime.now().strftime("%d")
		self.log = logging.getLogger(type(self).__name__)
		self.log.debug("Initialising Camera")
		self.camera = PiCamera()
		self.camera.start_preview()
		# Check if media folder exists, create it if not
		media_dir = os.path.expanduser("~/media/%s/%s" % (month, day))
		if not os.path.exists(media_dir):
			os.makedirs(media_dir)
			self.log.debug("Making media dir: %s" % (media_dir))
	
	def startRecording(self):
		month = datetime.now().strftime("%m")
		day = datetime.now().strftime("%d")
		time = datetime.now().strftime("%H-%M-%S")
		if not self.camera.recording:
			self.log.info("Started recording")
			self.video = os.path.expanduser("media/%s/%s/video_%s.h264" % (month, day, time))
			self.camera.start_recording(self.video)
	
	def stopRecording(self):
		if self.camera.recording:
			self.log.debug("Stopped recording")
			self.camera.stop_recording()
			self.log.info("Video created: %s" % (self.video))
	
	def takePhoto(self):
		self.log.debug("Took a screenshot")
		path = os.path.expanduser("~/media/%s/%s/image_%s.jpg" % (month, day, time))
		self.camera.capture(path)
		self.log.info("Screenshot created: %s" % (path))
	
	# Deconstructor
	def __del__(self):
		self.log.debug("Cleaning up Camera")
		if self.camera.previewing:
			self.camera.stop_preview()
		if self.camera.recording:
			self.camera.stop_recording()
		self.camera.close()
	
