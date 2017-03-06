<?php

defined('BASEPATH') OR exit('No direct script access allowed');


/**
* Admin
* 
* @package      Smart Appliances
* @subpackage   Admin
* @author       Scott Smith <s15001442@mail.glyndwr.ac.uk>
*/
class Admin extends CI_Model
{
	// Admin stuff
	protected $id;
	public $details;
	public $devices = array();
	public $graph = array();
	protected $instance;

	/**
	* Returns the classes singleton
	*
	* @return object
	*/
	public function newAdmin()
	{
		$this->instance = $this;
		
		$this->id = $this->session->user_details["id"];
		
		$this->getDetails();
		$this->getDevices();
		$this->getDevicesHistory();
		
		return $this->instance;
	}

	/**
	* Gets the admins details and sets the "details" attribute
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
		}
		else
		{
			show_error($this->db->error()["message"], 500, "SQL Error: ".$this->db->error()["code"]);
		}
	}

	/**
	* Gets all devices data and sets the "devices" array attribute
	*
	* @return null
	*/
	protected function getDevices()
	{
		$this->db->select("id, user_id, state, date_time, appliance");
		$this->db->from("DEVICES");
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
	* Gets the device history ready for plotting on the highcharts graph
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
					$this->instance->graph[$devicecount]["data"][] = array($row["date_time"] * 1000, $row["state"]);
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
