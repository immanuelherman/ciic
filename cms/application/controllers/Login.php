<?php
class Login extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('url_helper');
		$this->config->load('_custom_config');
	}
	
	public function get($id = NULL){
		$data = array("title" => "Login | Unilever CiiC", "config" => $this->config);
		$this->load->view('templates/header', $data);
		$this->load->view('pages/login/login', $data);
	}
	
}