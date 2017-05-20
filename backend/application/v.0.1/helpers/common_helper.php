<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function create_finger_print($upn)
{
	$CI = get_instance();

	$config_header = $CI->config->item('user_authentication');
	$prefix = $config_header['header']['prefix_upn'];

	$uniqid = array(
		$prefix,
    	$upn,
    	$CI->input->ip_address(),
    	$CI->input->user_agent()
	);

	return md5(implode(",", $uniqid));
}

function make_unique_id()
{
	$unique_id = '';
	$CI = get_instance();

	do
	{
		$unique_id .= mt_rand();
	}
	while (strlen($unique_id) < 32);

	$unique_id .= $CI->input->ip_address();

	// Turn it into a hash and return
	return md5(uniqid($unique_id, TRUE));
}

function get_user_data()
{
	$CI = get_instance();

	if ($CI->userdata['logged_in'] != 1)
	{
		$CI->load->config('user_authentication');
        $index_secret_key = $CI->config->item('user_authentication')['secret_key']['key'];
		return FALSE;	
	}
	unset($CI->userdata['__ci_last_regenerate']);
	$userdata = $CI->userdata;

	return $userdata;
}


/**
 * Valid Email
 *
 * @param	string
 * @return	bool
 */
function valid_email($str)
{
	if (function_exists('idn_to_ascii') && sscanf($str, '%[^@]@%s', $name, $domain) === 2)
	{
		$str = $name.'@'.idn_to_ascii($domain);
	}

	return (bool) filter_var($str, FILTER_VALIDATE_EMAIL);
}


function valid_emails($str)
{
	if (strpos($str, ',') === FALSE)
	{
		return valid_email(trim($str));
	}

	foreach (explode(',', $str) as $email)
	{
		if (trim($email) !== '' && valid_email(trim($email)) === FALSE)
		{
			return FALSE;
		}
	}

	return TRUE;
}