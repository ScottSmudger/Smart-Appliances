# Smart-Appliances
_**NOTE:**_ The site is being hosted at [web-interface](http://uni.scottsmudger.website), displaying false data.

A simple python-based program that monitors a Raspberry-Pi's General Purpose Input Output (GPIO) pins connected to a magnetic door switch (as of now). A MySQL database is updated with the new appliances state.
Future ideas:

- ~~Fridge buzzer that will buzz when the fridge has been left open for a certain period of time.~~
- Microwave sensor that will detect when the microwave has finished (For personal curiosity!)
- ~~PHP report system~~
- ~~Highcharts jQuery graphs~~

A web-interface built using PHP/HTML/CSS with some elements of JavaScript and jQuery, is used to display the usage statistics of the appliances and any relevant user information.

This project is for the Group Project Design & Implementation modules of my Computer Networking and Security BSc Degree at [Glyndwr University](https://www.glyndwr.ac.uk/).

Group includes:

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

It is recommended to install the GPIO, MySQLdb, twilio and optionally picamera modules using pip:

    sudo pip install RPi.GPIO MySQL-python twilio picamera


The program is started by running `./start.sh` in the repositories root directory, this will create a new screen session and start the program. Using the command `screen -r smart` will open the screen where the program is running, displaying the log output. `CTRL, A + D` will close the program but keep it running in the background. `CTRL + C` will close it.

Alternatively running `./main.py` will start the program directly.

This software makes use of the [MIT License](https://github.com/ScottSmudger/GPIO-Door/blob/master/LICENSE).
