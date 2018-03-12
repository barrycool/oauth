(function(){
	var urlString = window.location.href;
	var backString = urlString.split('?')[1]?urlString.split('?')[1]:'';

	var arr = backString?backString.split('&'):[];
	var redirectArr = [];
	var redirectUrl = "";
	for (var i = 0; i < arr.length; i++) {
		redirectArr.push(arr[i].split('=')[0]);
		redirectArr.push(arr[i].split('=')[1]);
	}
	for (var j = 0; j < redirectArr.length; j++) {
		if(redirectArr[j] == 'redirect_uri'){
			redirectUrl = redirectArr[j+1];
		}
	}
	if(redirectUrl.indexOf("googleusercontent.com")>-1){
		document.title = "Google Home";
		var list = document.getElementsByClassName("alexa");
		for (var i = 0; i < list.length; i++) {
			var option = list[i];
			list[i].style.display = 'none';
		}
		var items = document.getElementsByClassName("google");
		for (var j = 0; j < items.length; j++) {
			var item = items[j];
			items[j].style.display = 'block';
		}
	}else if(redirectUrl.indexOf("amazon.com")>-1){
	}

	$("#radio").click(function(){
		if($("#radio").hasClass("checked")){
			$("#radio").removeClass("checked");
			$("#next").attr("disabled",true);
		}else{
			$("#radio").addClass("checked");
			$("#next").removeAttr("disabled");
		}
	})

	$("#next").click(function(){
		if(backString){
			window.location.href = "./login.html?"+backString;
		}else{
			window.location.href = "./login.html"
		}
	})

	

})();	
