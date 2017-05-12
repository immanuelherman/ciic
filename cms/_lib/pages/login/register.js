this.register = null;
delete this.register;
this.register = new Object();
//
this.register.init = function(){
	$("button#register_submit").unbind();
	$("button#register_cancel").unbind();
	//
	$("button#register_submit").click(this.save_click_handler.bind(this));
	$("button#register_cancel").click(this.cancel_click_handler.bind(this));
	//
	$("button#register_cancel").removeClass("hidden");
	$("button#register_submit").removeClass("hidden");
	//
	$("div.submissionResult").text("");
	$("div.submissionResult").addClass("hidden");
}
this.register.save_click_handler = function(ev){
	this.form_submit();
}
this.register.cancel_click_handler = function(ev){
	$(".login_container").removeClass("hidden");
	$(".register_container").addClass("hidden");
}

this.register.validateEmail = function(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
this.register.form_submit = function(){
	//
	$("div.submissionResult").html("<i class='fa fa-spin fa-spinner'></i> Please wait..");
	$("div.submissionResult").removeClass("hidden");
	//
	var id = 0;
	var data = new Object();
	data.email = $("input[name=email]").val();
	data.passconf = $("input[name=passconf]").val();
	data.password = $("input[name=password]").val();
	data.first_name = $("input[name=firstname]").val();
	data.last_name = $("input[name=lastname]").val();
	data.department = $("input[name=department]").val();
	data.job_title = $("input[name=jobtitle]").val();
	data.contact = $("input[name=phone]").val();
	data.country = $("input[name=country]").val();
	data.role_code = $("select[name=rolecode]").val();
	data.is_active = $("select[name=activestatus]").val();
	
	//console.log(data);
	
	// Validation
	var eM = new Array();
	var eF = true;
	if(data.email == "" || !this.validateEmail(data.email)){eM.push("Invalid Email"); eF = false;}
	if(data.password == "" || data.password != data.passconf){eM.push("Password is empty or doesn't match"); eF = false;}
	if(data.first_name == ""){eM.push("First name is required"); eF = false;}
	if(data.last_name == ""){eM.push("Last name is required"); eF = false;}
	if(data.contact == "" || data.contact.length<6){eM.push("Phone is required and must at least 6 characters length"); eF = false;}
	if((String(id) == "0" || id == "") && data.password == ""){eM.push("Password is required"); eF = false;}
	//
	if(!eF){
		$("div.submissionResult").html(eM.join("<br/>"));
		$("button#register_cancel").removeClass("hidden");
		$("button#register_submit").removeClass("hidden");
		return null;
	}else{
		$("input, select, textarea").prop("disabled",1);
		$("button#register_cancel").addClass("hidden");
		$("button#register_submit").addClass("hidden");
	}
	//
	var method = (String(id) != "0" && id != "") ? "PUT" : "POST";
	var path = (String(id) != "0" && id != "") ? "/users/"+id : "/users";
	if(String(id) != "0" && id != ""){
		delete data.email;
		//delete data.password;
		//delete data.passconf;
	}
	
	helper_API.sendXHR({
		action:"user post",
		path:path,
		method:method,
		data:data,
		success_handler:this.save_handler.bind(this),
		error_handler:this.save_handler.bind(this)
	});
	
}

this.register.save_handler = function(result){
	$("input, select, textarea").prop("disabled",null);
	//
	try{
		var json = JSON.parse(result);
		if(json.responseStatus == "SUCCESS"){
			$("div.submissionResult").html("Registration success. Site admin will process your request.<br/><a name='linkback' href='javascript:void(0);'> Back to login page</a>");
			$("a[name='linkback']").click(this.cancel_click_handler.bind(this));
		}
	}catch(err){
		var failMsg = (result.responseJSON.error.message);
		$("div.submissionResult").html("Registration Failed. "+failMsg);
		$("button#register_cancel").removeClass("hidden");
		$("button#register_submit").removeClass("hidden");
	}
	$("div.submissionResult").removeClass("hidden");
}


this.register.init();
