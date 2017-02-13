<?php

defined('BASEPATH') OR exit('No direct script access allowed');


/**
* Authenticate
* 
* @package      Smart Appliances
* @subpackage   Authenticate
* @author       Scott Smith <s15001442@mail.glyndwr.ac.uk>
*/
class Authenticate extends CI_Controller
{
	/**
	* Classes constructor
	*
	* @return null
	*/
	public function __construct()
	{
		parent::__construct();

		$this->load->library("form_validation");

		$this->output->enable_profiler(TRUE);
		$this->benchmark->mark("starting_point");
	}

	/**
	* index - Displays the login form
	*
	* @return null
	*/
	public function index()
	{
		$this->form_validation->set_rules("username", "Username", "trim|required|xss_clean");
		$this->form_validation->set_rules("password", "Password", "trim|required|xss_clean|callback_check_database");

		// Check if the form succeeded
		if($this->form_validation->run() == FALSE)
		{
			$this->login();
		}
		else
		{
			if($this->session->is_admin)
			{
				redirect("/admin");
			}
			else
			{
				redirect("/dash");
			}
		}
	}

	/**
	* check_database - Calls checkLogin() function to get the users details
	*
	* @param string $password The password to be checked
	* @return bool
	*/
	public function check_database($password)
	{
		$username = $this->input->post("username");

		$result = $this->checkLogin($username, $password);

		// Check if checkLogin() returns something
		if($result)
		{
			// Get details
			$user_details = array(
				"id" => $result->id,
				"username" => $result->username,
				"logged_in_time" => time()
			);

			// Set session
			$this->session->user_details = $user_details;
			$this->session->logged_in = TRUE;

			// If admin
			if($result->id == 4)
			{
				$this->session->is_admin = TRUE;
			}

			return TRUE;
		}
		else
		{
			$this->form_validation->set_message("check_database", "Invalid username or password");
			return FALSE;
		}
	}

	/**
	* checkLogin - Checks the users details against the database
	*
	* @param string $username The username to be checked
	* @param string $password The password to be checked
	* @return bool
	*/
	protected function checkLogin($username, $password)
	{
		$this->db->select("id, username, password");
		$this->db->from("LOGIN_DETAILS");
		$this->db->where("username", $username);
		$this->db->where("password", $password);
		$this->db->limit(1);
		$result = $this->db->get();

		// Check if the query returns something,
		// and that it contains one row
		if($result AND $result->num_rows() == 1)
		{
			return $result->row();
		}
		else
		{
			return FALSE;
		}
	}

	/**
	* login - Displays the login page
	*
	* @return null
	*/
	public function login()
	{
		$this->load->view("header");
		$this->load->view("pages/login");
		$this->load->view("footer");
	}

	/**
	* login - Displays the logout page
	*
	* @return null
	*/
	public function logout()
	{
		// Remove session data
		$this->session->unset_userdata($this->session->all_userdata());
		// Destroy session
		$this->session->sess_destroy();
		redirect("/login");
	}
}
