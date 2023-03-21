<?php
include "config.php";
 session_start();
if($_SESSION["user_role"] == '0'){
  header("Location: {$hostname}/admin/post.php");
}
$useridandpage = $_GET['id'];
$userid_page=explode('.',$useridandpage);
$page=end($userid_page);
$user_id=$userid_page[0];

$sql = "DELETE FROM user WHERE user_id = {$user_id}";

if(mysqli_query($conn, $sql)){
    $_SESSION['deleteuser']='<div class="alert alert-success">Delete User Successfully...!</div>';
  header("Location: {$hostname}/admin/users.php?page=$page");
}else{
  $_SESSION['deleteuser']='<div class="alert alert-success">Can\'t Delete the User Record...!</div>';
   header("Location: {$hostname}/admin/users.php");
   // echo "<p style='color:red;margin: 10px 0;'>Can't Delete the User Record.</p>";
}

mysqli_close($conn);

?>
