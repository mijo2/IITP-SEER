<?php
    include "dbConfig.php";
    $i = 0;
    $link=mysqli_connect($dbServername, $username, $password, $dbname);
    if(mysqli_connect_errno())
        echo "No connection to database";
    else{
        $sql = "SELECT * from Register WHERE";
        if(isset($_GET['bid']))
            $sql .= " BuildingNo = ".$_GET['bid']." AND";
        else 
            $sql .= " 1 AND";
        if(isset($_POST['search']))
            $sql .= " (FullName like '%".$_POST['search']."%' OR ID like '%".$_POST['search']."%')";
        else 
            $sql .= " 1";
        $sql .= " ORDER BY EntryID DESC";
        $result = mysqli_query($link, $sql);
        $num = mysqli_num_rows($result);
        $i = 0; $curr_date = null; $max_d = "";

    }