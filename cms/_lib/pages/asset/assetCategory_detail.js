this.main = null;
delete this.main;
this.main = new Object();
//
this.main.init = function(){
	var ref = getUrlParameters("ref");
	if(ref) $("a[name=link-back]").attr("href", ref);
	//
	this.user = helper_API.session_get();
	/*
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
	$("table#mainList").closest(".ihl0700_cTable").find(".ihl0700_cTable_search input[name=search]").attr("placeholder", "Name");
	*/
	this.requestMainList();
}
this.main.requestMainList = function(data){
	var id = $("input[name=id]").val();
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
		action:"asset get",
		path:"/assets/"+id,
		method:"GET",
		data:data,
		success_handler:this.getList_handler.bind(this),
		error_handler:this.getList_handler.bind(this)
	});
}
this.main.getList_handler = function(result){
	try{
		result = JSON.parse(result);
		if(String(result.responseStatus).toUpperCase() == "SUCCESS"){
			$("div.div_alert").addClass("hidden");
			this.parseList(result);
		}else{
			$("div.div_alert").removeClass("hidden");
			$("div.div_alert").html(result.responseText);
		}
	}catch(err){
		console.log("error");
		$("div.div_alert").removeClass("hidden");
		$("div.div_alert").html(result.responseText);
	}
}
this.main.parseList = function(data){
	$("table#mainList tbody").empty();
	var data = data.data;
	
	// Check uploader
	if(this.user && this.user.data.user_id==data.created_by){
		$("div[name='containerEdit']").removeClass("hidden");
		$("[name=btn-edit]").click(this.edit_click_handler.bind(this));
	}
			
	// Input entry
	for(n in data){
		if(data[n]=="") data[n]="-";
		if(data[n]=="undefined") data[n]="-";
		$(".asset-value span[name='"+n+"']").html(data[n]);
	}
	
	// Display thumbnails
	var url_thumbnail = data.collection.thumbnail;
	$("div.thumbnailContainer").empty();
	var thumbnail = "<img src='"+api_url+url_thumbnail+"' class='assetThumbnailImg'/>";
	$("div.thumbnailContainer").append(thumbnail);
	
	// Listing files
	$("input[name='link_download']").val(data.link_download);
	$("[name=btn-download]").click(this.downloadAll_click_handler.bind(this));
	
	//var offset = (Number($("table#mainList").attr("page"))-1) * Number($("table#mainList").attr("display"));
	var list = data.files;
	var ctr=0;
	for(var idx=0; idx<list.length; idx++){
		if(list[idx].file_id && list[idx].size_KB){
			ctr++;
			var $item = $("tr#template-mainList-row").clone();
			$item.attr("index", "file-"+idx);
			$item.attr("id", list[idx].file_id);
			list[idx].src = escape(list[idx].src);
			$item.attr("src", list[idx].src);
			$item.find("[colName=index]").attr("width","24");
			$item.find("[colName=index]").html(ctr);
			$item.find("[colName=1]").html(list[idx].origin_name);
			$item.find("[colName=2]").html(list[idx].type);
			$item.find("[colName=3]").html(list[idx].size_KB+" KB");
			//
			$item.find("button[name='btn-assetDownload']").click(this.assetDownload_click_handler.bind(this));
			//
			$("table#mainList tbody").append($item);
		}
	}
	this.list_table = new ihl0700_cTable();
	this.list_table.constructor({$table:$("table#mainList")});
	this.list_table.update();
}
this.main.edit_click_handler = function(ev){
	var id = $("input[name='id']").val();
	window.location = "asset/"+id+"/get";
}
this.main.assetDownload_click_handler = function(ev){
	var $tr = $(ev.target).closest("tr");
	var src = "/get_files"+$tr.attr("src");
	$("iframe[name=assetFilesIframe]").attr("src",api_url+src);
}
this.main.downloadAll_click_handler = function(ev){
	var link = $("input[name='link_download']").val();
	$("iframe[name=assetFilesIframe]").attr("src",api_url+link);
}

//--------------------------------------------------------------------------------------------------------------------------------------------
/* Delete */
this.main.form_delete = function(id){
	helper_API.sendXHR({
		action:"user delete",
		path:"/users/"+id,
		method:"DELETE",
		data:null,
		success_handler:this.delete_handler.bind(this),
		error_handler:this.delete_handler.bind(this)
	});
}
this.main.delete_handler = function(result){
	console.log(result);
	this.list_table.request_data();
}

this.main.init();