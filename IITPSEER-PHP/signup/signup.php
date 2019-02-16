<?php
    session_start();
    if(!isset($_SESSION['Username'])) {
        header("Location: /iitpseer/radmin/loginportal");
        exit;
        die();
    } 
    include 'dbConfig.php';
    include "phpqrcode/qrlib.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    //Load Composer's autoloader
    require 'vendor/autoload.php';

    error_reporting(0);
    $values = '';
    $_SESSION["message"] = "";


    foreach($_POST as $key=>$value){
        if($key != 'apiKey')
            $values .= "\t".$key."=".$value."\n";
    }

    function SQLInjFilter(&$unfilteredString){
        $unfilteredString = mb_convert_encoding($unfilteredString, 'UTF-8', 'UTF-8');
        $unfilteredString = htmlentities($unfilteredString, ENT_QUOTES, 'UTF-8');
        return $unfilteredString;
    }

    if($_POST["name"] == "" || !isset($_POST["name"]) || $_POST["roll"] == "" || !isset($_POST["roll"]) || $_POST["phone"] == "" || !isset($_POST["phone"])|| $_POST["email"] == "" || !isset($_POST["email"])|| $_POST["branch"] == "" || !isset($_POST["branch"])){
        ;
    } else{
        $link = mysqli_connect($dbServername, $username, $password, $dbname);
     
        if(!mysqli_connect_errno()){
            $name = $_POST["name"];
            $roll = $_POST["roll"];
            $phone = $_POST["phone"];
            $email = $_POST["email"];
            $branch = $_POST["branch"];       
            

            $sql = "INSERT INTO People VALUES ('".$roll."', '".$name."', '".$branch."', '".$phone."','".$email."' )";
            $sql1 = mysqli_query($link, $sql);

            $sql3 = "SELECT * FROM People WHERE ID = '".$roll."'";
            $sql4 = mysqli_query($link, $sql3);
 
            $num = mysqli_num_rows($sql4);
            // echo $num;

            $currentDir = getcwd();
            // $uploadDirectory = "/uploads/";

            $errors = []; // Store all foreseen and unforseen errors here

            $fileExtensions = ['jpeg','jpg','png']; // Get all the file extensions

            $fileName = $_FILES['profile']['name'];
            $fileSize = $_FILES['profile']['size'];
            $fileTmpName  = $_FILES['profile']['tmp_name'];
            $fileType = $_FILES['profile']['type'];
            $fileExtension = strtolower(end(explode('.',$fileName)));

            $uploadPath = $currentDir."/../People/images/" . basename($roll).".".$fileExtension; 

            if (isset($_POST['submit'])) {

                // if (! in_array($fileExtension,$fileExtensions)) {
                //     $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
                // }

                // if ($fileSize > 2000000) {
                //     $errors[] = "This file is more than 2MB. Sorry, it has to be less than or equal to 2MB";
                // }

                if (empty($errors)) {
                    $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

                    if (!$didUpload) {
                        echo "An error occurred somewhere. Try again or contact the admin";
                        print_r($didUpload);
                    }
                } else {
                    foreach ($errors as $error) {
                        echo $error . "These are the errors" . "\n";
                    }
                }
            }

        
            if(mysqli_num_rows($sql4) != 1)
                $_SESSION["message"] = "Somthing went Wrong :(";
        
            else {
                $_SESSION["message"] = "SignUp Successful :)";
                $hash = sha1("IITPseerSecReTKey".$roll.$name);
                QRcode::png("{\"name\":\"".$name."\",\"roll\":\"".$roll."\",\"token\":\"".$hash."\"}", $roll.".png", "H", 4, 4);
                rename($roll.'.png', 'qrimages/'.$roll.'.png');

     


                $mail = new PHPMailer(true);             
                try {
                    //Server settings
  
                    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                    $mail->Username = 'iitpseer@gmail.com';            // SMTP username
                    $mail->Password = 'root@1234';                  // SMTP password
                    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 587; 

                    //Recipients
                    $mail->setFrom('iitpseer@gmail.com', 'IITPSEER');
                    $mail->addAddress($email, $name);     // Add a recipient
                    // $mail->addAddress('ellen@example.com');               // Name is optional
                    // $mail->addReplyTo('info@example.com', 'Information');
                    // $mail->addCC('cc@example.com');
                    // $mail->addBCC('bcc@example.com');
                
                    //Attachments
                    $mail->addAttachment('./qrimages/'.$roll.'.png');         // Add attachments
                    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
                
                    //Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'IITPSEER QRCODE';
                    $mail->Body    = 'PFA';
                    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                
                    if($mail->send())
                    {
                        echo 'yes';
                    }
                } catch (Exception $e) {
                    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                }
                header("Location: /iitpseer/radmin");
                exit;
                die();            }
        }
        else
            echo "Error connecting to database";
    }
    ?>