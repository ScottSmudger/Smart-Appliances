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
	* Calculate - Starts calculating all of the averages
	*
	* @return null
	*/
	public function calculate()
	{

	}

	/**
	* Average (Hour)
	*
	* @return array
	*/
	protected function average_hour()
	{
		//H = Hour;
		//SELECT * FROM TABLE WHERE HOUR = HOUR_NEEDED
		//save into array for hour
		
		$count = 0;
		$total = 0;
		$average = 0;
		foreach(array() as $time)
		{
			$total = $total + $time;
			$count++;
		}

		$average = $total / $count;
	}

	/**
	* Average (Day)
	*
	* @return array
	*/
	protected function average_day()
	{
		for($counter = 0; $counter = 17; $counter++)
		{
			//average_hour($counter);
			//save into array for day
		}
	}
/*
	Average (Week)

	$time = time();
	echo "for the date: ".date("d-m-Y H:i:s", $time)."<br/>";


	echo "for the week:<br/>";
	$start_week = strtotime("midnight", $time);
	$end_week = strtotime("tomorrow", $start_week) - 1;

	var_dump(
		array(
			"beginning" => $start_week,
			"end" => $end_week
		)
	);



	$this->db->select("date_time");
		$this->db->from("DEVICE_HISTORY");
		$this->db->where(date_time betweeen );

*/
}

	