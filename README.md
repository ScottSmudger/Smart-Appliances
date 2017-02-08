# Smart-Appliances ![alt text](https://api.travis-ci.org/ScottSmudger/Smart-Appliances.svg?branch=master "Travis CI Build")
A simple python-based program that monitors a Raspberry-Pi's General Purpose Input Output (GPIO) pins connected to a magnetic door switch (as of now). A MySQL database is updated with the new appliances state.

A [web-interface](http://uni.scottsmudger.website) built using PHP/HTML/CSS with some elements of JavaScript and jQuery, is used to display the usage statistics of the appliances and any relevant user information.

This project is for the Group Project Design & Implementation modules of my Computer Networking and Security BSc Degree at [Glyndwr University](https://www.glyndwr.ac.uk/). It may also be used for my disseration in the third year.

Team includes: 
- Jamie Davies: S14000296
- Scott Smith: S15001442
- Jazmine Hughes: S15001137

## Requirements
- Web server with a minimum PHP version of 5.6
- Database server - MySQL was used with the database schema in the `db.sql` file
- Raspberry Pi and Python GPIO module
- Python with the MySQL-Python module
- Screen linux package

All can be installed using the following command:

    sudo apt-get install apache2 php5 mysql-client python screen

It is recommended to install the GPIO and MySQLdb modules using pip:

    pip install RPi.GPIO MySQL-python

The program is started by running `./start.sh` in the repositories root directory, this will create a new screen session and start the program. Using the command `screen -r smart` will open the screen where the program is running, displaying the log output. `CTRL, A + D` will close the program but keep it running in the background. `CTRL + C` will close it.

This software makes use of the [MIT License](https://github.com/ScottSmudger/GPIO-Door/blob/master/LICENSE).
