this.main = null;
delete this.main;
this.main = new Object();
//
this.main.init = function(){
	helper_API.session_destroy();
	//
	$("button#register").click(this.register_click_handler.bind(this));
	$("button#login").click(this.login_click_handler.bind(this));
	//
	$("input.login_input#username").keypress(this.enter_keypress_handler.bind(this));
	$("input.login_input#password").keypress(this.enter_keypress_handler.bind(this));
}

this.main.enter_keypress_handler = function(ev){
	if(ev.which == 13) this.login_click_handler(null);
}

this.main.register_click_handler = function(ev){
	$(".login_container").addClass("hidden");
	$(".register_container").removeClass("hidden");
	register.init();
}

this.main.login_click_handler = function(ev){
	helper_API.session_destroy();
	//
	var data = new Object();
	data.email = $("input#username").val();
	data.password = $("input#password").val();
	//
	$(".div_alert").html("<i class='fa fa-spin fa-spinner'></i> Signing In..");
	$(".div_alert").removeClass("hidden");
	$("button#login").prop("disabled", 1);
	$("button#register").prop("disabled", 1);
	//
	if(email!="" && password!=""){
		helper_API.sendXHR({
			action:"login",
			path:"/users/login",
			method:"POST",
			data:data,
			success_handler:this.login_post_handler,
			error_handler:this.login_post_handler
		});
	}
}

this.main.login_post_handler = function(result){
	try{
		result = JSON.parse(result);
		if(String(result.responseStatus).toUpperCase() == "SUCCESS"){
			$(".div_alert").html("");
			$(".div_alert").addClass("hidden");
			//
			var session = new Object();
			session.user_id = result.data.user_id;
			session.email = result.data.email;
			session.secret_key = result.secret_key;
			session.picture = result.data.picture;
			helper_API.session_set(session);
			//
			window.location.replace("profile");
		}
	}catch(err){
		result = JSON.parse(result.responseText);
		console.log(result);
		$(".div_alert").removeClass("hidden");
		$(".div_alert").html(result.error.message);
		//
		$("button#login").prop("disabled", null);
		$("button#register").prop("disabled", null);
	}
}





this.main.init();