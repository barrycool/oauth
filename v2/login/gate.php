<?php
require_once __DIR__.'/aligenies_request.php';
$chars = md5(uniqid(mt_rand(), true));
$uuid  = substr($chars,0,8) . '-';
$uuid .= substr($chars,8,4) . '-';
$uuid .= substr($chars,12,4) . '-';
$uuid .= substr($chars,16,4) . '-';
$uuid .= substr($chars,20,12);

$poststr = file_get_contents("php://input");
$obj = json_decode($poststr);
$messageId = $uuid;

switch($obj->header->namespace)
{
case 'AliGenie.Iot.Device.Discovery':

	$str='{
  header: {
    namespace: "AliGenie.Iot.Device.Discovery",
    name: "DiscoveryDevicesResponse",
    messageId: "%s",
    payLoadVersion: 1
  },
  payload: {
    devices: [
      {
        deviceId: "sony_bravia_tv",
        deviceName: "电视",
        deviceType: "television",
        zone: "客厅",
        brand: "sony",
        model: "Sony Tv",
        icon: "https://home-assistant.io/demo/favicon-192x192.png",
        properties: [
          {
            status: "off"
          }
        ],
        actions: [
          "TurnOn",
          "TurnOff",
          "AdjustUpChannel",
          "AdjustDownChannel",
          "AdjustUpVolume",
          "AdjustDownVolume",
          "SetVolume",
          "SetMute",
          "CancelMute",
        ],
        extension: {
          link: "https://www.baidu.com"
        }
      },
      {
        deviceId: "media_fan",
        deviceName: "风扇",
        deviceType: "fan",
        zone: "客厅",
        brand: "media",
        model: "media fan",
        icon: "https://home-assistant.io/demo/favicon-192x192.png",
        properties: [
          {
            status: "off"
          }
        ],
        actions: [
          "TurnOn",
          "TurnOff",
          "AdjustUpVolume",
          "AdjustDownVolume",
          "SetVolume",
          "SetMute",
          "CancelMute",
        ],
        extension: {
          link: "https://www.baidu.com"
        }
      },
      {
        deviceId: "light5",
        deviceName: "灯",
        deviceType: "light",
        zone: "",
        brand: "ZTK",
        model: "ZTK light",
        icon: "https://home-assistant.io/demo/favicon-192x192.png",
        properties: [
          {
            status: "off"
          }
        ],
        actions: [
          "TurnOn",
          "TurnOff",
	  "SetBrightness",       
	  "AdjustBrightness",
	  "SetTemperature"
        ],
        extension: {
          link: "https://www.baidu.com"
        }
      }
    ]
  }
}';
	$resultStr = sprintf($str,$messageId);
	break;

case 'AliGenie.Iot.Device.Control':
	$result = Device_control($obj);
	if($result->result == "True" )
	{
		$str='{
  			"header":{
  			    "namespace":"AliGenie.Iot.Device.Control",
  			    "name":"%s",
  			    "messageId":"%s",
 			     "payLoadVersion":1
			   },
			   "payload":{
			      "deviceId":"%s"
			    }
			}';
		$resultStr = sprintf($str,$result->name,$messageId,$result->deviceId);
		//error_log($resultStr);
	}
	else
	{
		$str='{
			  "header":{
			      "namespace":"AliGenie.Iot.Device.Control",
			      "name":"%s",
			      "messageId":"%s",
			      "payLoadVersion":1
			   },
			   "payload":{
			        "deviceId":"%s",
			         "errorCode":"%s",
			         "message":"%s"
			    }
			}';
		$resultStr = sprintf($str,$result->name,$messageId,$result->deviceId,$result->errorCode,$result->message);
	}
	break;
case 'AliGenie.Iot.Device.Query':
	$result = Device_status($obj);
	if($result->result == "True" )
	{
		$str='{
  			"header":{
  			    "namespace":"AliGenie.Iot.Device.Control",
  			    "name":"%s",
  			    "messageId":"%s",
 			     "payLoadVersion":1
			   },
			   "payload":{
			      "deviceId":"%s"
                           },
			   "properties":[
			    {
	   	              "name":"powerstate",
	   	              "value":"%s"
		            },
			   {
			      "name":"brightness",
			      "value":"%d"
			   }
	                    ]

			}';
		$resultStr = sprintf($str,$result->name,$messageId,$result->deviceId,$result->Respropertiesname,$result->Respropertiesvalue);
#		$resultStr = sprintf($str,$result->name,$messageId,$result->deviceId,"powerstate","on");

	}
	else
	{
		$str='{
			  "header":{
			      "namespace":"AliGenie.Iot.Device.Control",
			      "name":"%s",
			      "messageId":"%s",
			      "payLoadVersion":1
			   },
			   "payload":{
			        "deviceId":"%s",
			         "errorCode":"%s",
			         "message":"%s"
			    }
			}';
		$resultStr = sprintf($str,$result->name,$messageId,$result->deviceId,$result->errorCode,$result->message);
	}
	break;
default:
	$resultStr='Nothing return,there is an error~!!';
}
error_log('-------');
error_log('----get-request---');
error_log($poststr);
error_log('----reseponse---');
error_log($resultStr);
echo($resultStr);
#print $resultStr;
?>

