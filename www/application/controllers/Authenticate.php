<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Authenticate extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library("form_validation");
	}

	public function index()
	{
		$this->form_validation->set_rules("username", "Username", "trim|required|xss_clean");
		$this->form_validation->set_rules("password", "Password", "trim|required|xss_clean|callback_check_database");

		if($this->form_validation->run() == FALSE)
		{
			$this->login();
		}
		else
		{
			redirect("/dash");
		}
	}

	public function check_database($password)
	{
		$username = $this->input->post("username");

		$result = $this->user->checkLogin($username, $password);

		if($result)
		{
			$user_details = array();
			foreach($result as $row)
			{
				$user_details = array(
					"id" => $row->id,
					"username" => $row->username
				);
				$this->session->user_details = $user_details;
				$this->session->logged_in = TRUE;
			}
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message("check_database", "Invalid username or password");
			return FALSE;
		}
	}

	public function login()
	{
		$this->load->view("header");
		$this->load->view("pages/login");
		$this->load->view("footer");
	}

	public function logout()
	{
	    $user_data = $this->session->all_userdata();
	        foreach ($user_data as $key => $value)
	        {
                $this->session->unset_userdata($key);
	        }
	    $this->session->sess_destroy();
	    redirect("login");
	}
}
