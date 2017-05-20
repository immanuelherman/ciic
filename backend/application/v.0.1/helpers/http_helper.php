<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function response($http_code, $message)
{
	if (!is_array($message))
	{
		throw new Exception("Invalid json message", 1);
	}

	if (!isset($message["responseStatus"]) OR !in_array(strtolower($message["responseStatus"]), array("success", "error")))
	{
		throw new Exception("Response status invalid", 1);
	}

	$message = array_merge(array("apiVersion" => API_VERSION, "requestTime" => get_request_time()), $message);

	$response = json_encode($message);
	$CI = get_instance();
	$CI->output->set_status_header($http_code)->set_content_type('application/json', 'utf-8')->set_output($response)->_display();
	$CI->load->database();
	$CI->load->model('Audit_trail_model');
	$CI->request_info['response_code'] = $http_code;
	$CI->request_info['data'] = (!empty($CI->parameter)) ? json_encode($CI->parameter) : NULL;
	$CI->Audit_trail_model->add($CI->request_info);
    exit;
}

function get_request_time()
{
	$CI = get_instance();
	$CI->load->helper('date');
	return now();
}