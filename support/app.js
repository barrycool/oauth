(function(){
	function IsPC() {
	    var userAgentInfo = navigator.userAgent;
	    var Agents = ["Android", "iPhone",
	                "SymbianOS", "Windows Phone",
	                "iPad", "iPod"];
	    var flag = true;
	    for (var v = 0; v < Agents.length; v++) {
	        if (userAgentInfo.indexOf(Agents[v]) > 0) {
	            flag = false;
	            break;
	        }
	    }
	    return flag;
	}

	var imgSize = function(){
		var list = document.getElementById("desc").getElementsByTagName('img');
		for (var i = list.length - 1; i >= 0; i--) {
			// list[i].width = list[i].width*0.8;
			list[i].style.display = "inline-block";
		}
	}

	var pc = IsPC();

	if(pc){
		window.onload = function(){
			imgSize();
		}
	}else{
		var url = window.location.href;
		var len = url.split("/").length;
		var arr = url.split("/").slice(0,-1);
		var str = url.split("/")[len-1];
		if(str.indexOf(".html")>-1){
			str = str.split('.')[0];
			var jumpUrl = '';
			switch(str){
				case 'add':
					jumpUrl = 'Universal.html#2';
					break;
				case 'discover':
					jumpUrl = 'Work.html#4';
					break;
				case 'download':
					jumpUrl = 'General.html';
					break;
				case 'enableSkill':
					jumpUrl = 'Work.html#2';
					break;
				case 'index':
					jumpUrl = 'index.html';
					break;
				case 'installAlexa':
					jumpUrl = 'Work.html';
					break;
				case 'linkAccount':
					jumpUrl = 'Work.html#3';
					break;
				case 'prepare':
					jumpUrl = 'Universal.html';
					break;
				case 'sayToAlexa':
					jumpUrl = 'Work.html#5';
					break;
				case 'setup':
					jumpUrl = 'General.html#3';
					break;
				case 'sign':
					jumpUrl = 'General.html#2';
					break;
				case 'tv':
					jumpUrl = 'Universal.html#4';
					break;
				case 'wifi':
					jumpUrl = 'Universal.html#3';
					break;
			}
			window.location.href = arr.join("/") + "/mobile/"+ jumpUrl;
		}else{
			window.location.href = "mobile";
		}
	}
	
})();

function active(str){
	var li = document.getElementById(str+"li");
	var ul = document.getElementById(str);
	var classname = li.className?li.className:'';
	if(li.classList.contains('active')){
		ul.style.display = "none";
		li.className = classname.replace("active","");
	}else{
		ul.style.display = "block";
		li.className = classname + "active";
	}
}