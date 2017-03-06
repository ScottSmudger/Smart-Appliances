#!/usr/bin/python
import logging
import time
import RPi.GPIO as GPIO


class Buzzer(object):
	"""
		Buzzer device class
	"""
	def __init__(self, pin):
		self.log = logging.getLogger(__name__)
		self.log.debug("Initialising Buzzer")

		# Setup the pin
		GPIO.setup(pin, GPIO.OUT)
		self.PWM = GPIO.PWM(pin, 10)
		self.PWM.ChangeFrequency(100) # 100hz (highest)

	# Buzzes for "length" seconds
	def buzz(self, length):
		self.log.debug("Buzzing for %s seconds" % length)
		self.PWM.start(50)
		time.sleep(length)
		self.PWM.stop()


if __name__ == "__main__":
	buzzer = Buzzer(18)
	buzzer.buzz(5)
