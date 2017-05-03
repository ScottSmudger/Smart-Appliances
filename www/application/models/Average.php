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
	/**
	* calculate - Gets the data and calculates the averages
	*
	* @return $averages array Array of averages
	*/
	public function calculate()
	{
		// Set the min and max
		$min = strtotime("-1 month");
		$max = strtotime("tomorrow", time()) - 1;
		
		// Get the data
		$this->db->select("state, date_time");
		$this->db->from("DEVICE_HISTORY");
		$this->db->where("state", "1");
		$this->db->where("date_time BETWEEN ".$min." AND ".$max."");
		$result = $this->db->get();
		
		// If there are results
		if($result AND $result->num_rows() > 4)
		{
			// Separates times into hourly periods
			foreach($result->result_array() as $row)
			{
				$hour = date("H", $row["date_time"]);
				
				$data[$hour]["times"][] = $row["date_time"];
			}
			
			// Calculates the averages for each hourly period
			$averages = array();
			foreach($data as $hour => $times)
			{
				settype($hour, "int");
				// After each loop of the hour we need to reset the total,
				// in order to calculate the new average.
				// If the user has opened/closed the fridge only twice during the hour,
				// this also accomodates for "rogue" opens/closes. i.e. Opening + Closing across an hour
				// then don't contribute it towards the average.
				$total = 0;
				if(count($times["times"]) > 5)
				{
					foreach($times["times"] as $time)
					{
						$total = $total + date("i", $time);
					}
				}
				
				$average = $total / count($times["times"]);
				
				if($average > 0)
				{
					$averages[$hour] = $average;
				}
			}
			
			return $averages;
		}
		else
		{
			return array(NULL);
		}
	}
}
