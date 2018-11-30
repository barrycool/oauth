<?php
require_once __DIR__.'/server.php';

error_log('YYYYYYYYYYYYYYYYYYYYYYYYY');

if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
	die('bad request 1');
}

/*foreach($_REQUEST as $key => $value)
{
	error_log('key:'.$key.'--'.'value:'.$value); 
}*/

/*foreach($_SERVER as $key => $value)
{
	error_log('key:'.$key.'--'.'value:'.$value); 
}*/

$request = OAuth2\Request::createFromGlobals();
$response = new OAuth2\Response();

if (!isset($request->query['client_id']))
{
	$request->query['client_id'] = $_REQUEST['client_id'];
}
if (!isset($request->query['redirect_uri']))
{
	if (!isset($_REQUEST['redirect_uri']))
	{
		$client_info=$storage->getClientDetails($request->query['client_id']);
		$request->query['redirect_uri'] = $client_info['redirect_uri'];
	}
	else
	{
		$request->query['redirect_uri'] = $_REQUEST['redirect_uri'];
	}
}
if (!isset($request->query['response_type']))
{
	$request->query['response_type'] = $_REQUEST['response_type'];
}
if (!isset($request->query['state']))
{
	$request->query['state'] = $_REQUEST['state'];
}

/*error_log($request->query['redirect_uri']); 
error_log($request->query['client_id']); 
error_log($request->query['response_type']); 
error_log($request->query['state']); */

// validate the authorize request
$m=$request->query['redirect_uri']; 
if (strpos($m, "?") !== FALSE)
{
	$temp = substr($m,0,strpos($m,"?"));
}
else
{
	$temp = $m;
}
$request->query['redirect_uri']= $temp; 

#exit("$m||||$temp");

if (!$server->validateAuthorizeRequest($request, $response)) {

    error_log('oauth2 invalid request');
    error_log(implode('==>', $response->getParameters()));
    error_log($request->query['redirect_uri']); 

    $response->send();

    die;
}

// display an authorization form
/*if (empty($_POST)) {
  exit('
<form method="post">
  <label>Smart IR, Do You Authorize tianmao?</label><br />
  <input type="submit" name="authorized" value="yes">
  <input type="submit" name="authorized" value="no">
</form>');
}r*/
function post($url, $post_data = '', $timeout = 5){ 
    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_POST, 1); 
    if($post_data != ''){
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    }   
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $file_contents = curl_exec($ch);
    curl_close($ch);
    return $file_contents;
}

$login_form = file_get_contents("php://input");
$login_json = json_decode($login_form);
if (!isset($login_json->phone) || !isset($login_json->password)) {
	die('invalid user name or passwd\n');
}

/*
$url = 'http://www.ai-keys.com:8080/smartdevice_cloud_service/mng';
$login_data = new stdclass();
$login_data->name_space = 'AccountManagement';
$login_data->name = 'Login';
$login_data->loginName = $login_json->phone;
$login_data->passwd = $login_json->password;

$result = post($url, json_encode($login_data));
//error_log($result);
$result_json = json_decode($result);
if (!isset($result_json->result->code) || $result_json->result->code !== 'OK') {
	die('invalid user name or passwd\n');
}

if (!isset($result_json->result->userInfo->userId)) {
	die('server is not valid\n');
}
*/

$_POST['authorized'] = 'yes';

// print the authorization code if the user has authorized your client
$is_authorized = ($_POST['authorized'] === 'yes');
$server->handleAuthorizeRequest($request, $response, $is_authorized /*, $result_json->result->userInfo->userId*/);
if ($is_authorized) {
  // this is only here so that you get to see your code in the cURL request. Otherwise, we'd redirect back to the client
  $code = substr($response->getHttpHeader('Location'), strpos($response->getHttpHeader('Location'), 'code=')+5);
  if (strpos($m, "?") !== FALSE)
  {
    $return = urldecode($m)."&code=".$code; 
  }
  else
  {
    $return = urldecode($m)."?code=".$code; 
  }

  //error_log("return".$return);

  //header("Location: ".$return); 
  //header("Location: ".$m."&code=".$code); 
  #header("Location: ".$m); 

  header("Content-Type: application/json");
  header("Access-Control-Allow-Headers: managegroupid,managegrouptype,Content-Type,reqtype, Content-Range, Content-Disposition, Content-Description, x-requested-with, content-type, reqUserId, reqUserSession, bizCode, reqBizGroup, reqUserSession, bizsign");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Allow-Methods: GET");
  header("Access-Control-Allow-Methods: DELETE");
  header("Access-Control-Allow-Methods: PUT");
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: language");

  $arr = array ('code'=>$code,'msg'=>'ok','state'=>$request->query['state'],'status'=>0);

  exit(json_encode($arr));

  //exit("SUCCESS! Authorization Code: $code");
}
$response->send();


?>

