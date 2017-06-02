this.main = null;
delete this.main;
this.main = new Object();
//
this.main.init = function(){
	$("[name=btn-create]").click(this.createAnother_click_handler.bind(this));
	//
	this.list_table = new ihl0700_cTable();
	this.list_table.table_update = function(d){
		this.requestMainList(d);
	}
	this.list_table.table_update_handler = function(d){
		console.log("table_update_handler");
	}
	// Init table
	this.list_table.constructor({
		$table				: $("table#mainList"),
		url					: this.url,
		requestFunction		: this.list_table.table_update.bind(this),
		callbackFunction	: this.list_table.table_update_handler
	});
	$("table#mainList").closest(".ihl0700_cTable").find(".ihl0700_cTable_search input[name=search]").attr("placeholder", "Title, Brand, Contact");
	$("[name=btn-add]").click(this.add_click_handler.bind(this));
	//
	$("th[colName=selection-all]").click(this.selectAll_click_handler.bind(this));
	$("button[name='btn-deleteSelected']").click(this.deleteSelected_click_handler.bind(this));
	$("button[name='btn-passwordChange']").click(this.passwordChange_click_handler.bind(this));
	$("button[name='btn-passwordChangeExec']").click(this.passwordChangeExec_click_handler.bind(this));
	//
	var user = helper_API.session_get();
	this.getData(user.data.user_id);
}
this.main.requestMainList = function(data){
	var limit = ($("table#mainList").closest(".ihl0700_cTable").find(".ihl0700_cTable_display select").val());
	if(data){
		if(data.perPage){
			data.limit = data.perPage;
			data.perPage = null;
			delete data.perPage;
		}
		if(data.page){
			//data.offset = data.page;
			data.page = null;
			delete data.page;
		}
	}
	if(!data){
		var data = new Object({limit:limit});
	}
	helper_API.sendXHR({
		action:"get my assets",
		path:"/me/assets",
		method:"GET",
		data:data,
		success_handler:this.getUserAsset_handler.bind(this),
		error_handler:this.getUserAsset_handler.bind(this)
	});
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
		$("input[name=email]").attr("editable","0");
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
			//
			this.getUserAsset();
		}else{
			$("div.alertProfile").removeClass("hidden");
			$("div.alertProfile").html(result.responseText);
		}
	}catch(err){
		$("div.alertProfile").removeClass("hidden");
		$("div.alertProfile").html(result.responseText);
	}
}
this.main.parseResult = function(data){
	var list = data.data;
	this.initialData = list;
	this.form_reset();
}



/**/
this.main.getUserAsset = function(){
	if(this.id != "" && this.id != "0"){
		helper_API.sendXHR({
			action:"user get",
			path:"/me/assets",
			method:"GET",
			data:null,
			success_handler:this.getUserAsset_handler.bind(this),
			error_handler:this.getUserAsset_handler.bind(this)
		});
	}else{
		$("button[name=btn-save]").text("Create");
	}
	//
	$("[name=btn-save]").click(this.save_click_handler.bind(this));
	$("[name=btn-reset]").click(this.reset_click_handler.bind(this));
}
this.main.getUserAsset_handler = function(result){
	try{
		result = JSON.parse(result);
		if(String(result.responseStatus).toUpperCase() == "SUCCESS"){
			this.parseAssetResult(result);
		}else{
			$("div.alertAsset").removeClass("hidden");
			$("div.alertAsset").html(result.responseText);
		}
	}catch(err){
		$("div.alertAsset").removeClass("hidden");
		$("div.alertAsset").html(result.responseText);
	}
}
this.main.parseAssetResult = function(data){
	$("table#mainList tbody").empty();
	//
	var offset = (Number($("table#mainList").attr("page"))-1) * Number($("table#mainList").attr("display"));
	var list = data.data;
	for(var idx=0; idx<list.length; idx++){
		var $item = $("tr#template-mainList-row").clone();
		$item.attr("index", "asset-"+idx);
		$item.attr("id", list[idx].asset_id);
		$item.attr("src", list[idx].link_download);
		$item.attr("asset_type", list[idx].asset_type);
		$item.find("[colName=index]").html(offset+(idx+1));
		for(n in list[idx]){
			if(list[idx][n]=="") list[idx][n]="-"
			$item.find("[colname="+n+"]").html(list[idx][n]);
		}
		$item.find("[name=btn-detail]").click(this.detail_click_handler.bind(this));
		$item.find("[name=btn-delete]").click(this.delete_click_handler.bind(this));
		$item.find("[name=btn-download]").click(this.download_click_handler.bind(this));
		$item.find("[colName=selection]").click(this.select_click_handler.bind(this));
		//
		$("table#mainList > tbody").append($item);
	}
	this.list_table.update(data);
}
this.main.add_click_handler = function(ev){
	window.location = "asset/0/get?ref=profile";
}
this.main.detail_click_handler = function(ev){
	var $item = $(ev.target).closest("tr[id]");
	var id = $item.attr("id");
	var asset_type = $item.attr("asset_type");
	window.location = "asset/"+asset_type+"/"+id+"/get?ref=profile";
}
this.main.download_click_handler = function(ev){
	var $tr = $(ev.target).closest("tr");
	console.log($tr);
	var url = api_url+$tr.attr("src");
	$("iframe[name='iframe-assetDownload']").attr("src", url);
}
this.main.delete_click_handler = function(ev){
	var $item = $(ev.target).closest("tr[id]");
	var id = $item.attr("id");
	var name = $item.find("[colName=title]").text();
	if(confirm("Delete Asset '"+name+"'?")){
		this.form_delete(id);
	}
}

