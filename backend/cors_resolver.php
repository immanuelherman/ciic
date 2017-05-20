<?php
if (!empty($_SERVER['REQUEST_METHOD']))
{
	if ($_SERVER['REQUEST_METHOD']=='OPTIONS') 
	{
		header('Access-Control-Allow-Origin : *');
		header("Access-Control-Allow-Credentials: true");
		header('Access-Control-Allow-Methods : POST, GET, OPTIONS, PUT, DELETE');
		header("Access-Control-Allow-Headers: Authorization, X-Uciic-Date, X-Site-Url, X-Requested-With, Origin, Content-Type, Accept, Access-Control-Request-Method");
		die;
	}
	header("Access-Control-Allow-Origin: *");
}

