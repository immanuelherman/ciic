// Require jQuery
ihl0700_cTable = function(){


	// Sample Request Format
	
	/*
	http://localhost/api? 
		queries[search]=keyword
		&sorts[title]=1
		&page=1
		&perPage=20
		&offset=0
	*/
	
	
	this.constructor = function(o){
		this.url = o.url;
		this.requestFunction = o.requestFunction;
		this.callbackFunction = o.callbackFunction;
		this.$table = o.$table;
		//
		this.initTable(o);
	}
	
	this.getTableElementIndex = function(){
		var $t = $("table");
		for(var x=0; x<$t.length; x++){
			var t = $($t[x]);
			if(t.get(0) == this.$table.get(0)){
				return x;
				break;
			}
		}
	}
	
	//---------------------------------------------------------------------------------------------------------------------------------------
	
	this.initTable = function(opt){
		var id = (this.$table.attr("id") && this.$table.attr("id")!="") ? this.$table.attr("id") : this.getTableElementIndex();
		this.$table.parent().append("<div class='ihl0700_cTable'></div>");
		this.$container = this.$table.parent().find("div.ihl0700_cTable");
		this.$container.attr("id", "ihl0700_cTable_container_"+id);
		this.$container.attr("idx", id);
		//
		this.$table.appendTo(this.$container);
		//
		this.setupWidget_search();
		this.setupWidget_display();
		this.setupWidget_paging();
		
		// Init initial params
		var total = (opt && Number(opt.total)) ? opt.total : this.$table.find("tbody tr").length;
		var page = (opt && Number(opt.page)) ? opt.page : 1;
		var display = (opt && Number(opt.display)) ? opt.display : 10;
		var search = (opt && opt.search) ? opt.search : "";
		var sorts = (opt && opt.sorts) ? opt.sorts : "";
		//
		this.$table.attr("total", total);
		this.$table.attr("page", page);
		this.$table.attr("display", display);
		this.$table.attr("search", search);
		this.$table.attr("sorts", sorts);
	}
	
	this.setupWidget_search = function(){
		this.$container.prepend("<div class='ihl0700_cTable_top'/>");
		this.$tc = this.$container.find("div.ihl0700_cTable_top");
		this.$tc.prepend("<div class='ihl0700_cTable_search' style='position:relative;'><span>Search</span> <input type='search' name='search'></div>");
		this.$widget_search = this.$tc.find("div.ihl0700_cTable_search");
		
		this.$widget_search.find('input[type=search]').keyup(search_handler.bind(this));
		function search_handler(ev){
			var $i = $(ev.target).closest("input");
			var key = String($i.val());
			if(ev.which == 13 || key == "") {
				this.$table.attr("search", key);
				this.$table.attr("page", 1);
				this.request_data();
			}
		};
	}
	
	this.setupWidget_display = function(){
		this.$tc = this.$container.find("div.ihl0700_cTable_top");
		//
		this.$tc.prepend("<div class='ihl0700_cTable_display'><span>Display</span> <select><option>10</option><option>20</option><option>50</option></select></div>");
		this.$widget_display = this.$tc.find("div.ihl0700_cTable_display");
		this.$widget_display.unbind();
		this.$widget_display.change(display_change_handler.bind(this));
		//
		function display_change_handler(e){
			this.$table.attr("display", $(e.target).find("option:selected").text());
			this.$table.attr("page", 1);
			this.request_data();
		}
	}
	
	this.setupWidget_paging = function(){
		this.$container.append("<div class='ihl0700_cTable_paging'/>");
		var $p = this.$container.find("div.ihl0700_cTable_paging");
		//
		$p.append("<div class='paging_text'><span>Showing </span><span class='limit'>1</span> of <span class='total'>1</span></div>");
		this.$widget_paging = $p.find("div.paging_text");
		//
		$p.append("<div class='paging_list'><ul class='list'></ul></div>");
		this.$widget_list = $p.find("div.paging_list");
	}
	
	
	/* Request data */
	this.request_data = function(){
		if(this.requestFunction){
			// Sample
			// http://localhost/api/branchs?queries[search]=keyword&sorts[title]=1
			
			var search = this.$table.attr("search");
			//var sorts = String(this.$table.attr("sorts");
			var page = this.$table.attr("page");
			var perPage = this.$table.attr("display");
			var offset = (Number(this.$table.attr("page"))-1)*Number(this.$table.attr("display"));
			//
			var o = new Object();
			o.page = page;
			o.perPage = perPage;
			o.offset = offset;
			o.search = search;
			this.requestFunction(o);
		}else{
			this.static_update();
		}
	}
	
	
	//
	this.get = function(){
		return this.$table;
	}
	
	this.reset = function(){
		this.$table.find("tbody").empty();
		return true;
	}
	
	this.update = function(o){
		this.update_paging(o);
		// static page rearrangement
		this.static_rearrange();
	}
	
	this.update_paging = function(o){
		var po = (o && o.pagination && o.pagination.current_number) ? o.pagination : new Object({current_number:1});
		var limit = Number(this.$table.attr("display"));
		var total = (o && o.count) ? Number(o.count) : this.$table.attr("total");
		var currPage = this.$table.attr("page");
		//
		var d = ((po.current_number-1)*limit)+1;
		var e = d+limit-1;
		if(e>total) e = total;
		this.$widget_paging.find(".limit").text(d+" - "+e);
		this.$widget_paging.find(".total").text(total);
		
		// Clear paging list and recreate new one
		this.$widget_list.find("ul.list li[data-page]").unbind();
		this.$widget_list.find("ul.list").empty();
		var p=1;
		var x = 0;
		while(x<total){
			var list="";
			if(p == currPage){
				list = "<li data-id='"+p+"' class='active'><strong>"+p+"</strong></li>";
			}else{
				list = "<li data-id='"+p+"' class='selectable' data-page='"+p+"'>"+p+"</li>";
			}
			x+=limit;
			p++;
			//
			this.$widget_list.find("ul.list").append(list);
		}
		var $li = this.$widget_list.find("ul.list li");
		$li.unbind();
		$li.click(this.paging_list_click.bind(this));
		if($li.length>9){
			$li.addClass("hidden");
			var $liA = this.$widget_list.find("ul.list li.active");
			var ai = Number($liA.attr("data-id"));
			var show;
			if(ai > 6 && ai <= (p-6)){
				show = [1,(ai-3),(ai-2),(ai-1),ai,(ai+1),(ai+2),(ai+3),(p-1)]; // Show the active, the first, the last and 2 nearest page link
				this.$widget_list.find("ul.list li[data-id=1]").after("<li>..</li>");
				this.$widget_list.find("ul.list li[data-id="+(p-1)+"]").before("<li>..</li>");
			}else if(ai > (p-6) && ai <= (p-1)){
				show = [1,ai,(p-1),(p-2),(p-3),(p-4),(p-5),(p-6)];
				this.$widget_list.find("ul.list li[data-id=1]").after("<li>..</li>");
			}else if(ai<=6){
				show = [1,2,3,4,5,6,7,8,(p-1)];
				this.$widget_list.find("ul.list li[data-id="+(p-1)+"]").before("<li>..</li>");
			}
			if(show){
				while(show.length>0){
					var sid = show.pop();
					this.$widget_list.find("ul.list li[data-id="+sid+"]").removeClass("hidden");
				}
			}
		}
		
		
	}
	
	this.paging_list_click = function(ev){
		var $li = $(ev.target).closest("li[data-page]");
		var np = $li.attr("data-page");
		this.$table.attr("page", np);
		this.request_data();
	}
	
	
	
	
	
	
	
	/* Static */
	this.static_rearrange = function(){
		// Only for static table
		if(!this.requestFunction){
			var $tr = this.$table.find("tbody tr").filter(":not(.findhide)");
			$tr.addClass("rowhide");
			//
			var limit = Number(this.$table.attr("display"));
			this.$table.attr("total", $tr.length);
			this.update_paging();
			//
			var currPage = this.$table.attr("page");
			var offset = Number((currPage-1) * limit);
			for(var idx=offset; idx<(offset+limit) && idx<$tr.length; idx++){
				if($($tr[idx]).length>0) $($tr[idx]).removeClass("rowhide");
			}
		}
	}
	
	this.static_search = function(){
		var search = this.$table.attr("search");
		var key = String(search).toLowerCase();
		//var $tr = this.$table.find("tbody tr").filter(":not(.hide)");
		var $tr = this.$table.find("tbody tr");
		//
		if(key && key!=""){
			this.$table.attr("searchmode", 1);
			$tr.addClass("findhide");
			for(var idx=0; idx<$tr.length; idx++){
				var $item = $($tr.get(idx));
				if(String($item.text().toLowerCase()).indexOf(key)>=0){
					$item.removeClass("findhide");
					$item.removeClass("rowhide");
				}
				this.$table.attr("page",1);
			}
		}else{
			this.$table.attr("searchmode", 0);
			$tr.removeClass("findhide");
		}
	}
	
	this.static_update = function(){
		var search = this.$table.attr("search");
		var sorts = String(this.$table.attr("sorts"));
		var page = this.$table.attr("page");
		var perPage = this.$table.attr("display");
		var offset = (Number(this.$table.attr("page"))-1)*Number(this.$table.attr("display"));
		//
		this.static_search();
		this.update();
	}
	
};











