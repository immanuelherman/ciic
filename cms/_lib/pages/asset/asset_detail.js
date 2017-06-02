this.main = null;
delete this.main;
this.main = new Object();
//
this.main.init = function(){
	var ref = getUrlParameters("ref");
	if(ref) $("a[name=link-back]").attr("href", ref);
	//
	$("[name=btn-create]").click(this.createAnother_click_handler.bind(this));
	$("[name=btn-fileUpload]").click(this.uploadFile_click_handler.bind(this));
	$("[name=btn-downloadAll]").click(this.downloadAll_click_handler.bind(this));
	$("[name=btn-back]").click(function(){window.location="asset/get";});
	
	// Asset file (zip)
	this.zip_pluploader = pluploader_obj.init({
		id:"btn-zip",
		file_data_name:"zip",
		multi_selection:false,
		chunk_size:500,
		filters:{mime_types: [{title : "Zip files", extensions : "zip"}]},
		handler:this.zip_upload_handler
	}); 
	this.zip_pluploader.init();
	//
	this.getData();
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
this.main.downloadAll_click_handler = function(ev){
	var link = $("input[name='link_download']").val();
	$("iframe[name=assetFilesIframe]").attr("src",api_url+link);
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
		if(asset_type) $("select[name=assetType]").val(asset_type);
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
	}catch(err){
		$("div.div_alert").removeClass("hidden");
		$("div.div_alert").html("Error. Unable to parse data.");
	}
	if(String(result.responseStatus).toUpperCase() == "SUCCESS"){
		this.parseResult(result);
	}else{
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
this.main.renderFileList = function(obj, folder){
	if(!folder) folder="";
	var fileArr = new Array();
	for(n in obj){
		(typeof(obj[n])=="object" || typeof(obj[n])=="array") ? fileArr = fileArr.concat(this.renderFileList(obj[n], folder+String(n))) : fileArr.push(folder+obj[n]);
	}
	return fileArr;
}
this.main.parseFileList = function(data){
	var offset = 0;
	var list = this.renderFileList(data["/"],"/");
	if(list.length>0){
		$(".assetFilesList").removeClass("hidden");
		for(var idx=0; idx<list.length; idx++){
			var $item = $("tr#template-mainList-row").clone();
			$item.attr("index", "file-"+idx);
			$item.attr("id", idx);
			$item.attr("src", data.root_path+"/"+escape(list[idx]));
			$item.find("[colName=index]").html(idx+1);
			$item.find("[colName=1]").html(list[idx]);
			//
			$item.find("button[name='btn-assetDownload']").click(this.assetDownload_click_handler.bind(this));
			//
			$("table#mainList tbody").append($item);
		}
		this.list_table = new ihl0700_cTable();
		this.list_table.constructor({$table:$("table#mainList")});
		this.list_table.update(data);
	}
	
}
this.main.assetDownload_click_handler = function(ev){
	var $tr = $(ev.target).closest("tr");
	var src = "/get_files"+$tr.attr("src");
	$("iframe[name=assetFilesIframe]").attr("src",api_url+src);
}


/**/
this.main.parseThumbnail = function(data){
	if(data){
		$("div.assetThumbnailList .thumbnailContainer").empty();
		$("div.assetThumbnailList").removeClass("hidden");
		if(data.thumbnail["/"] && data.thumbnail["/"].length>0){
			for(var i=0; i<data.thumbnail["/"].length; i++){
				var url = api_url+data.thumbnail.root_path+"/"+escape(data.thumbnail["/"][i]);
				var thumbnail = "<img src='"+url+"' class='assetThumbnailImg'/>";
				$("div.assetThumbnailList .thumbnailContainer").append(thumbnail);
			}
		}else{
			var url = "_lib/images/no_image_small.png";
			var thumbnail = "<img src='"+url+"' class='assetThumbnailImg'/>";
			$("div.assetThumbnailList .thumbnailContainer").append(thumbnail);
		}
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
		$("input[name='link_download']").val(this.initialData.link_download);
		this.parseFileList(this.initialData.zip);
		this.parseThumbnail(this.initialData);
	}else{
		$("select[name]").val(0);
		$("input[name]").val("");
	}
	$("input, select, textarea").prop("disabled",null);
	$("[editable=0]").prop("disabled",1);
}



/**/
this.main.form_read = function(){
	var data = new Object();
	data.asset_type 		= $("select[name=assetType]").val();
	data.title 				= $("[name=title]").val();
	data.objective 			= $("[name=objective]").val();
	data.content_overview 	= $("[name=content]").val();
	data.repeatable_model 	= $("[name=repeatable_model]").val();
	data.organiser 			= $("[name=organizer]").val();
	data.background 		= $("[name=background]").val();
	data.additional_comment = $("[name=additional_comment]").val();
	data.developer_contact	= $("[name=contact]").val();
	data.country 			= $("[name=country]").val();
	data.key_objective 		= $("[name=key_objective]").val();
	data.owner 				= $("[name=owner]").val();
	data.workspace 			= $("[name=workspace]").val();
	data.brand 				= $("[name=brand]").val();
	data.channel 			= $("[name=channel]").val();
	data.unilever_contact 	= $("[name=unilever_contact]").val();
	data.status 			= $("[name=status]").val();
	data.privacy_status 	= $("[name=privacy_status]").val();
	data.type 				= $("[name=type]").val();
	//
	return data;
}

/**/
this.main.form_submit_asset_handler = function(result){
	try{
		result = JSON.parse(result);
	}catch(err){
		$("div.div_alert").removeClass("hidden");
		$("div.div_alert").html("Error. Unable to parse data.");
	}
	if(result.responseStatus == "SUCCESS"){
		if(result.data && result.data.asset_id){
			this.asset_id = result.data.asset_id;
		}
		this.form_submit_thumbnail();
	}
}
this.main.form_submit_asset = function(){
	this.show_status(true, "Updating Asset Parameters..", $(".submissionResult"));
	var data = this.form_read();
	//
	var id = $("input[name=id]").val();
	if(String(id) != "0" && id != ""){
		var method = "PUT";
		var path = "/assets/"+id;
		var action = "asset update"
	}else{
		var method = "POST";
		var path = "/assets";
		var action = "asset create"
	}
	this.asset_id = id;
	//
	helper_API.sendXHR({
		action:action,
		path:path,
		method:method,
		data:data,
		success_handler:this.form_submit_asset_handler.bind(this),
		error_handler:this.form_submit_asset_handler.bind(this)
	});
	
}

/* Send thumbnails */
this.main.form_submit_thumbnail = function(){
	this.show_status(true, "Uploading Thumbnails..", $(".submissionResult"));
	var data = new FormData();
	var thumbnail = $("input[name=assetThumbnail]")[0].files;
	if(thumbnail && thumbnail.length>0){
		for(var i=0; i<thumbnail.length; i++){
			data.append('thumbnail[]', thumbnail[i]);
		}
		var path = "/assets/"+this.asset_id+"/thumbnail";
		helper_API.uploadFile({
			action:"upload asset",
			path:path,
			method:"POST",
			data:data,
			processData:0,
			contentType:0,
			success_handler:this.thumbnail_pluploader_complete_handler.bind(this),
			error_handler:this.thumbnail_pluploader_complete_handler.bind(this)
		});
	}else{
		this.form_submit_zip();
	}
}
this.main.thumbnail_pluploader_complete_handler = function(result){
	this.form_submit_zip();
}

/* Send zip files */
this.main.form_submit_zip = function(){
	if(this.zip_pluploader.files.length > 0){
		this.show_status(true, "Uploading Asset Files..", $(".submissionResult"));
		//
		var path = "/assets/"+this.asset_id+"/zip";
		this.zip_pluploader.settings.url = api_url+path;
		this.zip_pluploader.settings.headers = helper_API.prepareHeaders({url:path, method:"POST"});
		this.zip_pluploader.bind('UploadComplete', this.zip_pluploader_complete_handler.bind(this));
		this.zip_pluploader.bind('UploadProgress', this.zip_pluploader_progress_handler.bind(this));
		this.zip_pluploader.start();
	}else{
		this.zip_pluploader_complete_handler();
	}
}
this.main.zip_pluploader_progress_handler = function(up, file){
	this.show_status(true, "Uploading Asset Files... "+file.loaded+" / "+file.size+" ("+file.percent+"%)", $(".submissionResult"));
}
this.main.zip_pluploader_complete_handler = function(up, file){
	var id = $("input[name=id]").val();
	if(String(id) != "0" && id != ""){
		this.show_status(true, "Update asset completed", $(".submissionResult"));
		$("[name=btn-save],[name=btn-reset]").addClass("hidden");
	}else{
		this.show_status(true, "Create asset completed. Create another asset?", $(".submissionResult"));
	}
}

this.main.form_submit = function(){
	$("div.submissionResult").html("<i class='fa fa-spin fa-spinner'></i> Please wait..");
	$("div.submissionResult").removeClass("hidden");
	
	// Validation
	var eM = new Array();
	var eF = true;
	if($("input[name=title]").val() == ""){eM.push("Asset title is required"); eF = false;}
	if(!eF){$("div.submissionResult").html(eM.join("<br/>"));return null;}else{$("input, select, textarea").prop("disabled",1);}
	
	$("[name=btn-save],[name=btn-reset]").addClass("hidden");
	
	// Submit asset
	this.form_submit_asset();
}

this.main.save_handler = function(result){
	/*
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
	*/
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