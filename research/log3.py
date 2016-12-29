#!/usr/bin/python
# References:
# Errors & Exception: https://docs.python.org/2/tutorial/errors.html
# Classes: https://docs.python.org/2/tutorial/classes.html#tut-classes
# Library: https://docs.python.org/2/tutorial/stdlib.html
# Part 2: https://docs.python.org/2/tutorial/stdlib2.html

print("-----------------------------------")
print("Start of Tests")
print("-----------------------------------")
# Errors & Exceptions
# Errors are used to display what is wrong with the program, and display something helpful about how to fix it. Exceptions are used to detect when a certain errors occur, or to "raise" an error.
# e.g. Erors(exceptions) can be raised custom to certain applications.
# The syntax for a try/except is the following:
    # try:
        
    # except <error>:
        
# Classes
# Custom classes can be created to handle exceptions.
# The class syntax is:
    # class Name():
        # def function():
            
        # def function2():
            
# Here is an example class:
class Example(object):
    # Defines the 3 arguements required for the class
    def __init__(self):
        # Calls exception class
        raise MyExc("No viable parameters!")
        
# and here is an example Exception class:
class MyExc(Exception):
    def __init__(self, value):
        self.value = value
    def __str__(self):
        return repr(self.value)
    
test = Example()

# Libraries
# Example useful libraries such as OS and shutil, sys, re, math, urllib2, smtplib, datetime.
# OS is used to interface with the operating system, shutil is used to daily file/directory management as it is easier to use then the OS lib.
# sys is used for command line arguments, useful for python scripts.
# re is used to Regular Expression matching and analysing data (which we may end up using)
# math module provides access to many functions (from C) such as cos, log and pi.
# urllib2 and smtplib and internet enabled libraries. URLLib is used to interface with POST/GET requests to a webserver or API. SMTP (Simple Mail Tranfer Protocol) is used for sending mail.
# datetime is used to simply use date/time functions such as formatting UNIX time or working out the difference between 2 dates.

# Part 2
# Threading
# The threading module allows a programmer to open another thread for a background process. This is useful when the main program has too much to do, and wants to unload some of the processing to another thread so it can continue.

# Logging
# The logging module allows useful debug information to be written to a file with an extensive list of customisation. This will be useful for our program. It supports multiple levels of logging (debug, info, warning, error, critial).

# Arrays
# Arrays are similar to Python's Lists except you can specify the programmer specifies a more accurate datatype such as 2-bye unsigned integers. This allows Python to more intelligently allocate memory compared to the normal 16-byte allocations.

# Decimal
# Decimal is used for floating point arithmetic, especially useful in finance situations or complex mathematical calculations where accuracy is vital. 

