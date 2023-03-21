<?php

session_start();
include "config.php";
if(empty($_FILES['logo']['name'])){
  $file_name = $_POST['old_logo'];
}else{
  $errors = "";

  $file_name = $_FILES['logo']['name'];
  $file_size = $_FILES['logo']['size'];
  $file_tmp = $_FILES['logo']['tmp_name'];
  $file_type = $_FILES['logo']['type'];
  $exp = explode('.',$file_name);
 $file_ext = end($exp);

  $extensions = array("jpeg","jpg","png");

  if(in_array($file_ext,$extensions) === false)
  {
    $errors="<div class='alert alert-danger'>This extension file not allowed, Please choose a JPG or PNG file.</div>";
  }

  if($file_size > 103424){
    $errors="<div class='alert alert-danger'>File size must be 100kb or lower.</div>";
  }

  if($errors==""){
    move_uploaded_file($file_tmp,"images/".$file_name);

  }else{
    header("location: {$hostname}/admin/settings.php");
    $_SESSION['settingmessage'] =$errors;
    // print_r($errors);
    die();
  }
}
$sql = "UPDATE settings SET websitename='{$_POST["website_name"]}',logo='{$file_name}',footerdesc='{$_POST["footer_desc"]}'";

$result = mysqli_query($conn,$sql);

if($result){
  header("location: {$hostname}/admin/settings.php");
  $_SESSION['settingmessage']="<div class='alert alert-success'>Website Setting Update Successfully...!</div>";
}else{
  echo "Query Failed";
}

?>
