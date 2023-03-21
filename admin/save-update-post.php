<?php
include "config.php";
session_start();
$postid=$_POST["post_id"];
$pages=$_SESSION['page'];
// echo $pages;
if(empty($_FILES['new-image']['name'])){
  $new_name = $_POST['old_image'];
}else{
  $errors = "";

  $file_name = $_FILES['new-image']['name'];
  $file_size = $_FILES['new-image']['size'];
  $file_tmp = $_FILES['new-image']['tmp_name'];
  $file_type = $_FILES['new-image']['type'];
  $file_extention = (explode('.',$file_name));
  $file_ext=end($file_extention);
  $extensions = array("jpeg","jpg","png");

  if(in_array($file_ext,$extensions) === false)
  {
  $errors="<div class='alert alert-danger'>This extension file not allowed, Please choose a JPG or PNG file...!</div>";
  }

  if($file_size > 103424){
    $errors= "<div class='alert alert-danger'>File size must be 100kb or lower...!</div>";
  }
   if($errors!=""){
     $_SESSION['errormessage']=$errors;
     header("location: {$hostname}/admin/update-post.php?id=$postid&page=$pages");
     die();
   }

   $new_name = time()."-".basename($file_name);
   $target="upload/".$new_name;
   $image_name=$new_name;

  if(empty($errors) == true){
    move_uploaded_file($file_tmp,$target);
  }else{
    print_r($errors);
    die();
  }
}
// session_start();
 $sql = "UPDATE post SET title='{$_POST["post_title"]}',description='{$_POST["postdesc"]}',category={$_POST["category"]},post_img='{$new_name}'
        WHERE post_id={$_POST["post_id"]};";

if($_POST['old_category'] != $_POST["category"] ){
  $sql .= "UPDATE category SET post= post - 1 WHERE category_id = {$_POST['old_category']};";
  $sql .= "UPDATE category SET post= post + 1 WHERE category_id = {$_POST["category"]};";
}

$result = mysqli_multi_query($conn,$sql);
 // $result = mysqli_query($conn,$sql);

if($result){
  header("location: {$hostname}/admin/post.php?id=$postid&page=$pages");
   $_SESSION['updatepostmessage']="<div class='alert alert-success'>Post Updated Successfully...!</div>";
}else{
  header("location: {$hostname}/admin/update-post.php?id=$postid&page=$pages");
   $_SESSION['updatepostmessage']="<div class='alert alert-danger'>Something Wrong...!</div>";
  // echo "Query Failed ho gyi he g";
}
?>
