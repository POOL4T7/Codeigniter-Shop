<?php


require 'vendor/autoload.php';

class Browser_Detection_Helper
{

    private $user_agent = NULL;
    //http user agent parse object
    private $parser = NULL;
    //browser object
    private $browser = NULL;
    //browser os
    private $os = NULL;
    //browser device
    private $device = NULL;
    //
    //
    //browser data
    private $browser_name = NULL;
    private $is_android = NULL;
    private $is_mobile = NULL;
    private $os_type = NULL;
    private $browser_version = NULL;
    private $device_type = NULL;
    private $model = NULL;
    private $key_count = 8;

    public function __construct()
    {
        $this->user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : NULL;
        if ($this->user_agent) {
            if (!isset($_SESSION['browserInfo']) || (count($_SESSION['browserInfo']) != $this->key_count)) {
                $this->parser();
                $this->browser();
                $this->os();
                $this->device();
                $this->compute();
            }
        }
    }

    public function get_browser_information()
    {
        if (!isset($_SESSION['browserInfo']) || (count($_SESSION['browserInfo']) != $this->key_count)) {
            $this->compute();
        }
        return $_SESSION['browserInfo'];
    }

    private function parser()
    {
        $this->parser = new WhichBrowser\Parser($this->user_agent);
    }

    private function browser()
    {
        if ($this->parser) {
            $this->browser = $this->parser->browser;
        }
    }

    private function os()
    {
        if ($this->parser) {
            $this->os = $this->parser->os;
        }
    }

    private function device()
    {
        if ($this->parser) {
            $this->device = $this->parser->device;
        }
    }

    private function compute()
    {
        if ($this->browser) {
            $this->browser_name = $this->browser->getName();
            $this->browser_version = $this->browser->getVersion();
        }
        if ($this->os) {
            $this->is_android = $this->os->getFamily() == "Android" ? true : false;
            if ($this->is_android) {
                $this->is_mobile = true;
            }
            $this->os_type = $this->os->getName();
        }
        if ($this->device) {
            $device_array = $this->device->toArray();
            $this->device_type = $device_array['type'] ?? NULL;
            if ($this->device_type != "desktop") {
                $this->is_mobile = true;
            } else {
                $this->is_mobile = false;
            }
            $this->model = $this->device->getManufacturer() . "-" . $this->device->getModel();
        }

        $data = new \stdClass();
        $data->browser_name = $this->browser_name;
        $data->is_android = $this->is_android;
        $data->is_mobile = $this->is_mobile;
        $data->os = $this->os_type;
        $data->os_type = $this->os_type;
        $data->browser_version = $this->browser_version;
        $data->device_type = $this->device_type;
        $data->model = $this->model;

        $array = array();
        foreach ($data as $key => $value) {
            $array[$key] = $value;
        }

        $_SESSION['browserInfo'] = $array;
    }
}
