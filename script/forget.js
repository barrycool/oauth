(function(){
	var sendObj;
	var timer;
	var urlString = window.location.href;
	var backString = urlString.split('?')[1]?urlString.split('?')[1]:'';

	$("#close").click(function(){
		$("#warn1").hide();
	})

	$("#closeModify").click(function(){
		$("#modify").hide();
	})

	$("#next").click(function(){
		var url = serverUrl + "oauth/v2/account/retrievecode";
		var account = $("#account").val();
		if(account.match(/^1[3578]\d{9}$/)){
			sendObj = {phone:account};
			account = account.substr(0,3)+"****"+account.substr(-4,4);
		}else if(account.match(/^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/)){
			sendObj = {email:account};
		}else{
			toast("Please check the account");
			return;
		}
		$("#info").html(account);
		http(url,"post",sendObj,{language:"en-us"}).then(function(data){
			if(data && data.status == 0){
				$("#forget").hide();
				//clean out 
				$("#psw").val("");
				$("#code").val("");
				$("#find").show();
				clearInterval(timer);
				countDown();
			}else{
				var msg = dealWith(data.msg);
				if(msg == 'Server is busy'){
					msg = 'Verification code quota (10 times per day) has run out.';
				};
				toast(msg);
			}
		},function(data){
			var msg = dealWith(data.msg);
			if(msg == 'Server is busy'){
				msg = 'Verification code quota (10 times per day) has run out.';
			};
			toast(msg);
		})
	})

	$("#get").click(function(){
		//clean out 
		$("#psw").val("");
		$("#code").val("");
		var url = serverUrl + "oauth/v2/account/retrievecode";
		http(url,"post",sendObj,{language:"en-us"}).then(function(data){
			if(data && data.status == 0){
				clearInterval(timer);
				countDown();
			}else{
				var msg = dealWith(data.msg);
				if(msg == 'Server is busy'){
					msg = 'Verification code quota (10 times per day) has run out.';
				};
				toast(msg);
			}
		},function(data){
			var msg = dealWith(data.msg);
			if(msg == 'Server is busy'){
				msg = 'Verification code quota (10 times per day) has run out.';
			};
			toast(msg);
		})
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

	function countDown(){
		var count = 60;
		$("#get").html("Resend("+count+")");
		$("#get").attr("disabled",true);
		timer = setInterval(function(){
			count--;
			$("#get").html("Resend("+count+")");
			if(count < 0){
				clearInterval(timer);
				$("#get").html("send");
				$("#get").attr("disabled",false);
			}
		},1000)
	}

	$("#submit").click(function(){
		var code = $("#code").val();
		var psw = $("#psw").val();
		if(code.length!==4){
			toast("Please check the verify code");
			return;
		}else if(psw.length<6 || psw.length>12){
			toast("Please enter the password for 6-12 digits");
			return;
		}
		var url = serverUrl + "oauth/v2/account/retrievepswd";
		var obj = {
			code:code,
			newpassword:psw
		}
		sendObj = $.extend(true,sendObj,obj);
		http(url,"post",sendObj).then(function(data){
			if(data && data.status == 0){
				$("#modify").show();
				setTimeout(function(){
					$("#modify").hide();
					window.location.href = "./login.html?"+backString;
				},3000);
			}else{
				var msg = dealWith(data.msg)
				toast(msg);
			}	
		},function(data){
			var msg = dealWith(data.msg)
			toast(msg);
		})
	})


})()