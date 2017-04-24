this.main = null;
delete this.main;
this.main = new Object();
//
this.main.init = function(){
	$("[name=btn-create]").click(this.createAnother_click_handler.bind(this));
	$("[name=btn-fileUpload]").click(this.uploadFile_click_handler.bind(this));
	
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
	
	//
	this.getData();
}


/**/
this.main.reset_click_handler = function(ev){
	this.form_reset();
}
this.main.save_click_handler = function(ev){
	this.form_submit();
}


this.main.getData = function(){
	this.id = $("input[name=id]").val();
	if(this.id != "" && this.id != "0"){
		$("button[name=btn-save]").text("Save");
		helper_API.sendXHR({
			action:"user get",
			path:"/collections/"+this.id,
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
	//
	this.getFiles();
}
this.main.parseResult = function(data){
	var list = data.data;
	this.initialData = list;
	this.form_reset();
}



/**/
this.main.getFiles = function(){
	this.id = $("input[name=id]").val();
	helper_API.sendXHR({
		action:"user get",
		path:"/collections/"+this.id+"/file",
		method:"GET",
		data:null,
		success_handler:this.getFile_handler.bind(this),
		error_handler:this.getFile_handler.bind(this)
	});
}
this.main.getFile_handler = function(result){
	try{
		result = JSON.parse(result);
		this.parseList(result);
	}catch(err){
		$("div.div_alert").removeClass("hidden");
		$("div.div_alert").html(result.responseText);
	}
}
this.main.parseList = function(data){
	$("table#mainList tbody").empty();
	//
	var offset = (Number($("table#mainList").attr("page"))-1) * Number($("table#mainList").attr("display"));
	var list = data.data;
	if(list.length>0 && list[0].origin_name) $(".assetFilesList").removeClass("hidden");
	//
	for(var idx=0; idx<list.length; idx++){
		var $item = $("tr#template-mainList-row").clone();
		$item.attr("index", this.listName+"-"+idx);
		$item.attr("id", list[idx].collection_id);
		$item.find("[colName=index]").html(offset+(idx+1));
		$item.find("[colName=1]").html(list[idx].origin_name);
		$item.find("[colName=2]").html(list[idx].src);
		$item.find("[colName=3]").html(list[idx].size_KB);
		//
		$("table#mainList tbody").append($item);
	}
	this.list_table.update(data);
}

/**/
this.main.form_reset = function(ev){
	if(this.initialData){
		$("input[name=title]").val(this.initialData.collection_name);
	}else{
		$("input[name=title]").val("");
	}
	$("input, select").prop("disabled",null);
	$("[editable=0]").prop("disabled",1);
}



/**/

this.main.form_submit = function(){
	//
	$("div.submissionResult").html("<i class='fa fa-spin fa-spinner'></i> Please wait..");
	$("div.submissionResult").removeClass("hidden");
	//
	var id = $("input[name=id]").val();
	var data = new Object();
	data.collection_name = $("input[name=title]").val();
	
	// Validation
	var eM = new Array();
	var eF = true;
	if(data.collection_name == ""){eM.push("Asset title is required"); eF = false;}
	//
	if(!eF){
		$("div.submissionResult").html(eM.join("<br/>"));
		return null;
	}else{
		$("input, select").prop("disabled",1);
	}
	//
	var method = (String(id) != "0" && id != "") ? "PUT" : "POST";
	var path = (String(id) != "0" && id != "") ? "/collections/"+id : "/collections";
	if(String(id) != "0" && id != ""){
		delete data.email;
		delete data.password;
		delete data.passconf;
	}
	
	helper_API.sendXHR({
		action:"collection post",
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
			$("div.submissionResult").html("Create asset success");
			$("[name=btn-create]").removeClass("hidden");
		}else{
			$("div.submissionResult").html("Update asset success");
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

this.main.uploadFile_click_handler = function(ev){
	var files = $("input[name=assetFile]")[0].files;
	console.log(files);
	if(files && files.length>0){
		var data = new FormData();
		for(var i=0; i<files.length; i++){
			data.append('file', files[i]);
		}
		//
		helper_API.uploadFile({
			action:"upload asset",
			path:"/file/zip_extract",
			method:"POST",
			data:data,
			processData:0,
			contentType:0,
			success_handler:this.uploadFile_handler.bind(this),
			error_handler:this.uploadFile_handler.bind(this)
		});
	}
}

this.main.uploadFile_handler = function(result){
	console.log(result);
}



this.main.init();