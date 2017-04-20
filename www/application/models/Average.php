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
		if($result AND $result->num_rows() > 2)
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
}
