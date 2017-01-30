<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class User extends CI_Model
{
    protected $id;
    public $details;
    public $devices = array();
    public $address = array();
    public $guardian;
    protected static $instance;

    public function checkLogin($username, $password)
    {
        $this->db->select("id, username, password");
        $this->db->from("LOGIN_DETAILS");
        $this->db->where("username", $username);
        $this->db->where("password", $password);
        $this->db->limit(1);

        $result = $this->db->get();

        if($result->num_rows() == 1)
        {
            return $result->result();
        }
        else
        {
            return FALSE;
        }
    }

    public function newUser()
    {
        self::$instance = $this;
        $this->id = $this->session->user_details["id"];

        $this->getDetails();
        $this->getAddress();

        return self::$instance;
    }

    protected function getDetails()
    {
        $this->db->select("CONCAT(first_name, ' ', last_name) as name, age");
        $this->db->from("USERS");
        $this->db->where("id", $this->id);
        $result = $this->db->get();

        if($result)
        {
            $this->details = $result->row_array();
        }
        else
        {
            show_error($this->db->error()["message"], 500, "SQL Error: ".$this->db->error()["code"]);
        }
    }

    protected function getAddress()
    {
        $this->db->select("house_no_name as house, street, town_city, postcode");
        $this->db->from("USERS");
        $this->db->where("id", $this->id);
        $result = $this->db->get();

        if($result)
        {
            $this->address = $result->row_array();
        }
        else
        {
            show_error($this->db->error()["message"], 500, "SQL Error: ".$this->db->error()["code"]);
        }
    }

    protected function getGuardian()
    {
        $this->db->select("user_id, first_name, last_name, email, phone");
        $this->db->from("USERS");
        $this->db->where("user_id", $this->id);
        $result = $this->db->get();

        if($result)
        {
            $this->guardian = $result->result_array();
        }
        else
        {
            show_error($this->db->error()["message"], 500, "SQL Error: ".$this->db->error()["code"]);
        }
    }

    protected function getDevices()
    {
        $this->db->select("user_id, state, date_time, appliance");
        $this->db->from("DEVICES");
        $this->db->where("user_id", $this->id);
        $result = $this->db->get();

        if($result)
        {
            $this->devices = $result->result_array();
        }
        else
        {
            show_error($this->db->error()["message"], 500, "SQL Error: ".$this->db->error()["code"]);
        }
    }
}