/**/
this.main.form_delete = function(id, handler){
	if(!handler) handler = this.delete_handler;
	helper_API.sendXHR({
		action:"Asset delete",
		path:"/assets/"+id,
		method:"DELETE",
		data:null,
		success_handler:handler.bind(this),
		error_handler:handler.bind(this)
	});
}
this.main.delete_handler = function(result){
	console.log(result);
	this.list_table.request_data();
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
		action:"user update",
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
		$("div.submissionResult").html("Update profile success");
		//
		$("input, select").prop("disabled",null);
		$("[editable=0]").prop("disabled",1);
		//
		$("[name=btn-reset]").removeClass("hidden");
		$("[name=btn-save]").removeClass("hidden");
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





/* Change Password */
this.main.passwordChange_click_handler = function(ev){
	$(".password-edit").removeClass("hidden");
	$("button[name='btn-passwordChange']").addClass("hidden");
}
this.main.passwordChangeExec_click_handler = function(ev){
	$("div.passwordSubmissionResult").removeClass("hidden");
	//
	var data = new Object();
	data.oldpassword = $("input[name=oldpassword]").val();
	data.password = $("input[name=password]").val();
	data.passconf = $("input[name=passconf]").val();
	//
	var eF = true;
	var eM = new Array();
	if(data.oldpassword == ""){eM.push("Please type current password"); eF = false;}
	if(data.password == ""){eM.push("Please type new password"); eF = false;}
	if(data.password != data.passconf){eM.push("New Password doesn't match"); eF = false;}
	if(!eF){
		$("div.passwordSubmissionResult").html(eM.join("<br/>"));
		return null;
	}else{
		$("div.passwordSubmissionResult").html("<i class='fa fa-spin fa-spinner'></i> Update password..");
		$("input[type='password']").prop("disabled",1);
	}
	
	var method = "PUT";
	var path = "/profile/password";
	helper_API.sendXHR({
		action:"password update",
		path:path,
		method:method,
		data:data,
		success_handler:this.passwordChange_handler.bind(this),
		error_handler:this.passwordChange_handler.bind(this)
	});
	
}
this.main.passwordChange_handler = function(result){
	$("input[type='password']").prop("disabled", null);
	$("[editable=0]").prop("disabled",1);
	if(!result.error){
		$("div.passwordSubmissionResult").html("Password change success");
	}else{
		$("div.passwordSubmissionResult").html("Error. Password remain unchanged");
	}
}






/* Checklist selectables */
this.main.deleteSelected_click_handler = function(ev){
	$("button[name='btn-deleteSelected']").addClass("hidden");
	//
	var $tr = $("table td i[name='icon-selection'].fa-check-square").closest("tr");
	this.$selectedTd = new Array();
	for(var i=0; i<$tr.length; i++){
		this.$selectedTd.push($($tr.get(i)).attr("id"));
	}
	this.delTotal = this.$selectedTd.length;
	//
	var $ntf = $("div.deleteResult");
	$ntf.removeClass("hidden");
	$ntf.html("<i class='fa fa-spin fa-spinner'></i> Deleting.. (0 of "+$tr.length+")");
	//
	this.deleteSelected_exec();
}
this.main.deleteSelected_exec = function(result){
	//console.log(result);
	var $ntf = $("div.deleteResult");
	$ntf.removeClass("hidden");
	$ntf.html("<i class='fa fa-spin fa-spinner'></i> Deleting.. ("+(this.delTotal-this.$selectedTd.length)+" of "+this.delTotal+")");
	//
	if(result && result.status && result.status==500){
		$ntf.html("<i class='fa fa-times'></i> Delete failed: Only user who upload the asset can delete it. Deleting process terminated.");
		this.$selectedTd = null;
		clearTimeout(this.refreshTableTimeout);
		this.refreshTableTimeout = setTimeout(this.deleteSelected_refresh.bind(this), 5000);
	}else{
		if(this.$selectedTd.length>0){
			var cid = this.$selectedTd.pop();
			this.form_delete(cid, this.deleteSelected_exec);
		}else{
			$ntf.html("<i class='fa fa-check'></i> Delete completed");
			clearTimeout(this.refreshTableTimeout);
			this.refreshTableTimeout = setTimeout(this.deleteSelected_refresh.bind(this), 2000);
		}
	}
}
this.main.deleteSelected_refresh = function(){
	clearTimeout(this.refreshTableTimeout);
	$("button[name='btn-deleteSelected']").removeClass("hidden");
	this.select_setState($("th[colName='selection-all']"), false);
	this.list_table.request_data();
}
this.main.selectAll_click_handler = function(ev){
	var $th = $(ev.target).closest("th");
	var state = ($th.find("i[name='icon-selection']").hasClass("fa-square-o")) ? true : false;
	this.select_setState($th, state);
	//
	var $table = $th.closest("table");
	var $td = $table.find("tr > td[colName='selection']");
	this.select_setState($td, state);
}
this.main.select_click_handler = function(ev){
	var $td = $(ev.target).closest("td");
	var state = ($td.find("i[name='icon-selection']").hasClass("fa-square-o")) ? true : false;
	this.select_setState($td, state);
}
this.main.select_setState = function(elem, state){
	var $icon = $(elem).find("i[name='icon-selection']");
	if(state){
		$icon.removeClass("fa-square-o");
		$icon.addClass("fa-check-square");
	}else{
		$icon.addClass("fa-square-o");
		$icon.removeClass("fa-check-square");
	}
	this.select_checkOverallState(elem);
}
this.main.select_checkOverallState = function(elem){
	$sel = $(elem).closest("table").find("td i[name='icon-selection'].fa-check-square");
	var ens = ($sel.length > 0) ? null : true;
	$("button[name='btn-deleteSelected']").prop("disabled", ens);
}



this.main.init();