this.main = null;
delete this.main;
this.main = new Object();
//
this.main.init = function(){
	$("[name=btn-create]").click(this.createAnother_click_handler.bind(this));
	var user = helper_API.session_get();
	this.getData(user.data.user_id);
}


/**/
this.main.reset_click_handler = function(ev){
	this.form_reset();
}
this.main.save_click_handler = function(ev){
	this.form_submit();
}



/**/
this.main.getData = function(id){
	this.id = id;
	if(this.id != "" && this.id != "0"){
		$("input[name=email], input[type=password]").prop("disabled",1);
		$("input[name=email], input[type=password]").attr("editable","0");
		$("button[name=btn-save]").text("Update Profile");
		helper_API.sendXHR({
			action:"user get",
			path:"/users/"+this.id,
			method:"GET",
			data:null,
			success_handler:this.getList_handler.bind(this),
			error_handler:this.getList_handler.bind(this)
		});
	}else{
		$("button[name=btn-save]").text("Create");
	}
	//
	$("[name=btn-save]").click(this.save_click_handler.bind(this));
	$("[name=btn-reset]").click(this.reset_click_handler.bind(this));
}

this.main.getList_handler = function(result){
	try{
		result = JSON.parse(result);
		if(String(result.responseStatus).toUpperCase() == "SUCCESS"){
			this.parseResult(result);
		}else{
			$("div.div_alert").removeClass("hidden");
			$("div.div_alert").html(result.responseText);
		}
	}catch(err){
		$("div.div_alert").removeClass("hidden");
		$("div.div_alert").html(result.responseText);
	}
}
this.main.parseResult = function(data){
	var list = data.data;
	this.initialData = list;
	this.form_reset();
}


/**/
this.main.form_reset = function(ev){
	if(this.initialData){
		$("input[name=email]").val(this.initialData.email);
		$("input[name=firstname]").val(this.initialData.first_name);
		$("input[name=lastname]").val(this.initialData.last_name);
		$("input[name=department]").val(this.initialData.department);
		$("input[name=jobtitle]").val(this.initialData.job_title);
		$("input[name=phone]").val(this.initialData.contact);
		$("input[name=country]").val(this.initialData.country);
		$("select[name=rolecode]").val(this.initialData.role_code);
		$("select[name=activestatus]").val(this.initialData.is_active);
	}else{
		$("input[name=email]").val("");
		$("input[name=firstname]").val("");
		$("input[name=lastname]").val("");
		$("input[name=department]").val("");
		$("input[name=jobtitle]").val("");
		$("input[name=phone]").val("");
		$("input[name=country]").val("");
		$("select[name=rolecode]")[0].selectedIndex = 0;
		$("select[name=activestatus]")[0].selectedIndex = 0;
	}
	$("input, select").prop("disabled",null);
	$("[editable=0]").prop("disabled",1);
}



/**/
this.main.validateEmail = function(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
this.main.form_submit = function(){
	//
	$("div.submissionResult").html("<i class='fa fa-spin fa-spinner'></i> Please wait..");
	$("div.submissionResult").removeClass("hidden");
	//
	var id = this.id;
	var data = new Object();
	data.email = $("input[name=email]").val();
	data.password = $("input[name=password]").val();
	data.passconf = $("input[name=passconf]").val();
	data.first_name = $("input[name=firstname]").val();
	data.last_name = $("input[name=lastname]").val();
	data.department = $("input[name=department]").val();
	data.job_title = $("input[name=jobtitle]").val();
	data.contact = $("input[name=phone]").val();
	data.country = $("input[name=country]").val();
	data.role_code = $("select[name=rolecode]").val();
	data.is_active = $("select[name=activestatus]").val();
	
	// Validation
	var eM = new Array();
	var eF = true;
	if(data.email == "" || !this.validateEmail(data.email)){eM.push("Invalid Email"); eF = false;}
	if(data.password != "" && data.password != data.passconf){
		eM.push("Password doesn't match"); eF = false;
	}else{
		delete data.password;
		delete data.passconf;
	}
	if(data.first_name == ""){eM.push("First name is required"); eF = false;}
	if(data.last_name == ""){eM.push("Last name is required"); eF = false;}
	if(data.contact == ""){eM.push("Phone is required"); eF = false;}
	//
	if(!eF){
		$("div.submissionResult").html(eM.join("<br/>"));
		return null;
	}else{
		$("input, select").prop("disabled",1);
	}
	//
	var method = "PUT";
	var path = "/users/"+id;
	if(String(id) != "0" && id != ""){
		delete data.email;
	}
	
	helper_API.sendXHR({
		action:"user post",
		path:path,
		method:method,
		data:data,
		success_handler:this.save_handler.bind(this),
		error_handler:this.save_handler.bind(this)
	});
	
	if(String(id) == "0" || id == ""){
		$("[name=btn-reset]").addClass("hidden");
		$("[name=btn-save]").addClass("hidden");
	}
}

this.main.save_handler = function(result){
	try{
		var json = JSON.parse(result);
		$("div.submissionResult").html(json.responseText);
		var id = $("input[name=id]").val();
		//
		if(String(id) == "0" || id == ""){
			$("div.submissionResult").html("Create user success");
			$("[name=btn-create]").removeClass("hidden");
		}else{
			$("div.submissionResult").html("Update user success");
			//
			$("input, select").prop("disabled",null);
			$("[editable=0]").prop("disabled",1);
			//
			$("[name=btn-reset]").removeClass("hidden");
			$("[name=btn-save]").removeClass("hidden");
		}
	}catch(err){
		$("div.submissionResult").html("Error: "+result.responseText);
		$("input, select").prop("disabled",null);
		$("[editable=0]").prop("disabled",1);
		$("[name=btn-reset]").removeClass("hidden");
		$("[name=btn-save]").removeClass("hidden");
	}
	$("div.submissionResult").removeClass("hidden");
}
this.main.createAnother_click_handler = function(ev){
	this.form_reset();
	//
	$("div.submissionResult").addClass("hidden");
	$("[name=btn-create]").addClass("hidden");
	$("[name=btn-reset]").removeClass("hidden");
	$("[name=btn-save]").removeClass("hidden");
}




this.main.init();