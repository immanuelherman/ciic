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
	$("div#ihl0700_cTable_container_mainList table#mainList").before($("div#mainList_card"));
	$("div#ihl0700_cTable_container_mainList .ihl0700_cTable_top").prepend($("div.displayStyleContainer"));
	$("button[name='displayStyle']").click(this.switchDisplayStyle.bind(this));
	//
	$("select[name]").change(this.filter_change_handler.bind(this));
	//
	this.requestMainList();
}


this.main.filter_change_handler = function(ev){
	//console.log($(ev.target).val());
	this.list_table.request_data();
}


this.main.switchDisplayStyle = function(ev){
	var $i = $("button[name='displayStyle'] i");
	if($i.hasClass("fa-th")){
		$i.removeClass("fa-th");
		$i.addClass("fa-list");
		$("table#mainList").removeClass("hidden");
		$("div#mainList_card").addClass("hidden");
	}else{
		$i.addClass("fa-th");
		$i.removeClass("fa-list");
		$("table#mainList").addClass("hidden");
		$("div#mainList_card").removeClass("hidden");
	}
}

this.main.requestMainList = function(data){
	console.log(data);
	var limit = ($("table#mainList").closest(".ihl0700_cTable").find(".ihl0700_cTable_display select").val());
	//
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
	if(!data) var data = new Object({limit:limit});
	
	// Asset Type
	if(asset_type) data.asset_type = asset_type;
	
	// Filter
	var $filters = $("select[name]");
	for(var i=0; i<$filters.length; i++){
		var pname = $($filters.get(i)).attr("name");
		data[pname] = null;
		delete data[pname];
		if($($filters.get(i)).val()!="0"){
			data[pname] = $($filters.get(i)).val();
		}
	}
	
	// Send request
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
	}catch(err){
		console.log("error");
		$("div.div_alert").removeClass("hidden");
		$("div.div_alert").html(result.responseText);
	}
	if(String(result.responseStatus).toUpperCase() == "SUCCESS"){
		$("div.div_alert").addClass("hidden");
		this.parseList(result);
	}else{
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
		if(list[idx].thumbnail["/"] && list[idx].thumbnail["/"].length>0){
			$item.find(".asset-thumbnail").empty();
			for(var i=0; i<list[idx].thumbnail["/"].length; i++){
				var url = api_url+list[idx].thumbnail.root_path+"/"+escape(list[idx].thumbnail["/"][i])+"?width=150";
				$item.find(".asset-thumbnail").append("<img src='"+url+"' />");
			}
		}
		
		$item.find("[name=btn-detail]").click(this.detail_click_handler.bind(this));
		$item.find("[name=btn-download]").click(this.download_click_handler.bind(this));
		//
		$("table#mainList > tbody").append($item);
	}
	this.list_table.update(data);
	//
	this.renderListCard(data);
}
this.main.add_click_handler = function(ev){
	window.location = base_path+"asset/0/get?type="+asset_type+"&ref=asset/"+asset_type;
}
this.main.detail_click_handler = function(ev){
	var $item = $(ev.target).closest("[id]");
	var id = $item.attr("id");
	window.location = base_path+"asset/"+asset_type+"/"+id+"/get";
}
this.main.download_click_handler = function(ev){
	var $tr = $(ev.target).closest("[id]");
	var url = api_url+$tr.attr("src");
	$("iframe[name='iframe-assetDownload']").attr("src", url);
}


/**/
this.main.renderListCard = function(data){
	var $cl = $("div#mainList_card");
	$cl.empty();
	//
	var list = data.data;
	for(var idx=0; idx<list.length; idx++){
		var $item = $("div#template-mainList_card-item").clone();
		$item.attr("index", "card-"+idx);
		$item.attr("id", list[idx].asset_id);
		$item.attr("src", list[idx].link_download);
		for(n in list[idx]){
			if(list[idx][n]=="") list[idx][n]="-"
			$item.find("[colname="+n+"]").html(list[idx][n]);
		}
		
		if(list[idx].thumbnail["/"] && list[idx].thumbnail["/"].length>0){
			var url = api_url+list[idx].thumbnail.root_path+"/"+escape(list[idx].thumbnail["/"][0])+"?height=110";
			//
			list[idx].imageLoader = new Image();
			list[idx].image_load_handler = function(){
				this.$item.find(".mainList_card-image img").attr("src", this.imageLoader.src);
				this.$item.find(".mainList_card-image img").attr("width", "auto");
			}
			list[idx].image_error_handler = function(){
				this.$item.find(".mainList_card-image").css("background-color", "#fff");
				this.$item.find(".mainList_card-image img").attr("src", "_lib/images/no_image.png");
			}
			list[idx].$item = $item;
			list[idx].imageLoader.addEventListener("load", list[idx].image_load_handler.bind(list[idx]));
			list[idx].imageLoader.addEventListener("error", list[idx].image_error_handler.bind(list[idx]));
			list[idx].imageLoader.src = url;
			console.log(list[idx].imageLoader);
			console.log(url);
		}
		
		//
		$item.find(".mainList_card-title, .mainList_card-image").click(this.detail_click_handler.bind(this));
		$item.find("[name=btn-download]").click(this.download_click_handler.bind(this));
		//
		$cl.append($item);
	}
	
	$('.fotorama').fotorama();
}



this.main.init();