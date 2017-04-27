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
	protected $instance;

	/**
	* Returns the classes singleton
	*
	* @param object $device MySQL row object from User/Admin page
	* @return object $instance
	*/
	public function newDevice($device)
	{
		$this->instance = new stdClass();

		$this->load->helper("date");

		$this->setAttrs($device);

		return $this->instance;
	}

	/**
	* Sets the classes attributes
	*
	* @param object $device MySQL row object from newDevice()
	* @return null
	*/
	protected function setAttrs($device)
	{
		$new = array("id", "state");

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

			// Changes unix time to a human date
			if($key == "date_time")
			{
				$value = date("d-m-Y H:i:s", $value);
			}

			$this->instance->$key = $value;
		}
	}
}
