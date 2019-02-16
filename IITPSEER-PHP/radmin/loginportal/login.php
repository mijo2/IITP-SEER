<?php
    session_start();
    include 'dbConfig.php';
    error_reporting(0);
    $values = '';   

    foreach($_POST as $key=>$value){
        if($key != 'apiKey')
            $values .= "\t".$key."=".$value."\n";
    }

    function SQLInjFilter(&$unfilteredString){
        $unfilteredString = mb_convert_encoding($unfilteredString, 'UTF-8', 'UTF-8');
        $unfilteredString = htmlentities($unfilteredString, ENT_QUOTES, 'UTF-8');
        return $unfilteredString;
    }

    if($_POST["Username"] == "" || !isset($_POST["Username"]) || $_POST["Password"] == "" || !isset($_POST["Password"])){
        ;
    } else{
        $link = mysqli_connect($dbServername, $username, $password, $dbname);
     
        if(!mysqli_connect_errno()){
            $name = $_POST["Username"];
            $password = $_POST["Password"];
            $sql = "SELECT adminID, paswd FROM Admin WHERE adminID = '".$name."'";
            $sql1 = mysqli_query($link, $sql);
        
            if(mysqli_num_rows($sql1) < 1){
                $_SESSION["message"] = "User not Found :(";
                $_SESSION['loggedin'] = False;
                session_regenerate_id(true);
                header('Location: /iitpseer/radmin/loginportal');
                exit;                
            }
        
            else {
                $sql2 = mysqli_fetch_assoc($sql1);
                $sqlname = $sql2["adminID"];
                //if($sql2["adminID"] == $name){
                    if($sql2["paswd"] == sha1($password)){
                        $_SESSION["Username"] = $sqlname;
                        $_SESSION["message"] = "Login Successful";
                        $_SESSION['loggedin'] = true;
                        session_regenerate_id(true);
                        header('Location: /iitpseer/radmin');
                        exit;
                    }
                    else{                       
                        $_SESSION["message"] = "Wrong Password";
                        $_SESSION['loggedin'] = False;
                        session_regenerate_id(true);
                        header('Location: /iitpseer/radmin/loginportal');
                        exit;
                    }
                    echo $_SESSION["message"];   
    
            }
    
        }
        else
            echo "Error connecting to database";
    }
    ?>