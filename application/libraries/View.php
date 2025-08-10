<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View {
    private $CI;
    private $data = array();

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function set_data($data)
    {
        $this->data = $data;
    }

    public function render($view, $options = array(), $saveData = true)
    {
        $output = $this->CI->load->view($view, $this->data, $saveData);
        return $output;
    }
}