#!/usr/bin/env python
# Local modules
from datetime import datetime
import os
from smtplib import SMTP
from email.mime.text import MIMEText
from email.header import Header
from email.utils import formataddr
import sys
# Custom modules
from twilio.rest import TwilioRestClient


class Notify(object):
	"""
		Class manages notifications to email/phone number(s) using twilio
	"""
	account_sid = "AC6b7b4178019bc48a9de7bcb575ba33df" # Your Account SID from www.twilio.com/console
	auth_token  = "1c10daddd7cb6568364fec48e807e0d8"  # Your Auth Token from www.twilio.com/console
	from_number = "+442033222777"
	from_email = "uni@scottsmudger.website"

	# Constructor
	def __init__(self, **kwargs):

		self.initLogger()

		# Connect to SMTP server
		conn = SMTP("ssl0.ovh.net")
		conn.set_debuglevel(False)
		conn.login("ar51@scottsmudger.website", "AR51SERVERSITE")

		# Initialise Twilio
		self.twilio = TwilioRestClient(self.account_sid, self.auth_token)

		if kwargs is not None:
			if "email" not in kwargs and "phone_number" not in kwargs:
				#self.log("error", "No phone_number or email specified!")
				sys.exit("No phone_number or email specified!")
			else:
				if "email" in kwargs:
					self.sendEmail(kwargs["email"], "test")

				if "phone_number" in kwargs:
					self.sendSMS(kwargs["phone_number"])

	def initLogger(self):
		import logging
		date = datetime.now().strftime("%d_%m_%y")
		month = datetime.now().strftime("%m")
		day = datetime.now().strftime("%d")
		# Logging
		self.log = logging.getLogger()
		self.log.setLevel(logging.DEBUG)
		format = logging.Formatter(fmt = "%(asctime)s - %(module)s - %(levelname)s: %(message)s", datefmt = "%d-%m-%Y %H:%M")
		# For screen logging
		screen = logging.StreamHandler()
		screen.setLevel(logging.DEBUG)
		screen.setFormatter(format)
		self.log.addHandler(screen)
		# Check if log folder exists, create it if not
		log_dir = os.getcwd() + "/logs"
		if not os.path.exists(log_dir):
			os.makedirs(log_dir)
			self.log.debug("Creating log dir: %s" % (log_dir))
		# For file logging
		logfile = logging.FileHandler("logs/door-%s.log" % (date))
		logfile.setLevel(logging.WARNING)
		logfile.setFormatter(format)
		self.log.addHandler(logfile)

	# Sends the actual SMS (isn't directly callable)
	def _sendSMS(self, to, message):
		try:
			message = self.twilio.messages.create(
				body = message,
				to = number,
				from_ = self.from_number
			)
			self.log.debug("Message sent to %s from %s: %s" % (to, self.from_number, message.sid))
		except TwilioRestException as e:
			self.log.error("Error sending SMS: %s" % e)
	
	# Decides if there are multiple numbers
	def sendSMS(self, to, message):
		# If multiple numbers (tuple/list)
		if isinstance(to, (list, tuple)):
			for number in to:
				self._sendSMS(to, message)
		else:
			self._sendSMS(to, message)

	# Sends the actual email (isn't directly callable)
	def _sendEmail(self, to, mesage):
		try:
			msg = MIMEText(message, "plain")
			msg["Subject"] = "Regarding your appliance"
			msg["From"] = formataddr((str(Header("Group 11 Smart Appliances", "utf-8")), self.from_email))
			conn.sendmail(self.from_email, to, msg.as_string())
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
		conn.quit()
	

if __name__ == "__main__":
	Notify(email="scottsmudger@hotmail.com")

