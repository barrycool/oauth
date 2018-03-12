<?php
require_once __DIR__.'/server.php';

$request = OAuth2\Request::createFromGlobals();
$response = new OAuth2\Response();

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
    $response->send();

    error_log('oauth2 invalid request');
    error_log($request->query['redirect_uri']); 

    die;
}

// display an authorization form
if (empty($_POST)) {
  exit('
<form method="post">
  <label>Smart IR, Do You Authorize tianmao?</label><br />
  <input type="submit" name="authorized" value="yes">
  <input type="submit" name="authorized" value="no">
</form>');
}

// print the authorization code if the user has authorized your client
$is_authorized = ($_POST['authorized'] === 'yes');
$server->handleAuthorizeRequest($request, $response, $is_authorized);
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

  error_log($return);

  header("Location: ".$return); 
  //header("Location: ".$m."&code=".$code); 
  #header("Location: ".$m); 
  exit("SUCCESS! Authorization Code: $code");
}
$response->send();


?>

