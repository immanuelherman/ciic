<?php
/**
 * Graph
 *
 * @package	Graph
 * @author	ari@djemana.com, Marianus Djemana.com
 * @copyright	Copyright (c) 2016, Djemana Development (http://djemana.com)
 * @link	http://djemana.com
 * @since	Version 1.0.0
 * @filesource
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class My_http {

	protected $url;
	protected $header = array();
	protected $method = 'GET';
	protected $agent = 'My_http';
	protected $body;
	protected $digest;
	protected $content_type = 'text/html';
	protected $debug = FALSE;
	protected $header_out;

	public function __construct($config = array())
	{
		$this->CI =& get_instance();
	}

	public function initialize($config = array())
	{
		foreach ($config as $key => $value) 
		{
			$this->$key = $value;
		}
	}

	public function request($config = array())
	{
		if (!empty($config))
		{
			$this->initialize($config);
		}

		$ch = curl_init();
        $headers = array();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->agent);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->body);

        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 0); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 0); //timeout in seconds
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method);

        if (isset($this->header_out))
        {
        	curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        }


        foreach ($this->header as $key => $value) {
        	$headers[] = $key.': '.$value;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $server_output = curl_exec($ch);
        curl_close ($ch);
        return $server_output;
	}
}