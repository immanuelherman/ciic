this.main = null;
delete this.main;
this.main = new Object();
//
this.main.init = function(){
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
	//
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
	helper_API.sendXHR({
		action:"login",
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
		console.log(result);
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
		$item.attr("index", this.asset_id+"-"+idx);
		$item.attr("id", list[idx].asset_id);
		$item.find("[colName=index]").html(offset+(idx+1));
		$item.find("[colName=1]").html(list[idx].title);
		$item.find("[colName=2]").html(list[idx].asset_type);
		$item.find("[colName=3]").html(list[idx].brand);
		$item.find("[colName=4]").html(list[idx].country);
		$item.find("[colName=5]").html(list[idx].unilever_contact);
		$item.find("[colName=6]").html(list[idx].status);
		$item.find("[colName=7]").html(list[idx].owner);
		//
		$item.find("[name=btn-edit]").click(this.edit_click_handler.bind(this));
		$item.find("[name=btn-delete]").click(this.delete_click_handler.bind(this));
		//
		$("table#mainList tbody").append($item);
	}
	this.list_table.update(data);
}
this.main.add_click_handler = function(ev){
	window.location = base_path+"asset/0/get";
}
this.main.edit_click_handler = function(ev){
	var $item = $(ev.target).closest("tr[id]");
	var id = $item.attr("id");
	window.location = base_path+"asset/"+id+"/get";
}
this.main.delete_click_handler = function(ev){
	var $item = $(ev.target).closest("tr[id]");
	var id = $item.attr("id");
	var name = $item.find("[colName=1]").text();
	if(confirm("Permanently Delete Collection '"+name+"'?")){
		this.form_delete(id);
	}
}

//--------------------------------------------------------------------------------------------------------------------------------------------
/* Delete */
this.main.form_delete = function(id){
	helper_API.sendXHR({
		action:"Asset delete",
		path:"/assets/"+id,
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