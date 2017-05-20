<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pre_controller {

	public $api_url;

	public function init()
	{
		$CI =& get_instance();
		$config_file = 'settings';
        $CI->config->load($config_file, TRUE);
        $CI->api_url = $CI->config->item('api_url', $config_file);
		return;
	}
}