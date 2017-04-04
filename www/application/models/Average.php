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
		$min = strtotime("-3 week");
		$max = strtotime("tomorrow", time()) - 1;
		
		return $this->calcAvg($min, $max);
	}
	
	/**
	* API - For the API as we need to define an arbitrary period of time
	*
	* @return array $this->getAvg($result) Array of averages
	*/
	public function api()
	{
		$min = strtotime("-1 month");
		$max = strtotime("tomorrow", time()) - 1;
		
		return $this->calcAvg($min, $max);
	}
	
	/**
	* getAvg - Starts calculating all of the averages
	*
	* @return $averages array Array of averages
	*/
	protected function calcAvg($min, $max)
	{
		if($min AND $max)
		{
			// Get the data
			$this->db->select("state, date_time");
			$this->db->from("DEVICE_HISTORY");
			$this->db->where("state", "1");
			$this->db->where("date_time BETWEEN ".$min." AND ".$max."");
			$result = $this->db->get();

			// If there are results
			if($result AND $result->num_rows() > 0)
			{
				// Separates times into hourly periods
				$counter = 0;
				foreach($result->result_array() as $row)
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
		else
		{
			show_error("No min or max variables set", 500, "Could not calculate averages");
		}
	}
}
