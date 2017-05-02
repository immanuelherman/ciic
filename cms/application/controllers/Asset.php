<?php
class Asset extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('url_helper');
		$this->config->load('_custom_config');
	}
	/*
	public function posm(){
		$data = array("title" => "POSM | Unilever CiiC", "navigation" => "posm", "page_title"=>"Point of Sales Material", "config" => $this->config);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/wrapperTop', $data);
		$this->load->view('templates/navigation', $data);
		$this->load->view('pages/asset/assetCategory_get', $data);
		$this->load->view('templates/wrapperBottom', $data);
	}
	public function product(){
		$data = array("title" => "Products | Unilever CiiC", "navigation" => "product", "page_title"=>"Product", "config" => $this->config);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/wrapperTop', $data);
		$this->load->view('templates/navigation', $data);
		$this->load->view('pages/asset/assetCategory_get', $data);
		$this->load->view('templates/wrapperBottom', $data);
	}
	public function store(){
		$data = array("title" => "Stores | Unilever CiiC", "navigation" => "store", "page_title"=>"Store", "config" => $this->config);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/wrapperTop', $data);
		$this->load->view('templates/navigation', $data);
		$this->load->view('pages/asset/assetCategory_get', $data);
		$this->load->view('templates/wrapperBottom', $data);
	}
	public function executable(){
		$data = array("title" => "Executables | Unilever CiiC", "navigation" => "executable", "page_title"=>"Executable", "config" => $this->config);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/wrapperTop', $data);
		$this->load->view('templates/navigation', $data);
		$this->load->view('pages/asset/assetCategory_get', $data);
		$this->load->view('templates/wrapperBottom', $data);
	}
	*/
	
	public function get_category($type="posm"){
		$data = array("config" => $this->config);
		switch((string)$type){
			case "product":
				$data['title'] = "Product | Unilever CiiC";
				$data['navigation'] = "product";
				$data['page_title'] = "Product";
				break;
			case "store":
				$data['title'] = "Store | Unilever CiiC";
				$data['navigation'] = "store";
				$data['page_title'] = "Store";
				break;
			case "executable":
				$data['title'] = "Executables | Unilever CiiC";
				$data['navigation'] = "executable";
				$data['page_title'] = "Executable";
				break;
			case "posm":
			default:
				$data['title'] = "POSM | Unilever CiiC";
				$data['navigation'] = "posm";
				$data['page_title'] = "Point of Sales Material";
				break;
		}
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/wrapperTop', $data);
		$this->load->view('templates/navigation', $data);
		$this->load->view('pages/asset/assetCategory_get', $data);
		$this->load->view('templates/wrapperBottom', $data);
	}
	
	public function get(){
		$data = array("title" => "Asset | Unilever CiiC", "navigation" => "asset", "page_title"=>"Asset", "config" => $this->config);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/wrapperTop', $data);
		$this->load->view('templates/navigation', $data);
		$this->load->view('pages/asset/asset_get', $data);
		$this->load->view('templates/wrapperBottom', $data);
	}
	
	public function detail($id=0){
		$at = ($id==0) ? "Create" : "Edit";
		$data = array("title" => "Asset Detail | Unilever CiiC", "navigation" => "asset", "config" => $this->config, "id"=>$id, "actionType"=>$at);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/wrapperTop', $data);
		$this->load->view('templates/navigation', $data);
		$this->load->view('pages/asset/asset_detail', $data);
		$this->load->view('templates/wrapperBottom', $data);
	}
	
	public function detail_category($type="posm", $id=0){
		var_dump($id);
		echo("<br/>");
		var_dump($type);
		die;
		/*
		$at = ($id==0) ? "Create" : "Edit";
		$data = array("title" => "Asset Detail | Unilever CiiC", "navigation" => "asset", "config" => $this->config, "id"=>$id, "actionType"=>$at);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/wrapperTop', $data);
		$this->load->view('templates/navigation', $data);
		$this->load->view('pages/asset/asset_detail', $data);
		$this->load->view('templates/wrapperBottom', $data);
		*/
	}
}