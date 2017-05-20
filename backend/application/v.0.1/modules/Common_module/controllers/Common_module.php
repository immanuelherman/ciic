<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_module extends MX_Controller {
	protected $error;
	protected $error_code;

	public function __construct()
	{
		parent::__construct();
	}

	public function get_common_gender_list()
	{
		$this->load->model("Common_model");

		$common = $this->Common_model->get_common_gender_list();

		$this->load->helper('url');
		$data = array(
			'data' => $common
		);
		return $data;
	}

}