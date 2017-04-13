<?php
class User extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('url_helper');
		$this->config->load('_custom_config');
	}
	
	public function get(){
		$data = array("title" => "User | Unilever CiiC", "navigation" => "user", "config" => $this->config);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/wrapperTop', $data);
		$this->load->view('templates/navigation', $data);
		$this->load->view('pages/user/user_get', $data);
		$this->load->view('templates/wrapperBottom', $data);
	}
	
	
	public function detail($id = 0){
		$at = ($id==0) ? "Create" : "Edit";
		$data = array("title" => "User Detail | Unilever CiiC", "navigation" => "user", "config" => $this->config, "id"=>$id, "actionType"=>$at);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/wrapperTop', $data);
		$this->load->view('templates/navigation', $data);
		$this->load->view('pages/user/user_detail', $data);
		$this->load->view('templates/wrapperBottom', $data);
	}
}