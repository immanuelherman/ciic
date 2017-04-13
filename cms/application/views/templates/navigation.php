<link rel="stylesheet" type="text/css" href="_lib/pages/navigation/navigation.css">

<section>
	<div class="navigation-top">
	</div>
</section>
<section>
	<div class="navigation-left">
		<div class="navigation_logo"><img src="_lib/css/images/logo.png" width="100%"></div>
		<div>
			<ul class="navigation-list">
				<li navigation-id="profile"><a href="profile" target="_self">My Account</a></li>
				<li><a href="login" target="_self">Log Out</a></li>
			</ul>
		</div>
		<div class="separator-top" style="text-align:center;">
			<button class="btn-green" style="width:100%; margin-bottom:10px; font-size:10pt;"><i class="fa fa-upload"></i> Upload Asset</button>
		</div>
		<div>
			<ul class="navigation-list">
				<li navigation-id="posm"><a href="asset/posm" target="_self">POSM</a></li>
				<li navigation-id="product"><a href="asset/product" target="_self">Products</a></li>
				<li navigation-id="store"><a href="asset/store" target="_self">Store</a></li>
				<li navigation-id="executable"><a href="asset/executable" target="_self">Executables</a></li>
			</ul>
		</div>
		<div class="separator-top">
			<ul class="navigation-list">
				<li navigation-id="user"><a href="user/get" target="_self">Manage User</a></li>
				<li navigation-id="asset"><a href="asset/get" target="_self">Manage Assets</a></li>
			</ul>
		</div>
	</div>
</section>

<!-- JS -->
<script>
	var activeNav = "<?php echo($navigation);?>";
	if(activeNav!=""){
		console.log(activeNav);
		$("li[navigation-id="+activeNav+"]").addClass("active");
	}
</script>
	