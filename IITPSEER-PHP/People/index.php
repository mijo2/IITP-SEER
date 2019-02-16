<?php 
      session_start();
      include "searchbar/index.html";
      include "../radmin/drop-down-menu/index.php"; 
      ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../radmin/drop-down-menu/css/style.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="searchbar/css/style.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../radmin/css/style.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    <script src="main.js"></script>
    <style> 
    section{
        position: relative;
        margin-top: 150px;
    }   
    h1{
      top: -225px;
      right: 270px;    
      position: absolute;
      font-size: 15px;
      font-family: Arial, Helvetica, sans-serif;
      color: red;
    } 
    #section1{

    }
    </style>

</head>
<body>
    <form class="searchform cf"  method="POST" action="index.php">
    <input type="text" placeholder="Search for ID.." name="search">
    <button type="submit">Search</button>
    </form> 

    <section>
    <?php if(!isset($_POST['search'])) { ?>
        <h1 id="#section1"></h1>
    <?php } else {?>
    </section>
    <?php 
        $link=mysqli_connect($dbServername, $username, $password, $dbname);
        $id = $_POST['search'];
        $sql = "SELECT * from People WHERE ID='".$id."'";
        $result = mysqli_query($link,$sql); $num = mysqli_num_rows($result);
        if($num == 1){
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);        
    ?> <br><br><br><br>
        <img src="images/<?php echo $row['ID'];?>.jpg" alt="Image Not Found"
    style = "width:250px; height:220px; display:block; margin-left:auto; margin-right:auto; margin-top: 2em;"> 
    <br><br><br>
    <div class="tbl-header">
        <table cellpadding="0" cellspacing="0" border="0">
          <thead>
            <tr>
              <th>ID</th>
              <th>FullName</th>
              <th>Branch</th>
              <th>PhoneNo</th>
              <th>Email</th>
            </tr>
          </thead>
        </table> 
      </div>
    <div class="tbl-content">
    <table cellpadding="0" cellspacing="0" border="0">
      <tbody>   
          <tr>
            <td><?php echo $row['ID'];?></td>
            <td><?php echo $row['FullName'];?></td>
            <td><?php echo $row['Branch'];?></td>
            <td><?php echo $row['PhoneNo'];?></td>
            <td><?php echo $row['Email'];?></td>
          </tr>
      </tbody>
    </table>
    </div> 
      <?php } else{  //For if statement ?>

    <?php  ?>
    <section>
        <h1 id="#section1"> Wrong ID </h1>
    </section>
    <?php } ?>
    
    <?php } //For else statement?>
</body>
</html>