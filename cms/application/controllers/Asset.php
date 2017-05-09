<?php
class Asset extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('url_helper');
		$this->config->load('_custom_config');
	}
	
	public function get_category($type="posm"){
		$data = array("config" => $this->config);
		switch((string)$type){
			case "product":
				$data['title'] = "Product | Unilever CiiC";
				$data['navigation'] = "asset/product";
				$data['asset_type'] = "product";
				$data['page_title'] = "Product";
				break;
			case "store":
				$data['title'] = "Store | Unilever CiiC";
				$data['navigation'] = "asset/store";
				$data['asset_type'] = "store";
				$data['page_title'] = "Store";
				break;
			case "executable":
				$data['title'] = "Executables | Unilever CiiC";
				$data['navigation'] = "asset/executable";
				$data['asset_type'] = "executable";
				$data['page_title'] = "Executable";
				break;
			case "posm":
			default:
				$data['title'] = "POSM | Unilever CiiC";
				$data['navigation'] = "asset/posm";
				$data['asset_type'] = "posm";
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
		$at = ($id==0) ? "Create" : "Edit";
		$data = array("title" => "Asset Detail | Unilever CiiC", "navigation" => "asset/".$type, "asset_type" => $type, "config" => $this->config, "id"=>$id, "actionType"=>$at);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/wrapperTop', $data);
		$this->load->view('templates/navigation', $data);
		$this->load->view('pages/asset/assetCategory_detail', $data);
		$this->load->view('templates/wrapperBottom', $data);
		
	}
}