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
	* @return object
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

			// Puts the state into a human version
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
				$value = unix_to_human($value, FALSE, "eu");
			}

			$this->instance->$key = $value;
		}

		$this->getDevicesHistory();
	}
	
	/**
	* Gets the device history ready for plotting on the highcharts graph
	*
	* @return null
	*/
	protected function getDevicesHistory()
	{
		$this->db->select("device_id, state, date_time");
		$this->db->from("DEVICE_HISTORY");
		$result = $this->db->get();

		// Check if query returns something
		if($result)
		{
			$devicecount = 0;
			foreach($this->devices as $device)
			{
				$this->db->select("state, date_time");
				$this->db->from("DEVICE_HISTORY");
				$this->db->where("device_id", $device->id);
				$this->db->order_by("date_time", "DESC");
				$history = $this->db->get();

				foreach($history->result_array() as $row)
				{
					// Change data types to integer otherwise jQuery will not display them
					settype($row["date_time"], "int");
					settype($row["state"], "int");

					$this->instance->graph[$devicecount]["name"] = $device->appliance;
					$this->instance->graph[$devicecount]["data"][] = array($row["date_time"], $row["state"]);

				}
				$devicecount ++;
			}
		}
		else
		{
			show_error($this->db->error()["message"], 500, "SQL Error: ".$this->db->error()["code"]);
		}
	}
}
