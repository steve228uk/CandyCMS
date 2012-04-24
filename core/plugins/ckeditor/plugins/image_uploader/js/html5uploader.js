/*
	Files upload to server using HTML 5 drag & drop from clipboard
	It needs Mootools library

	Tested on:
	Mozilla Firefox 3.6.12
	Google Chrome 7.0.517.41
	Safari 5.0.2
	Safari iPad version
	WebKit r70732

	It will not work on:
	Opera 10.63 
	Opera 11 alpha
	IE

*/

function uploader(place, status, targetPHP, show) {
	
	this.io = 1
	// Upload of files
	upload = function(file) {
	
	// File type control
	var checktype=0;
	switch (file.type) {
	// TODO: filetypes from ini
		case 'image/png':
		case 'image/jpg':
		case 'image/gif':
		case 'image/tiff':
		case 'image/jpeg':
		case 'image/bmp':
			checktype = 1;
		break;
	}
	if (checktype) {
		// Firefox 3.6, Chrome 6, WebKit
		if(window.FileReader) { 
		
			// After file loading process 
			this.loadEnd = function() {
				bin = reader.result;
				xhr = new XMLHttpRequest();
				xhr.open('POST', targetPHP+'&up=true', true);
				var boundary = 'xxxxxxxxx';
	 			var body = '--' + boundary + "\r\n";  
				body += "Content-Disposition: form-data; name='upload'; filename='" + file.name + "'\r\n";  
				body += "Content-Type: application/octet-stream\r\n\r\n";  
				body += bin + "\r\n";  
				body += '--' + boundary + '--';      
				xhr.setRequestHeader('content-type', 'multipart/form-data; boundary=' + boundary);
				// Firefox 3.6 make available function sendAsBinary() 
				if(xhr.sendAsBinary != null) { 
					xhr.sendAsBinary(body); 
				// Chrome 7 is sending data, but we must use base64_decode function
				} else { 
					xhr.open('POST', targetPHP+'&up=true&base64=true', true);
					xhr.setRequestHeader('UP-FILENAME', file.name);
					xhr.setRequestHeader('UP-SIZE', file.size);
					xhr.setRequestHeader('UP-TYPE', file.type);
					xhr.send(window.btoa(bin));
				}
			}
			
			// Loading error
			this.loadError = function(event) {
				switch(event.target.error.code) {
					case event.target.error.NOT_FOUND_ERR:
						$(status).innerHTML = 'File not found!';
					break;
					case event.target.error.NOT_READABLE_ERR:
						$(status).innerHTML = 'File not readable!';
					break;
					case event.target.error.ABORT_ERR:
					break; 
					default:
						$(status).innerHTML = 'Read error.';
				}
			}
			
			// Loading advancement
			this.loadProgress = function(event) {
				$(status).innerHTML = '<div style="margin-left: auto; margin-top: 50px; margin-right: auto; width: 100px;">'+file.name+'</div>';
			}
		
			var reader = new FileReader();		
			// Firefox 3.6, WebKit
			if(reader.addEventListener) { 
				reader.addEventListener('load', this.loadEnd, false);
				if (status != null) 
				{
					reader.addEventListener('error', this.loadError, false);
					reader.addEventListener('progress', this.loadProgress, false);
				}
			// Chrome 7
			} else { 
				reader.onloadend = this.loadEnd;
				if (status != null) 
				{
					reader.onerror = this.loadError;
					reader.onprogress = this.loadProgress;
				}
			}
		
			// Function is setting files reading process as binary string
			reader.readAsBinaryString(file);
		
			// Safari 5 not operate with FileReader
			} else {
				xhr = new XMLHttpRequest();
				xhr.open('POST', targetPHP+'&up=true', true);
				xhr.setRequestHeader('UP-FILENAME', file.name);
				xhr.setRequestHeader('UP-SIZE', file.size);
				xhr.setRequestHeader('UP-TYPE', file.type);
				xhr.send(file); 
				if (show != null) {
					$('cke_refresh').fireEvent("click", [], 1000);
				}
			}	
		} 
	}	
	
	// Upload of files
	this.drop = function(event) {
	
		event.preventDefault();
		var bin; 
	 	var dt = event.dataTransfer;
	 	var files = dt.files;
	 	for (var i = 0; i<files.length; i++) {
			var file = files[i];
			upload(file);
	 	}
		if (show != null) {
			$('cke_refresh').fireEvent("click", [], 1000);
		}
	}
	
	// Setting events listeners (dragover and drop)
	this.uploadPlace = $(place);
	this.uploadPlace.addEventListener("dragover", function(event) {
		event.preventDefault();
	}, true);
	this.uploadPlace.addEventListener("drop", this.drop, false); 

}

	