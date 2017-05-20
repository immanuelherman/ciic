<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Session_module extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function generate($email)
	{
        $this->load->helper('common');
		// lock user finger print
  		// create session id unique by upn+ip_address+user_agent
        session_id(create_finger_print($email));


        // is user is not login already? if yes. then we will create secret_key. 
        // note: this only performed once after user has authenticate.
        $this->load->library('session');
        
        $this->load->config('user_authentication');
        
        $index_secret_key = $this->config->item('user_authentication')['secret_key']['key'];

        return ($this->session->userdata('logged_in') !== TRUE) ? make_unique_id() : $this->session->userdata($index_secret_key);
	}
}