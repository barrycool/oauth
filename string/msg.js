var msgs = [
	{
		key:'服务器繁忙',
		value:'Server is busy'
	},{
		key:'请求时间过期',
		value:'Request timeout'
	},{
		key:'数据错误',
		value:'Account or password or code incorrect'
	},{
		key:'帐号或密码不正确',
		value:'Signin failed. Please make sure you have entered correct BroadLink account name and password.',
		text:'Try again'
	},{
		key:'请登陆后操作',
		value:'Please log in first'
	},{
		key:'三小时后再登陆',
		value:'Log in after 3 hours'
	},{
		key:'该账号被禁用',
		value:'Account has been disabled'
	},{
		key:'帐号不存在',
		value:'Account does not exist'
	},{
		key:'用户不存在',
		value:'Account does not exist'
	},{
		key:'手机号码或密码不正确',
		value:'Signin failed. Please make sure you have entered correct BroadLink account name and password.'
	},{
		key:'不支持的第三方oauth平台',
		value:'Unsupported third party oauth platform'
	},{
		key:'第三方oauth未认证成功',
		value:'Third party oauth authentication failed'
	},{
		key:'原密码错误',
		value:'Old password incorrect'
	},{
		key:'请重新登陆',
		value:'Please log in again'
	},{
		key:'手机号码错误',
		value:'Phone number error'
	},{
		key:'数据超长',
		value:'Server abnormal'
	}
]

var menu = [,""]

var qa = [
	{
		title:"General",
		info:[
			{
				q:"Q: Which account shall I log in to use this skill?",
				a:'A: You have 2 options:</br>&nbsp;1)  ihc App account: Please download ihc App from App Store or Google Play. Sign up an ihc account by your email or phone number. Then input the account and password in the skill page of Alexa App.</br>&nbsp;2)  Facebook account: You can also use your Facebook account for quick sign-in in ihc App, then tap "Log in with Facebook" in the skill page of Alexa App, input the same Facebook account to log in.'
			},
			{
				q:"Q: Why I cannot receive the verification code for account registration?",
				a:"A: If you use email to sign up, please check your spam mail. If you still cannot receive it, please try again with other email address.If you use phone number to sign up, please check if your cellular network is fine and you may need to check if the SMS is blocked by certain Apps. If you still cannot receive the verification code, please try again or use Facebook account to sign in."
			},
			{
				q:"Q: Why the verification time is within 1 minute? This is too short and I may not have enough time to find the code.",
				a:"A: You have to wait for 1min to send another verification code but the actual time gap for entering code is 10min. You can still enter the code found in your email box to complete verification even the 1min countdown ends."
			}
		]
	},
	{
		title:"Universal Remote",
		info:[
			{
				q:"Q: Why I still cannot control the TV with my skill using  BroadLink Intelligent Home Center (ihc) App account?",
				a:"A: Please make sure you are using ihc App with V1.4.1.3545 or above versions. If you are using earlier versions please download the latest version from App Store or Google Play. If you are using the latest version, please delete the previously created TV remote and add again to try the control."
			},{
				q:"Q: Why I cannot control some channels such as Channel 123 through Alexa?",
				a:'A: Please make sure your purchased RM pro Universal Remote which is "Sold by Amazon". If it is sold by other sellers, you need to make sure you are using the latest version of ihc App not e-Control App. Then find your RM pro in ihc App and tap the function menu in top-right corner to check the device firmware version. Make sure the firmware version is V20025 or above (Please update the firmware if it is earlier version). Now you can add your TV again and learn your favorite channels in channel list. Then re-discover device in the Alexa App and try voice control.If the firmware update feature is not available, that means the App version is not up-to-date. Please wait for the push message of App for update. It may take 2-3 days. After App update is done, the firmware update feature will be enabled.'
			},{
				q:"Q: Why I cannot discover my TV after I enabled BroadLink Remote Control skill?",
				a:'A: Please make sure you are using ihc App with V1.4.1.3545 or above versions and you added your TV from preset "Television" category by choosing brand for auto learning. User-defined remote does not support Alexa service.'
			}
		]
	}

] 