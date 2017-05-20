<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$code = 500;
http_response_code($code);
$debug_backtrace = array();

if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE)
{
	foreach ($exception->getTrace() as $error)
	{
		$backtrace["File"] = $error['file'];
		$backtrace["Line"] = $error['line'];
		$backtrace["Function"] = $error['function'];
		$debug_backtrace[] = $backtrace;
	}
}

$error = array(
	"apiVersion" => API_VERSION,
	"requestTime" => get_request_time(),
	"responseStatus" => "ERROR",
	"error" => array(
		"code" => $code,
		"message" => strip_tags($message),
		"errors" => array(
			"domain" => "ERROR_EXCEPTION",
			"reason" => "ErorrException",
			"extra" => array(
				"type" => get_class($exception),
				"message" => $message,
				"fileName" => $exception->getFile(),
				"lineNumber" => $exception->getLine(),
				"debugBacktrace" => $debug_backtrace
			)
		)
	)
);
exit(json_encode($error));