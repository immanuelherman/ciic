<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array();
/* 
* you can set multiple method wich can passed here as array. example array("GET", "POST", "PUT")
* to allow whitelist routes. no trailing slash!
* to allow only numeric value use (:num), to allow not specific type you can use (:any)
* set header key for authorization
*/
#====================ROUTES===================================
$config['whitelist']["/users/login"] = array("POST"); 

$config['whitelist']["/users/(:num)/picture"] = array("GET", "POST"); 
$config['whitelist']["/common/(:any)"] = array("GET");

#===================HEADER====================================
$config['header']['authorization'] = "Authorization";
$config['header']['date'] = "X-Uciic-Date";
$config['header']['prefix_upn'] = "Uciic";
$config['header']['site_url'] = "X-Site-Url";
$config['secret_key']['key'] = "secret_key";