<?php

defined('BASEPATH') OR exit('No direct script access allowed');


/**
* User
* 
* @package      Smart Appliances
* @subpackage   User
* @author       Scott Smith <s15001442@mail.glyndwr.ac.uk>
*/
class User extends CI_Model
{
	// User stuff
	protected $id;
	public $details;
	public $devices = array();
	public $graph = array();
	public $guardian;
	public $phone_number;
	protected $instance;

	/**
	* Returns the classes singleton
	*
	* @return object
	*/
	public function newUser()
	{
		$this->instance = $this;

		$this->load->helper("date");

		$this->id = $this->session->user_details["id"];

		$this->getDetails();
		$this->getGuardian();
		$this->getDevices();
		$this->getDevicesHistory();

		return $this->instance;
	}

	/**
	* Gets the users details and sets classes "details" attribute
	*
	* @return null
	*/
	protected function getDetails()
	{
		$this->db->select("CONCAT(first_name, ' ', last_name) as name, dob, house_no_name as house, street, town_city, postcode, phone");
		$this->db->from("USERS");
		$this->db->where("id", $this->id);
		$result = $this->db->get();

		// Check if query returns something
		if($result)
		{
			$this->details = $result->row_array();

			// get actual age
			$from = new DateTime();
			$from->setTimestamp($this->details["dob"]);
			$to = new DateTime('today');
			$this->details["age"] = $from->diff($to)->y;
			$this->details["dob"] = unix_to_human($this->details["dob"], FALSE, "eu");
		}
		else
		{
			show_error($this->db->error()["message"], 500, "SQL Error: ".$this->db->error()["code"]);
		}
	}

	/**
	* Gets the users guardian details and sets classes "guardian" attribute
	*
	* @return null
	*/
	protected function getGuardian()
	{
		$this->db->select("user_id, first_name, last_name, email, phone");
		$this->db->from("GUARDIAN_CONTACT_DETAILS");
		$this->db->where("user_id", $this->id);
		$result = $this->db->get();

		// Check if query returns something
		if($result)
		{
			$this->guardian = $result->result_array();
		}
		else
		{
			show_error($this->db->error()["message"], 500, "SQL Error: ".$this->db->error()["code"]);
		}
	}

	/**
	* Gets the users device details and sets classes "devices" array attribute
	*
	* @return null
	*/
	protected function getDevices()
	{
		$this->db->select("id, state, date_time, appliance");
		$this->db->from("DEVICES");
		$this->db->where("user_id", $this->id);
		$result = $this->db->get();

		// Check if query returns something
		if($result)
		{
			foreach($result->result_array() as $row)
			{
				$this->devices[] = $this->device->newDevice($row);
			}
		}
		else
		{
			show_error($this->db->error()["message"], 500, "SQL Error: ".$this->db->error()["code"]);
		}
	}

	/**
	* Gets the device history for each users device
	* Formats it ready for plotting on the highcharts graph
	*
	* e.g. JSON:
[{
	"name":"Fridge",
	"data":[
		[1487188233,1],
		[1487184633,0],
		[1487181033,1],
		[1487177433,0],
		[1487173833,1]
	]
},{
	"name":"Oven",
	"data":[
		[1487188233,0],
		[1487184633,1],
		[1487181033,0],
		[1487177433,1],
		[1487173833,0]
	]
}]
	* e.g. PHP:
	Array (
    [0] => Array (
        [name] => Fridge
        [data] => Array (
            [0] => Array (
                [0] => 1487188233
                [1] => 1
            )
            [n] => Array (
                [0] => 1487173833
                [1] => 1
            )
        )
    ),
    [1] => Array (
        [name] => Oven
        [data] => Array (
            [0] => Array (
                [0] => 1487188233
                [1] => 0
            )
            [n] => Array (
                [0] => 1487173833
                [1] => 0
            )
        )
    ))
	*
	* @return null
	*/
	protected function getDevicesHistory()
	{
		$devicecount = 0;
		foreach($this->devices as $device)
		{
			$this->db->select("state, date_time");
			$this->db->from("DEVICE_HISTORY");
			$this->db->where("device_id", $device->id);
			$this->db->order_by("date_time", "DESC");
			$history = $this->db->get();

			if($history)
			{
				foreach($history->result_array() as $row)
				{
					// Change data types to integer otherwise jQuery will not display them
					settype($row["date_time"], "int");
					settype($row["state"], "int");
					$this->instance->graph[$devicecount]["name"] = $device->appliance;
					$this->instance->graph[$devicecount]["data"][] = array($row["date_time"], $row["state"]);
				}
			}
			else
			{
				show_error($this->db->error()["message"], 500, "SQL Error: ".$this->db->error()["code"]);
				break;
			}

			$devicecount ++;
		}
	}
}
