<?php
require_once __DIR__.'/homeassistant_conf.php';
class AliGenie_Request
{
	protected $header = array(
		"namespace" => "",
		"name" => "",
		"messageId" => "",
		"payLoadVersion" => "",
	);
	protected $payload;
	protected $temp;
	public function handleRequest($request)
	{
	}
}

class AliGenie_Response
{
	protected $header;
	protected $payload;
	protected $temp;
	public function handleResponse()
        {
				                
        }


}

class Response{
	#public $result = array(
	#	"result" => "",
	#	"name" => "",
	#	"deviceId" => "",
	#	"errorCode" => "",
	#	"message" => "",
	#
	#);
	public $result;
	public $name;
	public $deviceId;
	public $errorCode;
	public $message;
	public $Respropertiesname;
	public $Respropertiesvalue;
	public $propertiesnameset;
	public function put_query_response($result,$propertiesname,$properties,$name,$deviceId,$errorCode,$message) { 
		$this->result = $result;
		$this->name = $name;
		$this->deviceId = $deviceId;
		$this->errorCode = $errorCode;
		$this->message = $message;
		switch($name)
		{
		case "QueryResponse":
			if($propertiesname!="")
			{
				$this->Respropertiesname=$propertiesname;
				$this->Respropertiesvalue=$properties;
			}else
			{
		                $this->errorCode = "SERVICE_ERROR";
				$this->message = "No temperature return";
			}
			break;
		case "QueryTemperatureResponse":
			if($properties!="")
			{
				$this->Respropertiesname=$propertiesname;
				$this->Respropertiesvalue=$properties;
			}else
			{
		                $this->errorCode = "SERVICE_ERROR";
				$this->message = "No temperature return";
			}
			break;
		case "QueryPowerstateResponse":
			if($properties!="")
			{
				$this->Respropertiesname=$propertiesname;
				$this->Respropertiesvalue=$properties;
			}else
			{
		                $this->errorCode = "SERVICE_ERROR";
				$this->message = "No powerstate return";
			}
		case "QueryColorResponse":
			if($properties!="")
			{
				$this->Respropertiesname=$propertiesname;
				$this->Respropertiesvalue=$properties;
			}else
			{
		        $this->errorCode = "DEVICE_NOT_SUPPORT_FUNCTION";
				$this->message = "not support";
				$this->result = FALSE;
			}
			break;	
		case "QueryHumidityResponse":
			if($properties!="")
			{
				$this->Respropertiesname=$propertiesname;
				$this->Respropertiesvalue=$properties;
			}else
			{
		                $this->errorCode = "SERVICE_ERROR";
				$this->message = "No temperature return";
			}
			break;
		case "QueryPm2.5Response":
			if($properties!="")
			{
				$this->Respropertiesname=$propertiesname;
				$this->Respropertiesvalue=$properties;
			}else
			{
		                $this->errorCode = "SERVICE_ERROR";
				$this->message = "No temperature return";
			}
			break;
		case "QueryBrightnessResponse":
			if($properties!="")
			{
				$this->Respropertiesname=$propertiesname;
				$this->Respropertiesvalue=$properties;
			}else
			{
		        $this->errorCode = "DEVICE_NOT_SUPPORT_FUNCTION";
			$this->message = "not support";
			$this->result = FALSE;
			}
			break;	
		case "QueryChannelResponse":
		if($properties!="")
			{
				$this->Respropertiesname=$propertiesname;
				$this->Respropertiesvalue=$properties;
			}else
			{
			    $this->errorCode = "DEVICE_NOT_SUPPORT_FUNCTION";
				$this->message = "not support";
				$this->result = FALSE;
			}
		    
			break;	
		case "QueryModeResponse":
			if($properties!="")
			{
				$this->Respropertiesname=$propertiesname;
				$this->Respropertiesvalue=$properties;
			}else
			{
				$this->errorCode = "DEVICE_NOT_SUPPORT_FUNCTION";
				$this->message = "not support";
				$this->result = FALSE;
			}
		        
			break;	
		default:
		if($properties!="")
			{
				$this->Respropertiesname=$propertiesname;
				$this->Respropertiesvalue=$properties;
			}else
			{
				$this->errorCode = "DEVICE_NOT_SUPPORT_FUNCTION";
				$this->message = "not support";
				$this->result = FALSE;
			}
		      
			break;	
		}
		//$this->result->result = $result;
		//$this->result->name = $name;
		//$this->result->deviceId = $deviceId;
		//$this->result->errorCode = $errorCode;
		//$this->result->message = $message;
	} 
		
