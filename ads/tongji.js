function loadScript(url, callback){
	var script = document.createElement("script");
	script.type = "text/javascript"; 
	if (script.readyState){ //IE 
		script.onreadystatechange = function(){
			if (script.readyState == "loaded"||script.readyState == "complete"){
				script.onreadystatechange = null; 
				callback(); 
			}
		}; 
	} else { 
		script.onload = function(){ 
			callback(); 
		}; 
	}
	script.src = url;
	document.getElementById('tongji').appendChild(script);
	//document.body.appendChild(script); 
}
setTimeout(function(){
	loadScript('http://js.users.51.la/16960647.js',function(){});
},5000);
//document.writeln("<div style=\"display:none\">");
///document.writeln("<script language=\"javascript\" type=\"text/javascript\" src=\"http://js.users.51.la/16960647.js\"></script>");
//document.writeln("<script language=\"javascript\" type=\"text/javascript\" src=\"http://s95.cnzz.com/z_stat.php?id=1254857401&web_id=1254857401\"></script>");
//document.writeln("</div>");