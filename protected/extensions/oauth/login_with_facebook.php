<?php
/*
 * login_with_facebook.php
 *
 * @(#) $Id: login_with_facebook.php,v 1.3 2013/07/31 11:48:04 mlemos Exp $
 *
 */

	/*
	 *  Get the http.php file from http://www.phpclasses.org/httpclient
	 */
	require('http.php');
	require('oauth_client.php');

	$client = new oauth_client_class;
	$client->debug = false;
	$client->debug_http = true;
	$client->server = 'Facebook';
//	$client->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].
//		dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/RegisterFaceBookLogin';

	$client->client_id = '671328532974095'; $application_line = __LINE__;
	$client->client_secret = '0c08bfa80ff0c7e7db353f758914fc39';

	if(strlen($client->client_id) == 0
	|| strlen($client->client_secret) == 0)
		die('Please go to Facebook Apps page https://developers.facebook.com/apps , '.
			'create an application, and in the line '.$application_line.
			' set the client_id to App ID/API Key and client_secret with App Secret');

	/* API permissions
	 */
	$client->scope = 'email';
	if(($success = $client->Initialize()))
	{
		if(($success = $client->Process()))
		{
			if(strlen($client->access_token))
			{
				$success = $client->CallAPI(
					'https://graph.facebook.com/me', 
					'GET', array(), array('FailOnAccessError'=>true), $facebookUser);
//                                                                print_r($facebookUser);DIE("inside SUCCESS SADFDS");
			}
		}
		$success = $client->Finalize($success);
	}
	if($client->exit)
		exit;
	if($success)
	{            
//        echo "<pre>";
//        print_r($_SESSION);
//        DIE("inside SUCCESS");
?>
<!--<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Facebook OAuth client results</title>
</head>
<body>
<?php
//		echo '<h1>', HtmlSpecialChars($user->name), 
//			' you have logged in successfully with Facebook!</h1>';
//		echo '<pre>', HtmlSpecialChars(print_r($facebookUser, 1)), '</pre>';
?>
</body>
</html>-->
<?php  
	}
	else
	{ #DIE("inside error");
?>
<!--<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>OAuth client error</title>
</head>
<body>
<h1>OAuth client error</h1>
<pre>Error: <?php echo HtmlSpecialChars($client->error); ?></pre>
</body>
</html>-->
<?php
	}

?>