this.main = null;
delete this.main;
this.main = new Object();
//
this.main.init = function(){
	var ref = getUrlParameters("ref");
	if(ref) $("a[name=link-back]").attr("href", ref);
	
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
			action:"asset get",
			path:"/assets/"+this.id,
			method:"GET",
			data:null,
			success_handler:this.getList_handler.bind(this),
			error_handler:this.getList_handler.bind(this)
		});
	}else{
		var asset_type = getUrlParameters("type");
		$("select[name=assetType]").val(asset_type);
		//
		$("select[name=assetType]").prop("disabled", null);
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
	//this.getFiles();
}
this.main.parseResult = function(data){
	var list = data.data;
	this.initialData = list;
	this.form_reset();
}



/**/
this.main.parseFileList = function(data){
	$("table#mainList tbody").empty();
	//
	var offset = (Number($("table#mainList").attr("page"))-1) * Number($("table#mainList").attr("display"));
	var list = data;
	if(list.length>0 && list[0].origin_name) $(".assetFilesList").removeClass("hidden");
	//
	for(var idx=0; idx<list.length; idx++){
		var $item = $("tr#template-mainList-row").clone();
		$item.attr("index", "file-"+idx);
		$item.attr("id", list[idx].file_id);
		$item.attr("src", list[idx].src);
		$item.find("[colName=index]").html(offset+(idx+1));
		$item.find("[colName=1]").html(list[idx].origin_name);
		$item.find("[colName=2]").html(list[idx].type);
		$item.find("[colName=3]").html(list[idx].size_KB);
		//
		$item.find("button[name='btn-assetDownload']").click(this.assetDownload_click_handler.bind(this));
		//
		$("table#mainList tbody").append($item);
	}
	this.list_table.update(data);
}
this.main.assetDownload_click_handler = function(ev){
	var $tr = $(ev.target).closest("tr");
	var src = "/get_files"+$tr.attr("src");
	$("iframe[name=assetFilesIframe]").attr("src",api_url+src);
}


/**/
this.main.parseThumbnail = function(data){
	if(data){
		$("div.assetThumbnailList").removeClass("hidden");	
		$("div.assetThumbnailList .thumbnailContainer").empty();
		var thumbnail = "<img src='"+api_url+data.thumbnail+"' class='assetThumbnailImg'/>";
		$("div.assetThumbnailList .thumbnailContainer").append(thumbnail);
	}
}



/**/
this.main.form_reset = function(ev){
	if(this.initialData){
		$("select[name=assetType]").val(this.initialData.asset_type);
		$("input[name=title]").val(this.initialData.title);
		$("input[name=organizer]").val(this.initialData.organiser);
		$("input[name=objective]").val(this.initialData.objective);
		$("input[name=background]").val(this.initialData.background);
		$("input[name=content]").val(this.initialData.content);
		$("input[name=outcome]").val(this.initialData.outcome);
		$("input[name=repeatable_model]").val(this.initialData.repeatable_model);
		$("input[name=additional_comment]").val(this.initialData.additional_comment);
		$("input[name=phone]").val(this.initialData.phone);
		$("input[name=country]").val(this.initialData.country);
		$("input[name=brand]").val(this.initialData.brand);
		$("input[name=contact]").val(this.initialData.contact);
		$("input[name=channel]").val(this.initialData.channel);
		$("input[name=audience]").val(this.initialData.audience);
		$("input[name=category]").val(this.initialData.category);
		$("input[name=original_store]").val(this.initialData.original_store);
		$("input[name=unilever_contact]").val(this.initialData.unilever_contact);
		$("input[name=key_objective]").val(this.initialData.key_objective);
		$("input[name=status]").val(this.initialData.status);
		$("input[name=owner]").val(this.initialData.owner);
		$("input[name=pivacy_status]").val(this.initialData.pivacy_status);
		$("input[name=workspace]").val(this.initialData.workspace);
		//
		this.parseFileList(this.initialData.files);
		this.parseThumbnail(this.initialData.collection);
	}else{
		$("select[name]").val(0);
		$("input[name]").val("");
	}
	$("input, select, textarea").prop("disabled",null);
	$("[editable=0]").prop("disabled",1);
}



/**/

