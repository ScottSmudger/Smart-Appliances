#!/usr/bin/env python
# Local modules
from datetime import datetime
import os
from smtplib import SMTP
from email.mime.text import MIMEText
from email.header import Header
from email.utils import formataddr
import sys
import logging
from time import sleep
import socket


class Notify(object):
	"""
		Class manages notifications to email/phone number(s) using twilio
	"""
	# Twilio settings
	account_sid = "AC6b7b4178019bc48a9de7bcb575ba33df"
	auth_token  = "1c10daddd7cb6568364fec48e807e0d8"
	from_number = "+442033222777"
	from_email = "uni@scottsmudger.website"
	# Email settings
	host = "test.ovh.net"
	timeout = 5
	username = "ar51@scottsmudger.website"
	password = "AR51SERVERSITE"

	# Constructor
	def __init__(self):
		self.log = logging.getLogger(type(self).__name__)
		self.log.debug("Initialising Notify")

		# Connect to twilio API
		try:
			from twilio.rest import TwilioRestClient
			self.twilio = TwilioRestClient(self.account_sid, self.auth_token)
		except Exception, e:
			self.log.error("Twilio module is not installed! Run \"pip install twilio\": %s" % e)

		# Connect to SMTP server
		try:
			socket.setdefaulttimeout(self.timeout)
			self.smtp = SMTP(self.host)
			if self.username and self.password:
				self.smtp.login(self.username, self.password)
		except Exception, e:
			self.log.error("Could not connect to SMTP server %s" % self.host)

	# Decides whether or not to send an SMS or email (or both)
	def sendNotification(self, **kwargs):
		if kwargs is not None:
			if "email" not in kwargs and "phone_number" not in kwargs:
				#self.log("error", "No phone_number or email specified!")
				sys.exit("No phone_number or email specified!")
			else:
				if "message" in kwargs:
					if "email" in kwargs:
						self.sendEmail(kwargs["email"], kwargs["message"])

					if "phone_number" in kwargs:
						self.sendSMS(kwargs["phone_number"], kwargs["message"])
				else:
					self.log.error("Cannot send email or SMS without a message!")

	# Sends the actual SMS (isn't directly callable)
	def _sendSMS(self, to, message):
		try:
			self.twilio.messages.create(
				body = message,
				to = to,
				from_ = self.from_number
			)
			self.log.debug("Message sent to %s from %s" % (to, self.from_number))
		except Exception as e:
			self.log.error("Error sending SMS: %s" % e)
	
	# Decides if there are multiple numbers
	def sendSMS(self, to, message):
		# If multiple numbers (tuple/list)
		if isinstance(to, (list, tuple)):
			for number in to:
				self._sendSMS(to, message)
				sleep(1)
		else:
			self._sendSMS(to, message)

	# Sends the actual email (isn't directly callable)
	def _sendEmail(self, to, mesage):
		try:
			msg = MIMEText(message, "plain")
			msg["Subject"] = "Regarding your appliance"
			msg["From"] = formataddr((str(Header("Group 11 Smart Appliances", "utf-8")), self.from_email))
			self.smtp.sendmail(self.from_email, to, msg.as_string())
			self.log.debug("Email sent to %s from %s" % (to, self.from_email))
		except Exception, e:
			self.log.error("Error sending Email: %s" % e)

	# Decides if there are multiple emails
	def sendEmail(self, to, message):
		# If multiple emails (tuple/list)
		if isinstance(to, (list, tuple)):
			for email in to:
				self._sendEmail(to, message)
		else:
			self._sendEmail(to, message)

	# Deconstructor
	def __del__(self):
		self.log.debug("Cleaning up notify")
		self.smtp.quit()

