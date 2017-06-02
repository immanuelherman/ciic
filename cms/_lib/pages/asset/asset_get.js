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
	$("th[colName=selection-all]").click(this.selectAll_click_handler.bind(this));
	$("button[name='btn-deleteSelected']").click(this.deleteSelected_click_handler.bind(this));
	//
	this.requestMainList();
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
this.main.requestMainList = function(data){
	this.show_status(true, "<i class='fa fa-spinner fa-spin'></i> Retrieving list..", $(".notificationBar"));
	//
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
	}catch(err){
		var msg = (result.responseText) ? result.responseText : "Error. Parsing failed";
		this.show_status(true, result.responseText, $(".notificationBar"));
	}
	//
	if(String(result.responseStatus).toUpperCase() == "SUCCESS"){
		this.show_status(false);
		this.parseList(result);
	}else{
		var msg = (result.responseText) ? result.responseText : "Error. Parsing failed";
		this.show_status(true, result.responseText, $(".notificationBar"));
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
		if(list[idx].thumbnail && list[idx].thumbnail["/"].length>0){
			$item.find("[colName='thumbnail'] img").attr("src", api_url+list[idx].thumbnail.root_path+"/"+list[idx].thumbnail["/"][0]);
		}
		//
		$item.find("[name=btn-edit]").click(this.edit_click_handler.bind(this));
		$item.find("[name=btn-delete]").click(this.delete_click_handler.bind(this));
		$item.find("[colName=selection]").click(this.select_click_handler.bind(this));
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
	if(confirm("Permanently Delete Asset '"+name+"'?")){
		this.form_delete(id);
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
	var $ntf = $("div.deleteResult");
	$ntf.removeClass("hidden");
	this.show_status(true, "<i class='fa fa-spin fa-spinner'></i> Deleting.. ("+(this.delTotal-this.$selectedTd.length)+" of "+this.delTotal+")", $(".notificationBar"));
	//
	if(result && result.status && result.status==500){
		this.show_status(true, "<i class='fa fa-times'></i> Delete failed: Only user who upload the asset can delete this item.");
		this.$selectedTd = null;
		clearTimeout(this.refreshTableTimeout);
		this.refreshTableTimeout = setTimeout(this.deleteSelected_refresh.bind(this), 3500);
	}else{
		if(this.$selectedTd.length>0){
			var cid = this.$selectedTd.pop();
			this.form_delete(cid, this.deleteSelected_exec);
		}else{
			this.show_status(true, "<i class='fa fa-check'></i> Delete completed");
			clearTimeout(this.refreshTableTimeout);
			this.refreshTableTimeout = setTimeout(this.deleteSelected_refresh.bind(this), 1200);
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






//--------------------------------------------------------------------------------------------------------------------------------------------
/* Delete */
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

this.main.init();