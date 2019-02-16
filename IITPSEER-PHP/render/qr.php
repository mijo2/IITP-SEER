<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

//Assuming that this script is requested by the app with POST method with 
//the following value:
//'ID' => '1601CS53' 
//and APIKEY when implemented
//'ID' is the key and '1601CS53' is the value.

include 'dbConfig.php';
// require('defines.php');
ini_set("log_errors", 1);
ini_set("error_log", "qr.log");
// $url = $_SERVER['REQUEST_URI'];

// $url1 = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
// $parts = parse_url($url1, PHP_URL_QUERY);
// parse_str($parts, $out);
// $actual_id = $out['id'];

$msg = $_POST["message"];
$decoded_msg = json_decode($msg, false);
$actual_id = $decoded_msg->roll;
$token = $decoded_msg->token;
$name_global = $decoded_msg->name;


error_log( $url."\n\t".json_encode($_POST) );
header('Content-Type: application/json');

$res = ["status" => 400,"message"=>"Invalid parameters", "data"=>null];
$res1 = ["FullName"=>"", "Branch"=>"", "ImageURL"=>"","Phone"=>"", "Email"=>""];

date_default_timezone_set("Asia/Kolkata");
$date_time = date('Y-m-d H:i:s',time());

function validate($id){
    //global $pyHashSalt;
    for($i = 0; $i <= 7; $i++){
        if($i == 4 || $i == 5){
            if(!preg_match("/^[A-Z]$/", $id[$i]))
                return false;
        }
        else{
            if(!preg_match("/^[0-9]$/", $id[$i]))
                return false;            
        }
    }
    return true;
}

// creates response and outputs as JSON. 
function respond($statusCode, $message, $object = []){
    $res["status"] = $statusCode;
    http_response_code($statusCode);
    $res["message"] = $message;
    $res["data"] = $object;
    echo json_encode($res);
    exit(1);
}

//used to autherize in a website
function auth($id1, $name, $token_local){
    if($_POST['APIKey'] == "7ec992283ee0ce3b8df55159cec4fd37a6bd31ab")
    {   
        $hash = sha1("IITPseerSecReTKey".$id1.$name);
        if($hash == $token_local)
            return true;
        else
            return false;
    }
    else
        return false;
}

// $BuildingNumber = $_POST['BuildingNo'];
if(validate($actual_id) && auth($actual_id, $name_global, $token)){
    $sql_query = "SELECT ID, FullName, Branch, PhoneNo, Email FROM People WHERE ID='$actual_id'";
    if($link=mysqli_connect($dbServername, $username, $password, $dbname)){
        $result1 = mysqli_query($link,$sql_query);
        if(mysqli_num_rows($result1) > 0){
            $list_users = array();
            while($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC))
            {
                $res1["FullName"] = $row1["FullName"];
                $res1["Branch"] = $row1["Branch"];
                $res1["ImageURL"] .= "People/images/".$actual_id.".jpg";
                $res1["Phone"] = $row1["PhoneNo"];
                $res1["Email"] = $row1["Email"];

            }
            respond(200,"The user is fetched", $res1);
        }
        else{
            respond(401, "Person Not Found");
        }
    }
    else{
        respond(500, "DB Error");
    }
}
else{
    respond(403, "Authentication Error or No user id");
}

echo json_encode($res);

//Returns FullName, Branch and a image url for the person.
?>


