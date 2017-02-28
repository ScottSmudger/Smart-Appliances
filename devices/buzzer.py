#!/usr/bin/env python
import logging
import time
import RPi.GPIO as GPIO


class Buzzer(object):
	def __init__(self, pin):
		self.log = logging.getLogger(type(self).__name__)
		self.pin = Parent.buzzer

		GPIO.setup(self.pin, GPIO.OUT)
		self.PWM = GPIO.PWM(self.pin, 10)
		self.PWM.ChangeFrequency(50)  # Frequency is now 50 Hz - LED stops flickering

	def buzz(self, length):
		self.PWM.start(50)
		time.sleep(length)
		self.PWM.stop()

	def __del__(self):
		GPIO.cleanup()


if __name__ == "__main__":
	buzzer = Buzzer()
	buzzer.buzz(5)
