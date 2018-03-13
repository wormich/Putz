<?php

/*
 * Image CMS
 * lib_admin.php
 *
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Lib_admin
{

    public $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    /**
     * 	Initiating the basic parameters for administrator
     *  Loads libraries
     */
    public function init_settings() {

        $this->CI->config->set_item('langs', ['russian', 'english']);

        $this->CI->load->library('DX_Auth');

        # Load admin model
        $this->CI->load->model('cms_admin');

        # Set default admin template
        $this->CI->config->set_item('template', 'administrator');

        $this->CI->load->library('form_validation');
        $this->CI->load->library('template');
        $this->CI->load->helper('javascript');
        $this->CI->load->helper('admin');
        $this->CI->load->helper('component');
    }

    /**
     * Use this function to write empty value in db insted of 0
     *
     * @access public
     * @return string
     */
    public function db_post($data) {
        return ($this->CI->input->post($data)) ? $this->CI->input->post($data) : $data = '';
    }

    public function log($message) {
        $data = [
                 'user_id'  => $this->CI->dx_auth->get_user_id(),
                 'username' => $this->CI->dx_auth->get_username(),
                 'message'  => $message,
                 'date'     => time(),
                ];

        $this->CI->db->insert('logs', $data);
    }

}

/* End of lib_admin.php */