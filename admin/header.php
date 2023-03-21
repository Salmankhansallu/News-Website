<?php
  include "config.php";
  session_start();
  ob_start();
  if(!isset($_SESSION["username"])){
    header("Location: {$hostname}");
  }
  // else{
  //   header("Location: {$hostname}/admin/post.php");
  // }
  //DYNAMICALLY TITLE

    $page = basename($_SERVER['PHP_SELF']);

    switch($page){
      case "post.php":
      if($_SESSION['user_role']=='1'){
        $admin_title="Admin Post";
      }else {
          $admin_title="User Post";
        }
        break;
      case "category.php":
        $admin_title="Admin Category";
        break;
      case "users.php":
      $admin_title="Admin User";
        break;
      case "settings.php":
      $admin_title="Admin Settings";
        break;
      default :
      $admin_title="Admin Panel";
        break;
    }
    //DYNAMICALLY TITLE END
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo $admin_title;?></title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <!-- Font Awesome Icon -->
        <link rel="stylesheet" href="../css/font-awesome.css">
        <!-- Custom stlylesheet -->
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <style>
   #header-admin .logo{
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
    #header-admin .logo{
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
  #header-admin .logo{
      margin-left:-30px;
      width: 250px;
}

}
@media(max-width:800px){
  #header-admin .logo{
      margin-left:0px;
      width: 220px;
}

}
@media(max-width:770px){
  #header-admin .logo{
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

    #header-admin .logo{
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

    #header-admin .logo{
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
    <body>
        <!-- HEADER -->
        <div id="header-admin">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- LOGO -->
                    <div class="col-md-2">
                      <a href="post.php"><img class="logo" src="../images/news.jpg"></a>
                    </div>

                    <!-- /LOGO -->
                      <!-- LOGO-Out -->
                    <div class="col-md-offset-6  col-md-4">
                        <a href="logout.php" class="admin-logout">Hello <?php echo $_SESSION["username"]; ?>, logout</a>
                    </div>
                    <!-- /LOGO-Out -->
                </div>
            </div>
        </div>
        <!-- /HEADER -->
        <!-- Menu Bar -->

        <div id="admin-menubar">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                       <ul class="admin-menu">
                            <li>
                                <a href="post.php">Post</a>
                            </li>
                           <li>
                                <a href="news/header2.php">Show News</a>
                            </li>
                            <?php
                              if($_SESSION["user_role"] == '1'){
                            ?>
                            <li>
                                <a href="category.php">Category</a>
                            </li>
                            <li>
                                <a href="users.php">Users</a>
                            </li>
                            <li>
                                <a href="settings.php">Settings</a>
                            </li>
                            <?php
                              }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Menu Bar -->
