(function(){
	var urlString = window.location.href;
	
	var backString = urlString?urlString.split('?')[1]:'';
	$("#forget").attr("href","./forget.html?"+backString);

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
			if(redirectUrl.indexOf("googleusercontent.com")>-1){
				document.title = "Google Home";
			}
			document.cookie = "redirect" + "="+ redirectUrl + ";";
			document.cookie = "back" + "="+ backString + ";";
			var cookie = document.cookie.split(";");
			for (var i = cookie.length - 1; i >= 0; i--) {
				var temp = cookie[i].split("=")[0].trim();
				if(temp == 'token'){
					var accesstoken = cookie[i].split('=')[1];
					var response;
					var url = "https://graph.facebook.com/me?access_token="+accesstoken;
					http(url,'get').then(function(data){
						if(data.id){
							response = {
								authResponse:{
									accessToken:accesstoken,
									userID:data.id,
									name:data.name
								}
							};
							$("#facebook").hide();
							$("#continue").show();
								$("#go").append("Continue as "+ response.authResponse.name);
								$("#go").click(function(){
									testAPI(response);
							})
						}
					})
					
				}
			}


		}else if(redirectArr[j] == '#access_token'){
			$("#facebook").hide();
			$("#loading").show();
			var token = redirectArr[j+1];
			getUserId(token);
			document.cookie = "token" + "="+ token + ";";
		}
	}

	function getUserId(token){
		var url = "https://graph.facebook.com/me?access_token="+token;
		http(url,'get').then(function(data){
			if(data.id){
				var response = {
					authResponse:{
						accessToken:token,
						userID:data.id
					}
				};
				testAPI(response);
			}
		})
	}


	var init = function(){
        string = stringEN;
		$('#name').attr('placeholder',string.nameNote);
		$('#psw').attr('placeholder',string.pswNote);
		$('#submit').html(string.submitText);
		$('#help').html(string.helpNote);
	};
	init();


	$("#logFacebook").click(function(){
		$("#warn2").show();
	})

	$("#blank").click(function(){
		$("#warn2").hide();
	})

	$("#jump").click(function(){
		$("#warn2").hide();
		var url = 'https://oauth.ai-keys.com/';
		$("#loading").show();
		window.location = encodeURI("https://www.facebook.com/dialog/oauth?client_id=1285249481550769&redirect_uri="+url+"&response_type=token");
	})

  	

  	// Here we run a very simple test of the Graph API after login is
	// successful.  See statusChangeCallback() for when this call is made.
	function testAPI(response) {
		var backString,redirectUrl;
		var cookie = document.cookie.split(";");
		for (var i = cookie.length - 1; i >= 0; i--) {
			var temp = cookie[i].split("=")[0].trim();
			if(temp == 'back'){
				backString = cookie[i].trim().substring(5);
			}else if(temp == 'redirect'){
				redirectUrl = cookie[i].trim().substring(9);
			}
		}
		if(!backString){
			return;
		}
	    var url = serverUrl +'v2/login/auth.php?'+backString;
	    var data = {
	    	accesstoken:response.authResponse.accessToken,
	    	id:response.authResponse.userID,
	    	thirdtype:"facebook",
	    	nickname:response.authResponse.userID,
	    	appid:"1285249481550769"
	    };
	    var header = {
	    	logintype:"thirdlogin"
	    };

	    http(url,'post',data,header).then(function(data){
	    	if(data&&data.code){
	    		var exp = new Date();
	    		exp.setTime(exp.getTime() + (-1 * 24 * 60 * 60 * 1000));
	    		document.cookie = "back="+ backString + ";expires=" + exp.toGMTString() + ";path=/";
	    		document.cookie = "redirect="+ redirectUrl + ";expires=" + exp.toGMTString() + ";path=/";
	    		$("#loading").hide();
				window.location.href = unescape(redirectUrl) + '?code='+data.code+'&state='+data.state;
			}else{
				var msg = dealWith(data.state)
				toast(msg);
			}
	    },function(data){
	    	var msg = dealWith(data.state)
			toast(msg);
	    })

  	}



	$("#close").click(function(){
		$("#warn1").hide();
	})

	$("#name").focus(function(){
		$("#delete").show();
	})

	$("#psw").focus(function(){
		$("#icon").show();
	})

	
	$("#eye").click(function(){
		if($("#eye").hasClass('active')){
			$("#eye").removeClass('active');
			$("#psw").attr("type","password");
			$("#icon").attr("src","./img/open.png");
		}else{
			$("#eye").addClass('active');
			$("#psw").attr("type","text");
			$("#icon").attr("src","./img/eye.png");
		}
	})

	$("#delete").click(function(){
		$("#name").val('');
	})
	
	$('#submit').click(function(){
        if(!$("#name").val()){
        		toast('Please enter the account');
            return;
        }
        if(!$("#psw").val()){
        		toast('Please enter the password');
            return;
        }
		var url = serverUrl +'v2/login/auth.php?'+backString;
        var name = $("#name").val().trim();
		var psw = $("#psw").val();
		var sendObj = {
			"phone":name,
			"password":psw
		};

		http(url,'post',sendObj).then(function(data){
			if(data&&data.code){
				if (redirectUrl.indexOf('%3F')>-1)
				{
					location.href = unescape(redirectUrl) + '&code='+data.code+'&state='+data.state;
				}
				else
				{
					location.href = unescape(redirectUrl) + '?code='+data.code+'&state='+data.state;
				}
			}else{
				if(data.state){
					var msg = dealWith(data.state);
					if(msg.text){
						toast(msg.value,msg.text);
					}else{
						toast(msg);
					}
				}else{
					toast(data.error_description)
				}
			}
		},function(data){
			if(data.state){
				var msg = dealWith(data.state)
				if(msg.text){
					toast(msg.value,msg.text);
				}else{
					toast(msg);
				}
			}else{
				toast(data.error_description)
			}
		})
	})

})();	
