<html>
	<head>
		<base href="<?php echo($config->item('html_base'));?>" target="_blank">
		<title><?php echo($title);?></title>
		<link rel="stylesheet" type="text/css" href="_lib/fonts/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="_lib/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="_lib/js/ihl0700/cTable/cTable.css">
		<link rel="stylesheet" type="text/css" href="_lib/css/base.css">
		<link rel="stylesheet" type="text/css" href="_lib/css/ciic.css">
	</head>
	<body>
		<!-- jQuery -->
		<script type="text/javascript" src="_lib/js/jquery/jquery-1.12.3.min.js"></script>
		<!-- helpers -->
		<script type="text/javascript" src="_lib/js/ciic_api.js"></script>
		<!-- encryption -->
		<script type="text/javascript" src="_lib/js/jsSHA/sha512.js"></script>
		<!-- momentjs -->
		<script type="text/javascript" src="_lib/js/momentjs/moment.min.js"></script>
		<!-- momentjs -->
		<script type="text/javascript" src="_lib/js/ihl0700/cTable/cTable.js"></script>
		<!-- Config -->
		<script type="text/javascript">
			var base_path = "<?php echo($config->item('html_base'));?>";
			var api_url = "<?php echo($config->item('api_url'));?>";
			var browserCompatible = helper_API.browserCompatibilityCheck();
		</script>
		