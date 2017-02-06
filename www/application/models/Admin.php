<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Admin extends CI_Model
{
	// Admin stuff
	protected $id;
	public $details;
	public $devices = array();
	protected $instance;

	public function newAdmin()
	{
		$this->instance = $this;
		
		$this->id = $this->session->user_details["id"];
		
		$this->getDetails();
		$this->getDevices();
		
		return $this->instance;
	}

	protected function getDetails()
	{
		$this->db->select("CONCAT(first_name, ' ', last_name) as name, age, house_no_name as house, street, town_city, postcode");
		$this->db->from("USERS");
		$this->db->where("id", $this->id);
		$result = $this->db->get();
		
		if($result)
		{
			$this->details = $result->row_array();
		}
		else
		{
			show_error($this->db->error()["message"], 500, "SQL Error: ".$this->db->error()["code"]);
		}
	}

	protected function getDevices()
	{
		$this->db->select("id, user_id, state, date_time, appliance");
		$this->db->from("DEVICES");
		$result = $this->db->get();
		
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
