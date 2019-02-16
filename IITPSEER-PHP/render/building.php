<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'dbConfig.php';
ini_set("log_errors", 1);
ini_set("error_log", "qr.log");

error_log( $url."\n\t".json_encode($_POST) );
header('Content-Type: application/json');

$res = ["status" => 400,"message"=>"Invalid parameters", "data"=>null];

date_default_timezone_set("Asia/Kolkata");
$date_time = date('Y-m-d H:i:s',time());



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
function auth(){
    return true;
}

// $BuildingNumber = $_POST['BuildingNo'];
if(auth()){
    $sql_query = "SELECT * FROM Building ";
    if($link=mysqli_connect($dbServername, $username, $password, $dbname)){
        $result1 = mysqli_query($link,$sql_query);
        if(mysqli_num_rows($result1) > 0){
            $buildingList = array();
            while($r = mysqli_fetch_array($result1, MYSQLI_ASSOC))
            {
                $buildingList[]  = $r;
            }
            respond(200,"The Building is fetched", $buildingList);
        }
        else{
            respond(401, "No Buildings Found");
        }
    }
    else{
        respond(500, "DB Error");
    }
}
else{
    respond(403, "Authentication Error");
}

echo json_encode($res);

//Returns FullName, Branch and a image url for the person.
?>


