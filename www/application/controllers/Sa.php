<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Sa extends CI_Controller
{
	protected $data = array();

	protected $client;

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
			if($this->session->user_data["id"] == 4)
			{
				$this->load->model("admin");
				$this->client = $this->admin->newAdmin();

				$this->load->view("header");
				$this->load->view("pages/admin", array("admin" => $this->client));
				$this->load->view("footer");
			}
			else
			{
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
