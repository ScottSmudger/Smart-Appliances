<?php
/*

File: Database Class
Description: Manages the SQL connection. Also provides any functions to retrieve/set data.
Author: ScottSmudger for Group 11
URL: https://github.com/ScottSmudger/GPIO-Door

*/

class database
{
	private $_mysqli;
	
	/**
	 * Class constructor
	 *
	 * @param $link Object - The object of the SQL connection
	 *
	 * @return array of results
	 */
	public function __construct($link)
	{
		// Set local variable
		$this->_mysqli = $link;
		
		if($this->_mysqli->connect_errno)
		{
			echo "Failed to connect to MySQL: (" . $this->_mysqli->connect_errno . ") " . $this->_mysqli->connect_error;
		}
		else
		{
			echo "Connection successful: ".$this->_mysqli->host_info;
		}
	}
	
    public function __destruct()
    {
		$this->_mysqli->close();
    }
	
	/**
	 * Execute a SQL query
	 *
	 * @param $sql String - The query to execute
	 *
	 * @return array of results
	 */
	public function query($sql)
	{
		if($result = $this->_mysqli->query($sql))
		{
			$data = array();
			if($result->num_rows == 1) // If 1 result, return the indexed array
			{
				$data = $result->fetch_row();
			}
			else // Otherwise return an associative array
			{
				while($row = $result->fetch_assoc())
				{
					$data[] = $row;
				}
			}
		}
		else
		{
			$data = FALSE;
		}
		
		return $data;
	}
	
	/**
	 * Other useful functions
	 */
	 public function getDeviceState($device)
	 {
		 return $this->query("SELECT state FROM DEVICES WHERE device_id = '".$device."'");
	 }
	 
	 public function getAllDevicesState()
	 {
		 return $this->query("SELECT device_id, user_id, state, date_time, appliance FROM DEVICES");
	 }
	 
	 public function updateDeviceState($device, $state)
	 {
		 $this->query("UPDATE state FROM DEVICES WHERE device_id = '".$device."'");
	 }
	 
	 public function getUsersInfo()
	 {
		 return $this->query("SELECT U.FIRST_NAME, U.LAST_NAME, U.HOUSE_NO_NAME, U.STREET, U.TOWN_CITY, U.POSTCODE, G.FIRST_NAME as G_FIRST_NAME, G.LAST_NAME as G_LAST_NAME, G.EMAIL, G.PHONE FROM USERS U, GUARDIAN_CONTACT_DETAILS G WHERE G.USER_ID = U.USER_ID");
	 }
}

?>
