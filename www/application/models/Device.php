<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Device extends CI_Model
{
    protected $instance;

    public function newDevice($device)
    {
        $this->instance = new stdClass();

        $this->setAttrs($device);

        return $this->instance;
    }

    protected function setAttrs($device)
    {
        $new = array("id", "state", "date_time");

        foreach((array) $device as $key => $value)
        {
            // Because MySQL selects integers as strings... We need to explicitly set the data type for the integers we do stuff with.
            if(in_array($key, $new))
            {
                settype($value, "int");
            }

            if($key == "state")
            {
                if($value)
                {
                    $value = "Open";
                }
                else
                {
                    $value = "Closed";
                }
            }

            $this->instance->$key = $value;
        }
    }
}
