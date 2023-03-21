<?php

  include "config.php";
  session_start();
  if(!isset($_SESSION["username"])){
    header("Location: {$hostname}");
  }
  $page = basename($_SERVER['PHP_SELF']);
  switch($page){
    case "single.php":
      if(isset($_GET['id'])){
        $sql_title = "SELECT * FROM post WHERE post_id = {$_GET['id']}";
        $result_title = mysqli_query($conn,$sql_title) or die("Title Query Failed");
        $row_title = mysqli_fetch_assoc($result_title);
        $page_title = $row_title['title'];
      }else{
        $page_title = "No Post Found";
      }
      break;
    case "category.php":
      if(isset($_GET['cid'])){
        $sql_title = "SELECT * FROM category WHERE category_id = {$_GET['cid']}";
        $result_title = mysqli_query($conn,$sql_title) or die("Title Query Failed");
        $row_title = mysqli_fetch_assoc($result_title);
        $page_title = $row_title['category_name'] . " News";
      }else{
        $page_title = "No Post Found";
      }
      break;
    case "author.php":
      if(isset($_GET['aid'])){
        $sql_title = "SELECT * FROM user WHERE user_id = {$_GET['aid']}";
        $result_title = mysqli_query($conn,$sql_title) or die("Title Query Failed");
        $row_title = mysqli_fetch_assoc($result_title);
        $page_title = "News By " .$row_title['first_name'] . " " . $row_title['last_name'];
      }else{
        $page_title = "No Post Found";
      }
      break;
    case "search.php":
      if(isset($_GET['search'])){

        $page_title = $_GET['search'];
      }else{
        $page_title = "No Search Result Found";
      }
      break;
    default :
      $sql_title = "SELECT websitename FROM settings";
      $result_title = mysqli_query($conn,$sql_title) or die("Title Query Failed");
      $row_title = mysqli_fetch_assoc($result_title);
      $page_title = $row_title['websitename'];
      break;
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $page_title; ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="../../css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="../../css/style.css">
    <style>
   #header-admin #logo{
     width:300px;

     margin-left: 0px;
   }
  #header-admin .admin-logout{
  font-size: 20px;
  margin-right:-10px;
  }
  @media(max-width:998px){
  #header-admin{
  display: flex;
  }
    #header-admin #logo{
      margin-left:-70px;
      width: 250px;


    }
    #header-admin .admin-logout{
    font-size: 18px;
    float: right;
    position: relative;
    top: -60px;

    }

  }
  @media(max-width:890px){
  #header-admin #logo{
      margin-left:-30px;
      width: 250px;
  }

  }
  @media(max-width:800px){
  #header-admin #logo{
      margin-left:0px;
      width: 220px;
  }

  }
  @media(max-width:770px){
  #header-admin #logo{
      margin-left:0px;
      width: 300px;
  }
  #header-admin .admin-logout{
  font-size: 20px;
  float: right;
  position: relative;
  margin-right: 50px;
  top: 10px;

  }

  }
  @media(max-width:500px){

    #header-admin #logo{
      margin-left: 10px;

    }
    #header-admin .admin-logout{
    font-size: 15px;
    margin-left: 45px;
  }

    #header-admin {
      width: 100%;
    }
    #admin-menubar{
      margin-left: -7px;
      width: 101%;
    }
      #admin-menubar .admin-menu li a{
        font-size: 10px;
        margin-left: -10px;
      }

  }

  @media(max-width:360px){

    #header-admin #logo{
      margin-left: 35px;
      width: 240px;

    }
    #header-admin {
      width: 100%;
    }
    #admin-menubar{

      width: 102%;
    }
      #admin-menubar .admin-menu li a{
        font-size: 10px;
        margin-left: 6px;
      }
  }



    </style>
</head>
<body>
<!-- HEADER -->
<div id="header-admin">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- LOGO -->
            <div class="col-md-2">
              <?php
                include "config.php";

                $sql = "SELECT * FROM settings";

                $result = mysqli_query($conn, $sql) or die("Query Failed.");
                if(mysqli_num_rows($result) > 0){
                  while($row = mysqli_fetch_assoc($result)) {
                    if($row['logo'] == ""){
                      echo '<a href="../index.php" id="logo"><h1 >'.$row['websitename'].'</h1></a>';
                    }else{
                      echo '<a href="../../index.php" id="logo"><img src="../images/'. $row['logo'] .'"></a>';
                    }

                  }
                }
                ?>

            </div>
            <!-- /LOGO -->
              <!-- LOGO-Out -->
            <div class="col-md-offset-6  col-md-4">
                <a href="../logout.php" class="admin-logout">Hello <?php echo $_SESSION["username"]; ?>, logout</a>
            </div>
            <!-- /LOGO-Out -->
            <!-- /LOGO -->

        </div>
    </div>
</div>
<!-- /HEADER -->
<!-- Menu Bar -->
<div id="menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
              <?php
                include "config.php";

                if(isset($_GET['cid'])){
                  $cat_id = $_GET['cid'];
                }

                $sql = "SELECT * FROM category WHERE post > 0";
                $result = mysqli_query($conn, $sql) or die("Query Failed. : Category");
                if(mysqli_num_rows($result) > 0){
                  $active = "";
              ?>
                <ul class='menu'>
                  <li><a href='<?php echo $hostname; ?>'>Home</a></li>
                  <?php while($row = mysqli_fetch_assoc($result)) {
                    if(isset($_GET['cid'])){
                      if($row['category_id'] == $cat_id){
                        $active = "active";
                      }else{
                        $active = "";
                      }
                    }
                    echo "<li><a class='{$active}' href='category.php?cid={$row['category_id']}'>{$row['category_name']}</a></li>";
                  } ?>
                </ul>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- /Menu Bar -->
