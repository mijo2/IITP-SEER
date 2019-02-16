<?php 

//The request to the server should be through POST method and following 
//values are expected:
//1.$_POST['userid']: ID from poeple database.
//2.$_POST['buildno']: Number of the building.
//3.$_POST['FullName']: Name of the person.

include 'dbConfig.php';
$url = $_SERVER['REQUEST_URI'];
ini_set('log_errors', 1);
ini_set('error_log', 'qr.log');
error_log( $url.'\n\t'.json_encode($_POST) );
header('Content-Type: application/json');

$res = ['status' => 400,'message'=>'Invalid parameters', 'data'=>null];

date_default_timezone_set('Asia/Kolkata');
// $date = date('Y-m-d',time());
$time = date('Y-m-d H:i:s', time());
// $id = $_POST['ID'];
$bno = $_POST['BuildingNo'];
// $name = $_POST['FullName'];


$msg = $_POST["message"];
$decoded_msg = json_decode($msg, false);
$id = $decoded_msg->roll;
$token = $decoded_msg->token;
$name = $decoded_msg->name;

function validate($id){
    for($i = 0; $i <= 7; $i++){
        if($i == 4 || $i == 5){
            if(!preg_match('/^[A-Z]$/', $id[$i])){
                return false;
            }
        }
        else{
            if(!preg_match('/^[0-9]$/', $id[$i])){
                return false;            
            }
        }
    }
    return true;
}

// creates response and outputs as JSON. 
function respond($statusCode, $message, $object = []){
    $res['status'] = $statusCode;
    http_response_code($statusCode);
    $res['message'] = $message;
    $res['data'] = $object;
    echo json_encode($res);
    exit(1);
}

function auth($id1, $name_local, $token_local){
    if($_POST['APIKey'] == "7ec992283ee0ce3b8df55159cec4fd37a6bd31ab")
    {   
        $hash = sha1("IITPseerSecReTKey".$id1.$name_local);
        if($hash == $token_local)
            return true;
        else
            return false;
    }
    else
        return false;
}

if(validate($id) && auth($id, $name, $token)){
    $link = mysqli_connect($dbServername, $username, $password, $dbname);
    if(!mysqli_connect_errno()){
        $resq1 = mysqli_query($link, "SELECT * from Register WHERE BuildingNo = '$bno' AND EntryTime = '0000-00-00 00:00:00' AND ID = '$id' AND NOT ExitTime = '0000-00-00 00:00:00' ORDER BY ExitTime DESC");
        if(mysqli_num_rows($resq1) > 0){
            // $resq2 = null;
            while($row1 = mysqli_fetch_array($resq1, MYSQLI_ASSOC)){
                $exitt = $row1['ExitTime'];
                mysqli_query($link, "UPDATE Register SET EntryTime = '$time' WHERE BuildingNo = '$bno' AND ID = '$id' AND ExitTime = '$exitt'");
            }
        }    
        else{
            $null = null;
            mysqli_query( $link, "INSERT INTO Register(ID, FullName, BuildingNo, EntryTime, ExitTime) VALUES('$id', '$name', '$bno', '$time', '$null')");
        }
        respond(200, 'Register Updated');
    }
    else{
        respond(500,'DB error'.mysql_error($link));
    }
} 

// respond(200,"ID: ".$id." BuildingNo: ".$bno." FullName: ".$name);
echo json_encode($res);


//SQL QUERY PART 
//Task is to add to the Register an entry for a person in the building if he/she
//is entering for the first time today or complete the entry exit pair if they 
//have exited it before and entering it now. In the database, I am making a Null
//value for exit attribute if the person is entering for the first time otherwise
//I am filling the Null value if the person exited first.
//Queries are as follows:
//SELECT * from Register WHERE Tdate = $date and BuildingNo = $bno and PeopleID = $id;
//For each row, check if there is a Null value for Entry Timestamp(bottom to top)
//If there is, update the entry timestamp of that row
//Else, add a new Register entry with Exit Time stamp Nulll for now.

?> 