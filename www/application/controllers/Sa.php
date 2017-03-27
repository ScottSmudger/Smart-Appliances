<?php

defined('BASEPATH') OR exit('No direct script access allowed');


/**
* Sa
* 
* @package      Smart Appliances
* @author       Scott Smith <s15001442@mail.glyndwr.ac.uk>
*/
class Sa extends CI_Controller
{
	protected $data = array();
	protected $client;
	protected $averages;

	/**
	* Classes constructor
	*
	* @return null
	*/
	public function __construct()
	{
		parent::__construct();
		
		$this->output->enable_profiler(TRUE);
		$this->benchmark->mark("starting_point");

		// To stop PHP from moaning as we're manipulating and displaying times from unix time
		date_default_timezone_set("UTC");
	}

	/**
	* Dash - Displays the dash page
	*
	* @param integer $device The device to be displayed
	* @return null
	*/
	public function dash($device = NULL)
	{
		if($device)
		{
			$_GET["device"] = $device;
		}

		$this->load->model("average");
		$averages = $this->average->calculate();

		$this->client = $this->user->newUser();

		// Require login
		// If logged in display the requested page
		if($this->session->logged_in)
		{
			$this->load->view("header");
			$this->load->view("pages/dash", array("user" => $this->client, "averages" => $averages));
			$this->load->view("footer");
		}
		else
		{
			redirect("/login");
		}
	}
	
	/**
	* API - Displays the API page
	*
	* @return null
	*/
	public function api()
	{
		$this->load->model("average");
		$averages = $this->average->api();
	
		$this->load->view("pages/api", array("averages" => $averages));
	}

	/**
	* Email - Send an email to Group 11
	*
	* @return null
	*/
	public function email()
	{
		// Load the email library
		$this->load->library("email");

		// Set the email headers
		$this->email->from("group11@scottsmudger.website", $this->input->post("from_name"));
		$this->email->to("scottsmudger@hotmail.com");
		$this->email->subject($this->input->post("subject"));
		$this->email->message($this->input->post("message"));

		// Send the email
		$this->email->send();

		redirect("/");
	}
}
