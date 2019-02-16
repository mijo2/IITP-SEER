<?php
 ini_set( "display_errors", 0); 

header('Access-Control-Allow-Origin: *');  
define('TIMEZONE', 'Asia/Kolkata');
date_default_timezone_set(TIMEZONE);

 class Routing
{
	function __construct()
	{
		return null;
	}
	public function Redirect($url)
	{
		return null;
	}
}

$url = $_SERVER['REQUEST_URI'];
preg_match('@(.*)index.php(.*)$@', $_SERVER['PHP_SELF'], $mat );
$base = '@^'. $mat[1];
if(preg_match($base . 'cAPI/checkLogin?$@', $url, $match))
{
	if(isset($_SESSION['uID']))
	{
			echo json_encode(array(1,$_SESSION['uID'],$_SESSION['uName'])) ;
	}
	else
	{
			echo json_encode(array(0)) ;
	}
} 
elseif (preg_match($base . '$@', $url, $match))
{
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
	$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	header('Location: '.$uri.'/iitpseer/radmin/');
	exit;
}
elseif(preg_match($base . 'login?$@', $url, $match)) 
{  
	//Logging in stuff.
    require ('render/loginController.php');
}
// elseif (preg_match($base.'people[?]id=([0-9]{4})([A-Z]{2})([0-9]{2})$@', $url, $match))
// { 	
// 	require ('render/qr.php');
// }
elseif (preg_match($base.'people/$@', $url, $match))
{ 	
	require ('render/qr.php');
}
elseif (preg_match($base . 'Exit/$@', $url, $match))
{ 	
	//Qr code stuff 
    require ('render/Exit.php');
}
elseif (preg_match($base . 'Entry/$@', $url, $match)) 
{ 	
	//Qr code stuff 
    require ('render/Entry.php');
}
elseif (preg_match($base . 'building/$@', $url, $match))
{ 	
	//Qr code stuff 
    require ('render/building.php');
}
elseif (preg_match($base . 'signup/$@', $url, $match))
{ 	
	//Qr code stuff 
    // if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
	// 	$uri = 'https://';
	// } else {
	// 	$uri = 'http://';
	// }
	// $uri .= $_SERVER['HTTP_HOST'];
	// header('Location: '.$uri.'/signup/');
	// exit;
	require('signup/index.php');
}
