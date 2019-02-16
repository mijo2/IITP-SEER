<?php
session_start();
include 'dbConfig.php';
include 'render/log.php';
include 'render/checkAccess.php';

function SQLInjFilter(&$unfilteredString){
	$unfilteredString = mb_convert_encoding($unfilteredString, 'UTF-8', 'UTF-8');
	$unfilteredString = htmlentities($unfilteredString, ENT_QUOTES, 'UTF-8');
	// return $unfilteredString;
}

$error = "";
$return = "";
$status = 0;
$uID=-1;
$ret = array();

if (!isset($_POST['userid'])) { //IN APP, the name to be used for username field should be 'userid'.
	$error .= "Celesta ID blank. ";
	$status = 400;
}

if (!isset($_POST['password']) || $_POST['password']=='' ) {
    $error .= "password blank. ";
    $status = 400;
}

if($status!=400){
	//$debug = "in here1";
	//SQL inj sanitation here?
	SQLInjFilter($_POST['userid']);
	SQLInjFilter($_POST['password']);
	$admin_id = $_POST['userid'];
	//db stuff here
	$sql = "SELECT * FROM admins WHERE `adminID`= '".$admin_id."'";
	if($link =mysqli_connect($servername, $username, $password, $dbname)){
	$result = mysqli_query($link,$sql);
	    if(!$result || mysqli_num_rows($result)<1){
	    	$status=403;// $debug .=mysqli_error($link)."  in2:    ". mysqli_num_rows($result);
	    	$return="Invalid credentials. Access Forbidden.";
		    errorLog(mysqli_errno($link)." ".mysqli_error($link));
	    } else {    
            $debug.="  in3 ".mysqli_num_rows($result);
	    	while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
	    		if($row['pswd']==sha1($_POST['password'])){
//$debug.="in4:".$row['pswd']." hmm: ".sha1($_POST['password']);
	    			$status=200;
	    			$return="Welcome ".$row['adminName'];
				$uName=$row['adminName'];
				$adminID=$row['adminID'];
				$_SESSION['uid']=$adminID;
				$_SESSION['name'] = $row['adminName'];
	    			//set sessionID etc etc...
	    		}else{//$debug.="in5:".$row['pswd']." hmm: ".sha1($_POST['password']);
	    			$status=403;
	    			$return="Invalid credentials. Access Forbidden.";	
				errorLog(mysqli_errno($link)." ".mysqli_error($link));
				}
	    	  }
	    	}
    } else{
    	//error to connect to db
		$status = 500;
		$debug.="in6:";
    	$error = "error connecting to DB";
		errorLog(mysqli_errno($link)." ".mysqli_error($link));
    }
}

if($status == 200){
	$ret["status"] = 200;
	$ret["adminID"] = $adminID;
	$ret["name"]=$uName;
	$ret["message"] = $return;
}else{
	$ret["status"] = $status;
	$ret["message"] = $error." For help, error reference no: $errRef ";//.$_POST['emailid'].'  -  '.$_POST['password'];
	errorLog($error);
}

echo json_encode($ret);

?>