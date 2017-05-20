<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit_trail {

	public $parameter;
	public $request_info;

	public function init_audit()
	{
		$CI =& get_instance();
		$CI->load->helper(array('http', 'url'));

		$config_file = 'user_authentication';
        $CI->config->load($config_file, TRUE);
        $config_header = $CI->config->item('header', $config_file);

		$params = array();
		$parameter = NULL;

		$params[$config_header['authorization']] = $CI->input->get_request_header($config_header['authorization'], TRUE);
		$params[$config_header['date']] = $CI->input->get_request_header($config_header['date'], TRUE);
		$params['method'] = $CI->input->method(TRUE);
		$params['path'] = $CI->input->server('PATH_INFO', TRUE);
		$params['path'] = "/".uri_string();
		$params['user_agent'] = $CI->input->get_request_header('User-Agent', TRUE);
		$params['ip_address'] = $CI->input->ip_address();

		if (strtolower($params['method']) == "get")
		{
			$parameter = $CI->input->get(NULL, TRUE);
		}
		else
		{
			$parameter = $CI->input->raw_input_stream;
			$body = "";
			if (!empty($parameter) && ($parameter = json_decode($parameter, TRUE)))
	        {
	            $CI->request_info = $params;
	            if (!empty($parameter['body'])) $body = $parameter['body'];
	            $parameter = $CI->security->xss_clean($parameter);
				$CI->parameter = $parameter;
        		if (!empty($parameter['body'])) $CI->parameter['body'] = $body;

	            // response(400, "Invalid json format");
				return;
	        }

			if (strtolower($params['method']) == "post")
			{
				$parameter = $CI->input->post(NULL, TRUE);
	            if (!empty($parameter['body'])) $body = $parameter['body'];
			}
			else
			{
				$parameter = $CI->input->input_stream(NULL, TRUE);
	            if (!empty($parameter['body'])) $body = $parameter['body'];
			}
		}
		$CI->request_info = $params;
		$CI->parameter = $parameter;
        if (!empty($parameter['body'])) $CI->parameter['body'] = $body;
		return;
	}

	public function save_audit()
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->model('Audit_trail_model');
		$CI->request_info['response_code'] = http_response_code();
		$CI->Audit_trail_model->add($CI->request_info);
		return;
	}
}