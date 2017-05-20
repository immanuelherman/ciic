<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$code = 500;
http_response_code($code);
$debug_backtrace = array();

if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE)
{
	foreach (debug_backtrace() as $error)
	{
		if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0)
		{
			$backtrace["File"] = $error['file'];
			$backtrace["Line"] = $error['line'];
			$backtrace["Function"] = $error['function'];
			$debug_backtrace[] = $backtrace;
		}
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
			"domain" => "ERRORSYSTEM",
			"reason" => "ErrorSystemException",
			"extra" => array(
				"message" => $message,
				"severity" => $severity,
				"fileName" => $filepath,
				"lineNumber" => $line,
				"debugBacktrace" => $debug_backtrace
			)
		)
	)
);
exit(json_encode($error));
?>

<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>A PHP Error was encountered</h4>

<p>Severity: <?php echo $severity; ?></p>
<p>Message:  <?php echo $message; ?></p>
<p>Filename: <?php echo $filepath; ?></p>
<p>Line Number: <?php echo $line; ?></p>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

	<p>Backtrace:</p>
	<?php foreach (debug_backtrace() as $error): ?>

		<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

			<p style="margin-left:10px">
			File: <?php echo $error['file'] ?><br />
			Line: <?php echo $error['line'] ?><br />
			Function: <?php echo $error['function'] ?>
			</p>

		<?php endif ?>

	<?php endforeach ?>

<?php endif ?>

</div>