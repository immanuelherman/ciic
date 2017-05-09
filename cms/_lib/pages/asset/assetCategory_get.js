this.main = null;
delete this.main;
this.main = new Object();
//
this.main.init = function(){
	$("iframe[name='iframe-assetDownload']").attr("src", "");
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
	//
	$("table#mainList").closest(".ihl0700_cTable").find(".ihl0700_cTable_search input[name=search]").attr("placeholder", "Location, Brand, Contact");
	$("[name=btn-add]").click(this.add_click_handler.bind(this));
	//
	this.requestMainList();
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
	if(asset_type){
		data.asset_type = asset_type;
	}
	helper_API.sendXHR({
		action:"get assets",
		path:"/assets",
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
	//
	var offset = (Number($("table#mainList").attr("page"))-1) * Number($("table#mainList").attr("display"));
	var list = data.data;
	for(var idx=0; idx<list.length; idx++){
		var $item = $("tr#template-mainList-row").clone();
		$item.attr("index", "asset-"+idx);
		$item.attr("id", list[idx].asset_id);
		$item.attr("src", list[idx].link_download);
		$item.find("[colName=index]").html(offset+(idx+1));
		for(n in list[idx]){
			if(list[idx][n]=="") list[idx][n]="-"
			$item.find("[colname="+n+"]").html(list[idx][n]);
		}
		if(list[idx].collection && list[idx].collection.thumbnail){ 
			$item.find(".asset-thumbnail img").attr("src", String(api_url+list[idx].collection.thumbnail));
		}
		
		$item.find("[name=btn-detail]").click(this.detail_click_handler.bind(this));
		$item.find("[name=btn-download]").click(this.download_click_handler.bind(this));
		//
		$("table#mainList > tbody").append($item);
	}
	this.list_table.update(data);
}
this.main.add_click_handler = function(ev){
	window.location = base_path+"asset/0/get?type="+asset_type+"&ref=asset/"+asset_type;
}
this.main.detail_click_handler = function(ev){
	var $item = $(ev.target).closest("tr[id]");
	var id = $item.attr("id");
	window.location = base_path+"asset/"+asset_type+"/"+id+"/get";
}
this.main.download_click_handler = function(ev){
	var $tr = $(ev.target).closest("tr");
	var url = api_url+$tr.attr("src");
	$("iframe[name='iframe-assetDownload']").attr("src", url);
}


this.main.init();