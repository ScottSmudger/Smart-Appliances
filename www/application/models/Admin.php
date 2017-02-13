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
}
