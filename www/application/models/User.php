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

		$this->id = $this->session->user_details["id"];

		$this->getDetails();
		$this->getGuardian();
		$this->getDevices();

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
}
