<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Sa extends CI_Controller
{
	protected $data = array();

	public function __construct()
	{
		parent::__construct();
		
		$this->output->enable_profiler(TRUE);
		$this->benchmark->mark("starting_point");

		// To stop PHP from moaning
		date_default_timezone_set("UTC");

		$this->client = $this->user->newUser();
	}
	
	public function view($page = "dash")
	{
		// Require login
		if($this->session->logged_in)
		{      
			$this->load->view("header");
			$this->load->view("pages/".$page);
			$this->load->view("footer");
		}
		else
		{
			redirect("login");
		}
	}
}
