(function(){
	var fontSize = function() {
		var clientWidth = $("html").width();
		if (clientWidth > 414) { 
			clientWidth = 414;
		}
		if (!clientWidth) return;
		var size = Math.floor(30 * (clientWidth / 750)) + 'px';
		$("html").css('font-size', size);
	};
	fontSize();

	// $("body").height(document.body.clientHeight);

	window.addEventListener("resize", fontSize, false);

	var ua = navigator.userAgent.toLowerCase();
	var ios = !!ua.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/)
			|| ua.indexOf('iphone') > -1
			|| ua.indexOf('ipad') > -1;
	var android = ua.indexOf('android') > -1;
	if(ios){
		$(".download").attr("href","https://itunes.apple.com/cn/app/broadlink-ihc/id1084990073?mt=8");
	}else if(android){
		$(".download").attr("href","https://play.google.com/store/apps/details?id=cn.com.broadlink.econtrol.plus");
	}else{
		$(".download").attr("href","https://play.google.com/store/apps/details?id=cn.com.broadlink.econtrol.plus");
	}

})();

var serverUrl = 'https://oauth.homesmartdevices.cn/';

function http(url,method,dataObj,header){
	var formdata = JSON.stringify(dataObj);
	var defer = $.Deferred();  
	$("#loading").show(); 
	//发送
	$.ajax({
		url : url,
		type : method,
		data : formdata,
		headers:header,
		contentType:'application/json; charset=utf-8',
		success : function(data){
			$("#loading").hide(); 
			defer.resolve(data);
		},
		error : function(data){
			$("#loading").hide(); 
		  	defer.reject(data);
		}
	});
	return defer.promise();
}

function toast(msg,text,time){
	if(msg){
		$("#msg").html(msg);
		if(text){
			$("#close").html(text);
		}
		$("#warn1").show();
		if(time){
			setTimeout(function(){
				$("#warn1").hide()
			},time);
		}
	}
}

function dealWith(data){
	for (var i = msgs.length - 1; i >= 0; i--) {
		if(msgs[i].key == data){
			if(msgs[i].text){
				return {
					value:msgs[i].value,
					text:msgs[i].text
				}
			}else{
				return msgs[i].value;
			}
		}
	}
}