this.main.form_submit = function(){
	//
	$("div.submissionResult").html("<i class='fa fa-spin fa-spinner'></i> Please wait..");
	$("div.submissionResult").removeClass("hidden");
	//
	var id = $("input[name=id]").val();
	
	// Validation
	var eM = new Array();
	var eF = true;
	if($("input[name=title]").val() == ""){eM.push("Asset title is required"); eF = false;}
	//
	if(!eF){
		$("div.submissionResult").html(eM.join("<br/>"));
		return null;
	}else{
		$("input, select, textarea").prop("disabled",1);
	}
	
	var method, path;
	if(String(id) != "0" && id != ""){
		method = "PUT";
		path = "/assets/"+id;
		var data = new Object();
		data.asset_type = $("select[name=assetType]").val();
		data.title = $("input[name=title]").val();
		data.objective =  $("input[name=objective]").val();
		data.content_overview =  $("input[name=content_overview]").val();
		data.repeatable_model =  $("input[name=repeatable_model]").val();
		data.organiser =  $("input[name=organizer]").val();
		data.background =  $("input[name=background]").val();
		data.additional_comment =  $("input[name=additional_comment]").val();
		data.developer_contact =  $("input[name=developer_contact]").val();
		data.country =  $("input[name=country]").val();
		data.key_objective =  $("input[name=key_objective]").val();
		data.owner =  $("input[name=owner]").val();
		data.workspace =  $("input[name=workspace]").val();
		data.brand =  $("input[name=brand]").val();
		data.channel =  $("input[name=channel]").val();
		data.unilever_contact =  $("input[name=unilever_contact]").val();
		data.status =  $("input[name=status]").val();
		data.privacy_status =  $("input[name=privacy_status]").val();
		data.type =  $("input[name=type]").val();
		
		helper_API.sendXHR({
			action:"asset update",
			path:path,
			method:method,
			data:data,
			success_handler:this.save_handler.bind(this),
			error_handler:this.save_handler.bind(this)
		});
		
	}else{
		method = "POST";
		path = "/upload/zip_extract";
		var data = new FormData();
		data.append("asset_type", $("select[name=assetType]").val());
		data.append("title", $("input[name=title]").val());
		data.append("collection_name", $("input[name=title]").val());
		data.append("objective", $("input[name=objective]").val());
		data.append("content_overview", $("input[name=content_overview]").val());
		data.append("repeatable_model", $("input[name=repeatable_model]").val());
		data.append("organiser", $("input[name=organizer]").val());
		data.append("background", $("input[name=background]").val());
		data.append("additional_comment", $("input[name=additional_comment]").val());
		data.append("developer_contact", $("input[name=developer_contact]").val());
		data.append("country", $("input[name=country]").val());
		data.append("key_objective", $("input[name=key_objective]").val());
		data.append("owner", $("input[name=owner]").val());
		data.append("workspace", $("input[name=workspace]").val());
		data.append("brand", $("input[name=brand]").val());
		data.append("channel", $("input[name=channel]").val());
		data.append("unilever_contact", $("input[name=unilever_contact]").val());
		data.append("status", $("input[name=status]").val());
		data.append("privacy_status", $("input[name=privacy_status]").val());
		data.append("type", $("input[name=type]").val());
		//
		var files = $("input[name=assetFile]")[0].files;
		if(files && files.length>0){
			for(var i=0; i<files.length; i++){
				data.append('zip', files[i]);
			}
		}
		var thumbnail = $("input[name=assetThumbnail]")[0].files;
		if(thumbnail && thumbnail.length>0){
			for(var i=0; i<thumbnail.length; i++){
				data.append('thumbnail', thumbnail[i]);
			}
		}
		helper_API.uploadFile({
			action:"upload asset",
			path:path,
			method:method,
			data:data,
			processData:0,
			contentType:0,
			success_handler:this.save_handler.bind(this),
			error_handler:this.save_handler.bind(this)
		});
	}
	
	
	
	
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
			$("input, select, textarea").prop("disabled",null);
			$("[editable=0]").prop("disabled",1);
			//
			$("[name=btn-reset]").removeClass("hidden");
			$("[name=btn-save]").removeClass("hidden");
		}
	}catch(err){
		$("div.submissionResult").html("Error: "+result.responseText);
		$("input, select, textarea").prop("disabled",null);
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
	var thumbnail = $("input[name=assetThumbnail]")[0].files;
	//
	if(files && files.length>0){
		var data = new FormData();
		for(var i=0; i<files.length; i++){
			data.append('file', files[i]);
		}
		//
		helper_API.uploadFile({
			action:"upload asset",
			path:"/upload/zip_extract",
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