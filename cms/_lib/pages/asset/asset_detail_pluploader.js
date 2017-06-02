// WRAPPER FOR PLUPLOAD

this.pluploader_obj = null;
delete this.pluploader_obj;
this.pluploader_obj = new Object();
//
this.log_display = true;

/*
obj={
	id, 
	url,
	file_data_name,
	chunk_size,
	headers,
	filters
}
*/

this.pluploader_obj.init = function(obj){
	log = function(){
		if(this.log_display){
			var str = "";
			plupload.each(arguments, function(arg) {
				var row = "";
				if (typeof(arg) != "string") {
					plupload.each(arg, function(value, key) {
						if (arg instanceof plupload.File) {
							switch (value) {
								case plupload.QUEUED:
									value = 'QUEUED';
									break;
								case plupload.UPLOADING:
									value = 'UPLOADING';
									break;
								case plupload.FAILED:
									value = 'FAILED';
									break;
								case plupload.DONE:
									value = 'DONE';
									break;
							}
						}
						if (typeof(value) != "function") {
							row += (row ? ', ' : '') + key + '=' + value;
						}
					});
					str += row + " ";
				}else{
					str += arg + " ";
				}
			});
			console.log(str);
		}
	}
	
	var uploader = new plupload.Uploader({
		headers : (obj.headers) ? obj.headers : null,
		file_data_name:obj.file_data_name,
		runtimes : 'html5,flash,html4',
		browse_button : String(obj.id),
		url : String(obj.url),
		chunk : true,
		chunk_size : (obj.chunk_size) ? String(obj.chunk_size)+"kb" : '1mb',
		filters: (obj.filters) ? obj.filters : null,
		unique_names : true,
		flash_swf_url : '_lib/js/plupload/Moxie.swf',
		silverlight_xap_url : '_lib/js/plupload/Moxie.xap',
		preinit : {
			Init: function(up, info) {
				log('[Init]', 'Info:', info, 'Features:', up.features);
			},
			UploadFile: function(up, file) {
				log('[UploadFile]', file);
			}
		},
		init : {
			PostInit: function() {log('[PostInit]');
				/*
				document.getElementById('uploadfiles').onclick = function() {
					uploader.start();
					return false;
				};
				*/
			},
			Browse: function(up) {log('[Browse]');},
			Refresh: function(up) {log('[Refresh]');},
			StateChanged: function(up) {log('[StateChanged]', up.state == plupload.STARTED ? "STARTED" : "STOPPED");},
			QueueChanged: function(up) {log('[QueueChanged]');},
			OptionChanged: function(up, name, value, oldValue) {log('[OptionChanged]', 'Option Name: ', name, 'Value: ', value, 'Old Value: ', oldValue);},
			BeforeUpload: function(up, file) {log('[BeforeUpload]', 'File: ', file);},
			UploadProgress: function(up, file) {log('[UploadProgress]', 'File:', file, "Total:", up.total);},
			FileFiltered: function(up, file) {log('[FileFiltered]', 'File:', file);},
			FilesAdded: function(up, files){
				log('[FilesAdded]');
				plupload.each(files, function(file){
					log('  File:', file);
				});
			},
			FilesRemoved: function(up, files){
				log('[FilesRemoved]');
				plupload.each(files, function(file){
					log('  File:', file);
				});
			},
			FileUploaded: function(up, file, info) {log('[FileUploaded] File:', file, "Info:", info);},
			ChunkUploaded: function(up, file, info) {log('[ChunkUploaded] File:', file, "Info:", info);},
			UploadComplete: function(up, files) {log('[UploadComplete]');},
			Destroy: function(up) {log('[Destroy] ');},
			Error: function(up, args) {log('[Error] ', args);}
		}
	});
	//
	return uploader;
}


