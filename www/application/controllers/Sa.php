<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Sa extends CI_Controller
{
	protected $data = array();

	public function __construct()
	{
		parent::__construct();
		
		$this->output->enable_profiler(TRUE);
		$this->benchmark->mark('starting_point');

		$this->load->helper("url");

		// To stop PHP from moaning
		date_default_timezone_set("UTC");
	}
	
	public function view($page = "dash")
	{
		$this->load->view("header");
        $this->load->view("pages/".$page);
		$this->load->view("footer");
	}
}
