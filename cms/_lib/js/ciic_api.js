if(!helper_API){
	var helper_API = new Object();
	
	helper_API.browserCompatibilityCheck = function(){
		var compatible = true;
		if (typeof(Storage) == "undefined") compatible = false; // check session storage
		return compatible;
	}
	
	helper_API.configXHR = function(o, ignoreData){
		if(o){
			o.url = api_url+o.path;
			switch(String(o.method).toUpperCase()){
				case "GET": o.method = "GET";break;
				case "PUT": o.method = "PUT";break;
				case "POST": o.method = "POST";break;
				case "DELETE": o.method = "DELETE";break;
				default: o.method = "GET";break;
			}
			//
			if(o.method=="GET"){
				var x=0;
				if(o.data && !ignoreData){
					for(n in o.data){
						(x==0) ? o.url+="?" : o.url+="&";
						o.url+=n+"="+o.data[n];
						x++;
					}
				}
			}else{
				if(o.data && !ignoreData) o.data = JSON.stringify(o.data);
			}
			o.headers = this.prepareHeaders({url:o.path, method:o.method});
		}
		return o;
	}
	
	helper_API.prepareHeaders = function(o){
		var session = this.session_get();
		if(session){
			var a_date = this.generateDateRFC2822();
			//console.log(a_date);
			var a_str = this.generateAuthorization((o.method+"+"+o.url+"+"+a_date), session);
			var h = new Object({"Authorization":a_str, "X-Uciic-Date":a_date});
			//
			return h;
		}else{
			return null;
		}
	}
	
	helper_API.generateAuthorization = function(str, session){
		if(session){
			var data = session.data;
			var email = (session) ? data.email : "guest@mail.com";
			var prefix = "Uciic "+data.email+":";
			var secretKey = data.secret_key;
			
			var shaObj = new jsSHA("SHA-512", "TEXT");
			shaObj.setHMACKey(data.secret_key, "TEXT");
			shaObj.update(str);
			var hmacOutput = btoa(shaObj.getHMAC("HEX"));
			
			return String(prefix+hmacOutput);
		}
		return "";
	}

	helper_API.generateDateRFC2822 = function(){
		var dS = moment().format("ddd MMM DD YYYY HH:MM:ss [GMT+0700] [(WIB)]"); // require momentJs
		return dS;
	}
	
	helper_API.sendXHR = function(o, callback){
		var conf = this.configXHR(o);
		if(conf){
			conf.type = o.type;
			conf.url = o.url;
			conf.method = o.method;
			//
			$.ajaxSetup(conf);
			//
			var ajaxData = new Object();
			if(o.data) ajaxData.data = o.data;
			if(o.contentType!=null) ajaxData.contentType = Boolean(o.contentType);
			if(o.processData!=null) ajaxData.processData = Boolean(o.processData);
			//
			var request = $.ajax(ajaxData)
			request.done(function(response){
				if(o.success_handler) o.success_handler(JSON.stringify(response));
			});
			request.fail(function(response){
				switch(JSON.stringify(response.status)){
					case "422": 
					case "401": 
						//location.replace("login");
						if(o.error_handler) o.error_handler(response);
						break;
					default:
						if(o.error_handler) o.error_handler(response);
						break;
				}
			});
		}else{
			if(o.error_handler) o.error_handler(null);
		}
	}
	
	helper_API.uploadFile = function(o){
		var conf = this.configXHR(o, true);
		if(conf){
			conf.type = o.type;
			conf.url = o.url;
			conf.method = o.method;
			//
			$.ajaxSetup(conf);
			//
			var ajaxData = new Object();
			if(o.data) ajaxData.data = o.data;
			if(o.contentType!=null) ajaxData.contentType = Boolean(o.contentType);
			if(o.processData!=null) ajaxData.processData = Boolean(o.processData);
			//
			var request = $.ajax(ajaxData)
			request.done(function(response){
				if(o.success_handler) o.success_handler(JSON.stringify(response));
			});
			request.fail(function(response){
				switch(JSON.stringify(response.status)){
					case "422": 
					case "401": 
						location.replace("login");
						if(o.error_handler) o.error_handler(response);
						break;
					default:
						if(o.error_handler) o.error_handler(response);
						break;
				}
			});
		}else{
			if(o.error_handler) o.error_handler(null);
		}
	}
		
	
	
	/* Storage & Session */
	helper_API.session_check = function(){
		var s = this.session_get();
		if(s) return s; 
	}
	helper_API.session_get = function(){
		if(sessionStorage.session){
			return JSON.parse(sessionStorage.session);
		}
		return null;
	}
	helper_API.session_set = function(obj){
		this.session_destroy();
		this.session_update(obj);
	}
	helper_API.session_update = function(obj){
		if(obj){
			var sessObj = new Object();
			sessObj.date = this.generateDateRFC2822();
			sessObj.data = obj;
			sessObj = JSON.stringify(sessObj);
			//
			sessionStorage.session = sessObj;
		};
	}
	helper_API.session_destroy = function(){
		if(sessionStorage.session) sessionStorage.session = null;
		sessionStorage.session = null;
		delete sessionStorage.session;
	}
	
}