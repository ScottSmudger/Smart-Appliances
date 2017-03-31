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
	protected $date = "l dS F Y";
	
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
	* @return object $instance
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
		$this->db->select("first_name, last_name, dob, house_no_name as house, street, town_city, postcode, phone");
		$this->db->from("USERS");
		$this->db->where("id", $this->id);
		$result = $this->db->get();

		// Check if query returns something
		if($result)
		{
			foreach($result->row_array() as $key => $value)
			{
				$this->details[$key] = $this->encryption->decrypt($value);
			}

			// get actual age
			$from = new DateTime();
			$from->setTimestamp($this->details["dob"]);
			$to = new DateTime("today");
			$this->details["age"] = $from->diff($to)->y;
			$this->details["dob"] = date("d-m-Y", $this->details["dob"]);
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
	* Gets the device history for a specifc device
	* Formats it ready for plotting on the highcharts graph
	* Also decides on the time range to use, if a time period is set
	*
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
	* e.g. JSON:
	[{
		"name":"Fridge",
		"data":[
			[1487188233,1],
			[1487173833,1]
		]
	}, {
		"name":"Oven",
		"data":[
			[1487188233,0],
			[1487173833,0]
		]
	}]
	*
	* @return null
	*/
	protected function getDevicesHistory()
	{
		// As the "default" value
		$this->graph["devices"] = FALSE;

		if($this->input->get("device_id") != NULL)
		{
			// For specfic devices
			$id = $this->input->get("device_id");
			
			// For the given time period
			$this->period = $this->input->get("time_period");
			
			// For certain time periods
			if(isset($this->period))
			{
				switch($this->period)
				{
					case "everything":
						$time_period = "everywhere";
						$min = "";
						$max = "";
					break;
					case "today":
						$time_period = "today";
						$min = strtotime("midnight");
						$max = strtotime("tomorrow", time()) - 1;
					break;
					case "thisweek":
						$time_period = "this week";
						$min = strtotime("-1 week");
						$max = strtotime("tomorrow", time()) - 1;
					break;
					case "thismonth":
						$time_period = "this month";
						$min = strtotime("-1 month");
						$max = strtotime("tomorrow", time()) - 1;
					break;
					case "thisyear":
						$time_period = "this year";
						$min = strtotime("-1 year");
						$max = strtotime("tomorrow", time()) - 1;
					break;
				}
			}
			
			// If form is set to 0, just display all devices between min and max
			if($id == 0)
			{
				$this->getAllDevices($min, $max);
			}
			else
			{
				$this->db->select("DEVICE_HISTORY.state, DEVICE_HISTORY.date_time, DEVICES.appliance");
				$this->db->from("DEVICE_HISTORY");
				$this->db->join("DEVICES", "DEVICE_HISTORY.device_id = DEVICES.id");
				$this->db->where("device_id", $id);

				// If the range is set, use it
				if($min AND $max)
				{
					$this->db->where("DEVICE_HISTORY.date_time BETWEEN ".$min." AND ".$max."");
					$this->graph["title"] = "Data for device $id BETWEEN ".date($this->date, $min)." and ".date($this->date, $max)."";
				}
				else
				{
					$this->graph["title"] = "Data for device $id";
				}
				$this->db->order_by("date_time", "ASC");
				$history = $this->db->get();

				if($history)
				{
					foreach($history->result_array() as $row)
					{
						// For each "history" (row) build the array
						// Change data types to integer otherwise jQuery will not display them
						settype($row["date_time"], "int");
						settype($row["state"], "int");
						// Build array
						$this->graph["devices"][0]["name"] = $row["appliance"];
						$this->graph["devices"][0]["data"][] = array($row["date_time"] * 1000, $row["state"]);
					}
				}
				else
				{
					show_error($this->db->error()["message"], 500, "SQL Error: ".$this->db->error()["code"]);
				}
			}
		}
		else
		{
			$this->getAllDevices();
		}
	}

	/**
	* Gets the data for all devices
	*
	* @param $min Integer Minimum of the range that date_time needs to be in
	* @param $max Integer Maximum of the range that date_time needs to be in
	* @return null
	*/
	protected function getAllDevices($min = FALSE, $max = FALSE)
	{
		// As the "default" value
		$this->graph["devices"] = FALSE;

		// For all devices
		$devicecount = 0;
		foreach($this->devices as $device)
		{
			// For each device get its history
			$this->db->select("state, date_time");
			$this->db->from("DEVICE_HISTORY");
			$this->db->where("device_id", $device->id);
			// If the range is set, use it
			if($min AND $max)
			{
				$this->db->where("DEVICE_HISTORY.date_time BETWEEN ".$min." AND ".$max."");
				
				if($this->period == "today")
				{
					$this->graph["title"] = "All devices on ".date($this->date, $min);
				}
				else
				{
					$this->graph["title"] = "All devices between ".date($this->date, $min)." and ".date($this->date, $max)."";
				}
			}
			else
			{
				$this->graph["title"] = "All devices";
			}
			$this->db->order_by("date_time", "ASC");
			$history = $this->db->get();

			if($history)
			{
				foreach($history->result_array() as $row)
				{
					// For each "history" (row) build the array
					// Change data types to integer otherwise jQuery will not display them
					settype($row["date_time"], "int");
					settype($row["state"], "int");
					// Build array
					$this->graph["devices"][$devicecount]["name"] = $device->appliance;
					$this->graph["devices"][$devicecount]["data"][] = array($row["date_time"] * 1000, $row["state"]);
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
