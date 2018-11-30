<?php
require_once __DIR__.'/server.php';

error_log('token----------------');
/*
error_log(json_encode($_SERVER));
error_log('token++++++++++++++++');
error_log(json_encode($_POST));
*/

if (isset($_GET['grant_type']))
{
	$_POST['grant_type']=$_GET['grant_type'];
}
if (isset($_GET['code']))
{
	$_POST['code']=$_GET['code'];
}
if (isset($_GET['redirect_uri']))
{
	$_POST['redirect_uri']=$_GET['redirect_uri'];
}

if (isset($_GET['client_id']))
{
	$_POST['client_id']=$_GET['client_id'];
}
else if (!isset($_POST['client_id']))
{
	$_POST['client_id']=$_SERVER['PHP_AUTH_USER'];
}

if (isset($_GET['client_secret']))
{
	$_POST['client_secret']=$_GET['client_secret'];
}
else if (!isset($_POST['client_secret']))
{
	$_POST['client_secret']=$_SERVER['PHP_AUTH_PW'];
}

/*
error_log($_POST['grant_type']);
error_log($_POST['client_id']);
error_log($_POST['client_secret']);
error_log($_POST['code']);
error_log($_POST['redirect_uri']);
*/

// Handle a request for an OAuth2.0 Access Token and send the response to the client
$server = new OAuth2\Server($storage);
$server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));
$resp = $server->handleTokenRequest(OAuth2\Request::createFromGlobals(), new OAuth2\Response());
/*
foreach($resp->getParameters() as $k=>$v)
{ 
	error_log($k."=>".$v);
}
*/
$resp->send();


?>

