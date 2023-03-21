
<?php

  include "config.php";
  $post_id = $_GET['id'];
  $cat_id = $_GET['catid'];
  $pages=$_GET['page'];
  $sql1 = "SELECT * FROM post WHERE post_id = {$post_id}";
  $result = mysqli_query($conn, $sql1) or die("Query Failed : Select");
  $row = mysqli_fetch_assoc($result);

  unlink("upload/".$row['post_img']);

  $sql = "DELETE FROM post WHERE post_id = {$post_id};";
  $sql .= "UPDATE category SET post= post - 1 WHERE category_id = {$cat_id}";

  if(mysqli_multi_query($conn, $sql)){
    session_start();
    $_SESSION['daletepostmessage']='<div class="alert alert-success">Post Delete successfully...!</div>';
    header("location: {$hostname}/admin/post.php?page=$pages");


  }else{
    echo "Query Failed";
  }
?>
