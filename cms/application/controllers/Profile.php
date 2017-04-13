<?php
class Profile extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('url_helper');
		$this->config->load('_custom_config');
	}
	
	public function get(){
		$data = array("title" => "Profile | Unilever CiiC", "navigation" => "profile", "config" => $this->config);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/wrapperTop', $data);
		$this->load->view('templates/navigation', $data);
		$this->load->view('pages/profile/profile_get', $data);
		$this->load->view('templates/wrapperBottom', $data);
	}
	
}