	public function put_control_response($result,$name,$deviceId,$errorCode,$message) { 
		$this->result = $result;
		$this->name = $name;
		$this->deviceId = $deviceId;
		$this->errorCode = $errorCode;
		$this->message = $message;
		//$this->result->result = $result;
		//$this->result->name = $name;
		//$this->result->deviceId = $deviceId;
		//$this->result->errorCode = $errorCode;
		//$this->result->message = $message;
	} 
	
}
function  Device_status($obj)
{
	$deviceId=$obj->payload->deviceId;
	$action = '';
	$device_ha = '';
	$response_name = $obj->header->name.'Response';
	switch(substr($deviceId,0,stripos($deviceId,".")))
	{
	case 'switch':
		$device_ha='switch';
		break;
	case 'light':
		$device_ha='light';
		break;
	case 'media_player':
		$device_ha='media_player';
		break;
	default:
		break;
	}

	switch($obj->header->name)
	{
	case 'QueryPowerState':
		$action='powerstate';
		break;
	case 'QueryColor':
		$action='color';
		break;
	case "QueryTemperature":
		$action="temperature";
		break;
	case "QueryWindspeed":
		$action="windspeed";
		break;
	case "QueryBrightness":
		$action="brightness";
		break;
	case "QueryFog":
		$action="fog";
		break;
	case "QueryHumidity":
		$action="humidity";
		break;
	case "QueryPm25":
		$action="pm25";
		break;
	case "QueryChannel":
		$action="channel";
		break;
	case "QueryNumber":
		$action="number";
		break;
	case "QueryDirection":
		$action="direction";
		break;
	case "QueryAngle":
		$action="angle";
		break;
	case "QueryAnion":
		$action="anion";
		break;
	case "QueryEffluent":
		$action="effluent";
		break;
	case "QueryMode":
		$action="mode";
		break;
	default:
		$action = "states";
	}	
	 if($action==""&&$device_ha=="")
        {
                $response = new Response();
		$response->put_query_response(False,"","",$response_name,$deviceId,"not support","action or device not support,name:".$obj->header->name." device:".substr($deviceId,0,stripos($deviceId,".")));
		return $response;
        }
	 
#	$query_response = file_get_contents(URL."/api/".$action."/".$deviceId."?api_password=".PASS);
		$query_response = file_get_contents(URL."/returnstatue.php");
		$statelamp = json_decode($query_response); 	
	if($statelamp->data=="turn_on")
	{	
		$state='on';
		$statevalue=100;
	}
	elseif($statelamp->data=="turn_off")
	{
		$state='off';
		$statevalue=0;
	}
	elseif($statelamp->data=="set_bright")
	{
		$state='on';	
		$statevalue=(int)$statelamp->value;
#	$StatueFileName = "1.txt";
#	if( ($StatueRes=fopen ($StatueFileName,"w+")) === FALSE){
#	exit();
#	}
#	if(!fwrite ($StatueRes,$statevalue)){
#	fclose($StatueRes);
#	exit();
#	}
#	fclose ($StatueRes);	
	}
	error_log($state);
	$response = new Response();
        $response->put_query_response(True,$state,$statevalue,$response_name,$deviceId,"","");
	return $response; 

}	
function  Device_control($obj)
{
        // result:
        //      result=true
        //      name    
        //      deviceId
        //
        //      result=false
        //      deviceId
        //      errorCode
	//      message
	$deviceId=$obj->payload->deviceId;
	$response_name = $obj->header->name.'Response';
	/*if($action==""&&$device_ha=="")
	{
		$response = new Response();
		$response->put_control_response(False,$response_name,$deviceId,"not support","action or device not support,name:".$obj->header->name." device:".substr($deviceId,0,stripos($deviceId,".")));
		return $response;
	}
	if(is_null($lightvalue))
	{
		$lightvalue=-1;
	}
	 */

	$cmd = "./tcp_client ".$deviceId."_".$obj->header->name;
	
	exec($cmd);

	$response = new Response();
	$response->put_control_response(True,$response_name,$deviceId,"","");	
	return $response;
}


?>
