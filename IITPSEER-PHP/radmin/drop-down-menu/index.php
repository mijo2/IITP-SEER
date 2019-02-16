<?php include "dbConfig.php"; ?>
<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
 
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  
      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>

  <nav role="navigation">
 
<?php 
  $link=mysqli_connect($dbServername, $username, $password, $dbname);
  if(mysqli_connect_errno()){
    echo "No connection to database";
  }
  else {
    $sql = "SELECT 'name' FROM Building";
    $result = mysqli_query($link, $sql);
    $num = mysqli_num_rows($result);   
    $i = 0;
?>
<ul class="nav">
  <li><a href="http://localhost/iitpseer/radmin/">Home</a></li>
  <li><a href="" class="has-submenu">Buildings</a>
    <ul class="submenu">
        <?php while($i < $num){ 
          $sql = "SELECT name from Building LIMIT ".$i.",1";
          $result = mysqli_query($link, $sql);
          $row = mysqli_fetch_array($result, MYSQLI_ASSOC); 
          ?>
        <li><a href="http://localhost/iitpseer/radmin?bid=<?php echo $i + 1; ?>"> <?php echo $row['name']; ?> </a></li>
        <?php $i += 1; } ?>
    </ul>
  </li>  
  <li><a href="../../iitpseer/People">People</a></li>
  <li><a href="../signup">Signup Portal</a></li>
</ul>
  
</nav>
  
<?php } ?>

</body>

</html>
