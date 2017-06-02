this.main = null;
delete this.main;
this.main = new Object();
//
this.main.init = function(){
	$("[name=btn-create]").click(this.createAnother_click_handler.bind(this));
	$("[name=btn-back]").click(function(){window.location="user/get";});
	this.getRole();
}
this.main.show_status = function(show, msg, $elem){
	$elem = ($($elem).length>0) ? $($elem) : $("div.div_alert");
	if(show && msg){
		$elem.removeClass("hidden");
		$elem.html(msg);
	}else{
		$elem.addClass("hidden");
		$elem.text("");
	}
}

/**/
this.main.reset_click_handler = function(ev){
	this.form_reset();
}
this.main.save_click_handler = function(ev){
	this.form_submit();
}


/**/
this.main.getRole = function(){
	this.show_status(true, "<i class='fa fa-spinner fa-spin'></i> Retrieving Roles..", $(".notificationBar"));
	helper_API.sendXHR({
		action:"role get",
		path:"/roles",
		method:"GET",
		data:null,
		success_handler:this.getRole_handler.bind(this),
		error_handler:this.getRole_handler.bind(this)
	});
}
this.main.getRole_handler = function(result){
	try{
		result = JSON.parse(result);
	}catch(err){
		var msg = (result.responseText) ? result.responseText : "Error. Parsing failed";
		this.show_status(true, result.responseText, $(".notificationBar"));
	}
	// Parse roles
	if(String(result.responseStatus).toUpperCase() == "SUCCESS"){
		this.show_status(false);
		var data=result.data;
		for(var i=0; i<data.length; i++){
			$("select[name=rolecode]").append("<option value='"+data[i].role_code+"'>"+data[i].role_name+"</option>");
		}
	}else{
		var msg = (result.responseText) ? result.responseText : "Error. Parsing failed";
		this.show_status(true, result.responseText, $(".notificationBar"));
	}
	// Get profile data
	this.getData();
}


this.main.getData = function(){
	this.id = $("input[name=id]").val();
	if(this.id != "" && this.id != "0"){
		this.show_status(true, "<i class='fa fa-spinner fa-spin'></i> Retrieving Profile..", $(".notificationBar"));
		$("input[name=email],input[name=password]").prop("disabled",1);
		$("input[name=email],input[name=password]").attr("editable","0");
		$("input[name=password]").attr("type","password");
		$("input[name=password]").val("123456789");
		$("button[name=btn-save]").text("Save");
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
	}catch(err){
		var msg = (result.responseText) ? result.responseText : "Error. Parsing failed";
		this.show_status(true, result.responseText, $(".notificationBar"));
	}
	//
	if(String(result.responseStatus).toUpperCase() == "SUCCESS"){
		this.show_status(false);
		this.parseResult(result);
	}else{
		var msg = (result.responseText) ? result.responseText : "Error. Parsing failed";
		this.show_status(true, result.responseText, $(".notificationBar"));
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
	var id = $("input[name=id]").val();
	var data = new Object();
	data.email = $("input[name=email]").val();
	data.passconf = data.password = $("input[name=password]").val();
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
	if(data.first_name == ""){eM.push("First name is required"); eF = false;}
	if(data.last_name == ""){eM.push("Last name is required"); eF = false;}
	if(data.contact == ""){eM.push("Phone is required"); eF = false;}
	if((String(id) == "0" || id == "") && data.password == ""){eM.push("Password is required"); eF = false;}
	//
	if(!eF){
		$("div.submissionResult").html(eM.join("<br/>"));
		return null;
	}else{
		$("input, select").prop("disabled",1);
	}
	//
	var method = (String(id) != "0" && id != "") ? "PUT" : "POST";
	var path = (String(id) != "0" && id != "") ? "/users/"+id : "/users";
	if(String(id) != "0" && id != ""){
		delete data.email;
		delete data.password;
		delete data.passconf;
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