<?php
include "header.php";
  include "config.php";
  session_start();
  //user login or not
  if(isset($_SESSION["username"])){
    header("Location: {$hostname}/admin/post.php");
  }
 // Registered  message
  if(isset($_SESSION["registeredmessage"])){
    echo $_SESSION["registeredmessage"];
    unset($_SESSION["registeredmessage"]);

  }
  // Updation message
if(isset($_SESSION['update'])){
  echo $_SESSION['update'];
  unset($_SESSION['update']);

}
// Login Detail Wrong Message
if(isset($_SESSION['logindetailwrong'])){
  echo $_SESSION['logindetailwrong'];
  unset($_SESSION['logindetailwrong']);
}
?>

<!doctype html>
<html>
   <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>ADMIN | Login</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/font-awesome.css">
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <div id="wrapper-admin" class="body-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">

                        <h3 class="heading">Admin</h3>
                        <!-- Form Start -->
                        <form   action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="" required>
                            </div>
                            <input type="submit" name="login" class="btn btn-primary" value="Login" /><br>
                            <label class="reg">Don't have an account? <a href="add-user.php">Register,</a></label>
                            <label class="reg2"><a href="forget.php">Forget Password</a></label>
                        </form>
                        <!-- /Form  End -->
                        <?php
                          if(isset($_POST['login'])){
                            include "config.php";
                            if(empty($_POST['username']) || empty($_POST['password'])){
                              echo '<div class="alert alert-danger">All Fields must be entered.</div>';
                              die();
                            }else{
                              $username = mysqli_real_escape_string($conn, $_POST['username']);
                              $password = md5($_POST['password']);

                              $sql = "SELECT user_id, username, role FROM user WHERE username = '{$username}' AND password= '{$password}'";

                              $result = mysqli_query($conn, $sql) or die("Query Failed.");

                              if(mysqli_num_rows($result) > 0){

                                while($row = mysqli_fetch_assoc($result)){
                                  session_start();
                                  $_SESSION["username"] = $row['username'];
                                  $_SESSION["user_id"] = $row['user_id'];
                                  $_SESSION["user_role"] = $row['role'];

                                  header("Location: {$hostname}/admin/post.php");
                                }

                              }else{
                              // echo '<div class="alert alert-danger">Username and Password are not matched.</div>';
                              $_SESSION['logindetailwrong']='<div class="alert alert-danger">Username or Password are not matched.</div>';
                              header("location:{$hostname}/index.php");
                            }
                          }
                          }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
