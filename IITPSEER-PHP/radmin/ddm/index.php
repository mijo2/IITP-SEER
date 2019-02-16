<?php include "../drop-down-menu/index.php"?>
<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="UTF-8">
    <title>Drop-Down Menu</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <style>        
        #header1,
        .container,
        .box {
            margin: 0;
            overflow: hidden;
            padding: 0;
            position: relative;
        }
        #ul1, #li1{
            list-style-type: none;
            margin: 0 auto;
            padding: 0;
            display: inline-block;
            font-size: 19px;
            font-weight: bold;
        }
        #header1{
            background: #FFF;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.35);
            height: 60px;
            left: 0;
            position: fixed;
            right: 0;
            top: 0;
            width: initial;
            z-index: 9;
            -webkit-transform: matrix(1, 0, 0, 1, 0, 0);
            -moz-transform: matrix(1, 0, 0, 1, 0, 0);
            transform: matrix(1, 0, 0, 1, 0, 0);
            -webkit-transition: all .5s ease-in-out;
            -moz-transition: all .5s ease-in-out;
            transition: all .5s ease-in-out;
        }
        html.active #header1 {
        -webkit-transform: matrix(1, 0, 0, 1, -320, 0);
        -moz-transform: matrix(1, 0, 0, 1, -320, 0);
        transform: matrix(1, 0, 0, 1, -320, 0);
        -webkit-transition: all .5s ease-in-out;
        -moz-transition: all .5s ease-in-out;
        transition: all .5s ease-in-out;
        } 

        #header1 .box {
        height: 40px;
        line-height: 40px;
        margin: 0 80px;
        padding: 10px;
        } 

        #header1 .box > ul {
        display: flex;
        }

        #header1 .box > ul li {
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
        }
        #a1{
            text-decoration: none;
            margin: 0 auto;
            padding: 0;
            font-size: 20px;
            font-weight: bold;
            color: #444;
        }
        #a1:hover {
            color: #FF5959;
        }


    </style>

</head>

<body>

<header id="header1">
  <div class="container">
    <span id="home"><span class="ion-camera"></span></span>
    <div class="box">
      <ul id="ul1">
        <li id="li1"><a href="#" id="a1">portfolio</a></li>
        <li id="li1"><a href="#" id="a1">Blog</a></li>
        <li id="li1"><a href="#" id="a1">Services</a></li>
        <li id="li1"><a href="#" id="a1">Contact</a></li>
      </ul>
    </div>
  </div>
</header>

<ul>
  <li id="#li2"><a href="#" class="item">Size <i class="fa fa-chevron-down"></i></a>
    <span class="accent"></span>
    <ul class="drop-down">
      <li><a href="#" id="a2">Small</a></li>
      <li><a href="#" id="a2">Medium</a></li>
      <li><a href="#" id="a2">Large</a></li>
      <li><a href="#" id="a2">Extra Large</a></li>
    </ul> 
  </li>
</ul>

</body>
</html>