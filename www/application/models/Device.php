<?php

defined('BASEPATH') OR exit('No direct script access allowed');


/**
* Device
* 
* @package      Smart Appliances
* @subpackage   Device
* @author       Scott Smith <s15001442@mail.glyndwr.ac.uk>
*/
class Device extends CI_Model
{
	/**
	* Returns the classes singleton
	*
	* @param object $device MySQL row object from User/Admin page
	* @return object $instance
	*/
	public function newDevice($device)
	{
		return new newDevice($device);
	}
}

class newDevice extends Device
{

	/**
	* Returns the classes singleton
	*
	* @param object $device MySQL row object from User/Admin page
	* @return object $instance
	*/
	public function __construct($device)
	{
		$this->setAttrs($device);
	}

	/**
	* Sets the classes attributes
	*
	* @param object $device MySQL row object from newDevice()
	* @return null
	*/
	protected function setAttrs($device)
	{
		$new = array("id", "state", "date_time");

		// Set each class attribute to a value from the database
		foreach((array) $device as $key => $value)
		{
			// Because MySQL selects integers as strings...
			// We need to explicitly set the data type for the integers we do stuff with.
			if(in_array($key, $new))
			{
				settype($value, "int");
			}

			// Puts the state into a human readable version
			if($key == "state")
			{
				if($value)
				{
					$value = "Open";
				}
				else
				{
					$value = "Closed";
				}
			}

			$this->$key = $value;
		}
		
		// Set the date_time to a proper format
		$this->date_time = date("d-m-Y H:i:s", $this->date_time);
	}
}
