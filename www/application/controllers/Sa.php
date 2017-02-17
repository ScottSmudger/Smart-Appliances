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

		// To stop PHP from moaning
		date_default_timezone_set("UTC");
	}
	
	/**
	* View - Displays the page being called
	*
	* @param string $page The page to be displayed
	* @return null
	*/
	public function view($page = "dash", $device = NULL)
	{
		if($device)
		{
			$_GET["device"] = $device;
		}
		
		// Require login
		if($this->session->logged_in)
		{
			// If logged in display the requested page,
			// or admin page if logged in as an admin
			if($this->session->is_admin)
			{
				$this->load->model("admin");
				$this->client = $this->admin->newAdmin();

				$this->load->view("header");
				$this->load->view("pages/admin", array("admin" => $this->client));
				$this->load->view("footer");
			}
			else
			{
				$this->client = $this->user->newUser();

				$this->load->view("header");
				$this->load->view("pages/".$page, array("user" => $this->client));
				$this->load->view("footer");
			}
		}
		else
		{
			redirect("/login");
		}
	}
}
