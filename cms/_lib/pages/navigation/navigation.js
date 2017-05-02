this.navigation = null;
delete this.navigation;
this.navigation = new Object();
//
this.navigation.init = function(){
	var activeNav = "";
	$("button#navigation-toggle").click(this.toggleNavigation_click_handler.bind(this));
	$("button#navigation-asset-upload").click(this.uploadAsset_click_handler.bind(this));
	
}

this.navigation.uploadAsset_click_handler = function(ev){
	window.location = "asset/0/get";
}

this.navigation.toggleNavigation_click_handler = function(ev){
	console.log($(".navigation_listContainer"));
	$(".navigation_listContainer").toggleClass("showNavigation");
	$("button#navigation-toggle i").toggleClass("fa-reorder");
	$("button#navigation-toggle i").toggleClass("fa-chevron-left");
}

this.navigation.init();