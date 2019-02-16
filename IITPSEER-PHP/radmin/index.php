<?php 
      session_start();
      if(!isset($_SESSION['Username'])) {
          header("Location: /iitpseer/radmin/loginportal");
          exit;
          die();
      } 
      include "drop-down-menu/index.php";
      include "backend.php";
      ?>
<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
      <title>IITP-SEER</title>
  
    <link rel="stylesheet" href="drop-down-menu/css/style.css">
    <!--<link rel="stylesheet" href="header/css/style.css"> -->
    <link rel="stylesheet" href="searchbar/css/style.css"> 
    <link rel="stylesheet" href="css/style.css">
  
</head>

<body>

<!--
  <header>
    <div class="container">
      <span id="home"><span class="ion-camera"></span></span>
      <div class="box">
        <ul>
          <li><a href="#" id="ahover">portfolio</a></li>
          <li><a href="#" id="ahover">Blog</a></li>
          <li><a href="#" id="ahover">Services</a></li>
          <li><a href="#" id="ahover">Contact</a></li>
        </ul>
      </div>
      <span id="menu"><span class="ion-navicon-round"></span></span>
    </div>
  </header>   -->

  <form class="searchform cf"  method="POST">
    <input type="text" placeholder="Search for Username or ID.." name="search">
    <button type="submit">Search</button>
  </form> 

  <section>
  <h1>IIT Patna Register</h1>
  <?php while($i < $num){ ?>
      <?php       
            $sql = "SELECT * from Register WHERE";
            if(isset($_GET['bid']))
              $sql .= " BuildingNo = ".$_GET['bid']." AND";
            else 
              $sql .= " 1 AND";
            if(isset($_POST['search']))
              $sql .= " (FullName like '%".$_POST['search']."%' OR ID like '%".$_POST['search']."%')";
            else 
              $sql .= " 1";
            $sql .= " ORDER BY EntryID DESC LIMIT ".$i.",1";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC); 
            if(strcmp($row['EntryTime'], $row['ExitTime']) > 0)
              $max_d = substr($row['EntryTime'], 0, 10);
            else
              $max_d = substr($row['ExitTime'], 0, 10);
            if($curr_date == null || $curr_date != $max_d){
              $curr_date = $max_d;
              ?> 
      <h1> <?php echo date($max_d); ?> </h1>   
      <div class="tbl-header">
        <table cellpadding="0" cellspacing="0" border="0">
          <thead>
            <tr>
              <th>ID</th>
              <th>FullName</th>
              <th>BuildingNo</th>
              <th>EntryTime</th>
              <th>ExitTime</th>
            </tr>
          </thead>
        </table> 
      </div>   <?php } ?>
    <div class="tbl-content">
    <table cellpadding="0" cellspacing="0" border="0">
      <tbody>   
          <tr>
            <td><?php echo $row['ID'];?></td>
            <td><?php echo $row['FullName'];?></td>
            <td><?php echo $row['BuildingNo'];?></td>
            <td><?php echo $row['EntryTime'];?></td>
            <td><?php echo $row['ExitTime'];?></td>
          </tr>
      </tbody>
    </table>
    </div>
    <?php $i = $i + 1; } ?>
</section>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

  

    <script  src="js/index.js"></script>




</body>

</html>
