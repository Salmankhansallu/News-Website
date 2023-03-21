<?php
include 'header.php';
include 'config.php';
session_start();
// Wrongusername
if(isset($_SESSION["wrongusername"])){
  echo $_SESSION["wrongusername"];
  unset($_SESSION["wrongusername"]);

}
 ?>

<!doctype html>
<html>
<head>
  <link  rel="stylesheet" href="style.css">
</head>

<body>
<form id="forgetpassword" action="<?php $_SERVER['PHP_SELF']?>" method="POST">
  <div class="form-group">
      <label>Username</label>
      <input type="text" name="username" class="form-control" placeholder="" required>
  </div>
 <!-- <div class="form-group">
      <label>Email</label>
      <input type="text" name="email" class="form-control" placeholder="" required>

  </div> -->
      <input type="submit" name="login" class="btn btn-primary" value="Submit" />
    <label>  <a href="index.php" style="margin-left:50px;">Back</a></label>
</form>
<?php

if(isset($_POST['login'])){
//  $conn=mysqli_connect("localhost","root","","student")or die("Connection failed : " . mysqli_connect_error());
  $name=$_POST['username'];
  // $email=$_POST['email'];

  $sql="SELECT username FROM user WHERE username='{$name}'";
  $result=mysqli_query($conn,$sql) or die("Query is Failed.");


  if(mysqli_num_rows($result) > 0){

    while($row=mysqli_fetch_assoc($result)) {
   $_SESSION['use']=$row['username'];

 header("Location: {$hostname}/update-user.php");
}
  }

  else{
    $_POST['username']="";
  //  $_POST['email']="";
    // echo '<div class="alert alert-danger" style="position:absolute;top:450px; color:red;">Username  is Incorrect...!.</div>';
    $_SESSION['wrongusername']= '<div class="alert alert-danger">Username  is Incorrect...!.</div>';
    header("Location: {$hostname}/forget.php");
  }
}


 ?>
</body>
</html>
