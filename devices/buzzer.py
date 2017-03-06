#!/usr/bin/env python
import logging
import time
import RPi.GPIO as GPIO


class Buzzer(object):
	def __init__(self, pin):
		self.log = logging.getLogger(__name__)

                self.log.debug("Initialising Buzzer")
                
		GPIO.setup(pin, GPIO.OUT)
		self.PWM = GPIO.PWM(pin, 10)
		self.PWM.ChangeFrequency(100)  # Frequency is now 50 Hz - LED stops flickering

	def buzz(self, length):
                self.log.debug("Buzzing for %s" % length)
		self.PWM.start(20)
		time.sleep(length)
		self.PWM.stop()


if __name__ == "__main__":
	buzzer = Buzzer()
	buzzer.buzz(5)
