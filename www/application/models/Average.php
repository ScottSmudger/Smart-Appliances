<?php

defined('BASEPATH') OR exit('No direct script access allowed');


/**
* Average
* 
* @package      Smart Appliances
* @subpackage   Average
* @author       Scott Smith <s15001442@mail.glyndwr.ac.uk>
*/
class Average extends CI_Model
{
	protected $result;
	
	/**
	* Calculate - Get the data
	*
	* @return $this->getAvg() Array of averages
	*/
	public function calculate()
	{
		$min = strtotime("-1 week");
		$max = strtotime("tomorrow", time()) - 1;

		$this->db->select("state, date_time");
		$this->db->from("DEVICE_HISTORY");
		$this->db->where("state", "1");
		$this->db->where("date_time BETWEEN $min AND $max");
		$this->result = $this->db->get();
		
		return $this->getAvg();
	}
	
	/**
	* API - For the API as we need to define an arbitrary period of time
	*
	* @return $this->getAvg() Array of averages
	*/
	public function api()
	{
		$min = strtotime("-1 month");
		$max = strtotime("tomorrow", time()) - 1;

		$this->db->select("state, date_time");
		$this->db->from("DEVICE_HISTORY");
		$this->db->where("state", "1");
		$this->db->where("date_time BETWEEN $min AND $max");
		$this->result = $this->db->get();
		
		return $this->getAvg();
	}
	
	/**
	* getAvg - Starts calculating all of the averages
	*
	* @return $this->getAvg() Array of averages
	*/
	protected function getAvg()
	{
		// Separates times into hourly periods
		$counter = 0;
		foreach($this->result->result_array() as $row)
		{
			settype($row["date_time"], "int");
			
			$hour = date("H", $row["date_time"]);
			settype($hour, "int");
			
			$data[$hour]["times"][] = $row["date_time"];
		}
		
		// Calculates the averages for each hourly period
		foreach($data as $hour)
		{
			// After each loop of the hour we need to reset the total
			// in order to calculate the new average
			$total = 0;
			foreach($hour["times"] as $time)
			{
				$total = $total + $time;
			}
			
			$count = count($hour["times"]);
			
			$averages[] = $total / $count;
		}
		
		return $averages;
	}
}
