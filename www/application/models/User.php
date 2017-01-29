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

        $query = $this->db->get();

        if($query->num_rows() == 1)
        {
            return $query->result();
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

        $this->devices = $this->getDevices();


        return self::$instance;
    }

    protected function getDetails()
    {
        $this->db->select("first_name, last_name, house_no_name, street, town_city, postcode");
        $this->db->from("USERS");
        $this->db->where("id", $this->id);
        $query = $this->db->get();

        if($query)
        {
            $this->details = $query->result_array();
        }
        else
        {
            show_error($this->db->error()["message"], 500, "SQL Error: ".$this->db->error()["code"]);
        }
    }

    protected function getAddress()
    {

    }

    protected function getDevices()
    {

    }

    protected function getGuardian()
    {

    }
}
