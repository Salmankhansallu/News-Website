
<?php
  include "config.php";
  session_start();

  if(isset($_POST['submit'])){
  if(isset($_FILES['fileToUpload'])){
    $errors="";
    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];
    $file_type = $_FILES['fileToUpload']['type'];
    $file_extname = explode('.',$file_name);
    $file_ext=strtolower(end($file_extname));
    $extensions = array("jpeg","jpg","png");
    if(in_array($file_ext,$extensions) === false)
    {
      $errors="<div class='alert alert-danger'>This extension file not allowed, Please choose a JPG or PNG file...!</div>";
      // header("location: {$hostname}/admin/add-post.php");
      // $_SESSION["message"]="<div class='alert alert-danger'>This extension file not allowed, Please choose a JPG or PNG file...!</div>";
      // die();
      // $errors[]= "This extension file not allowed, Please choose a JPG or PNG file.";
    }
// (2097152  2mb file size) 1kb=1024byte and 1mb=1024kb or 1024*1024=1048576byte
    if($file_size >1048576){ //1mb size
      // header("location: {$hostname}/admin/add-post.php");
      // $_SESSION["message"]="<div class='alert alert-danger'>File size must be 2mb or lower...!</div>";
      // die();
       $errors= "<div class='alert alert-danger'>File size must be 1mb or lower...!</div>";
    }
    if($errors!=""){
      header("location: {$hostname}/admin/add-post.php");
      $_SESSION['message']=$errors;
      die();
    }
    else{
     $new_name = time()."-".basename($file_name);
     $target="upload/".$new_name;
     $image_name=$new_name;
    if(empty($errors) == true){
      move_uploaded_file($file_tmp,$target);
      $_SESSION['imageupload']=$new_name;
      // move_uploaded_file($file_tmp,"upload/".$file_name);
      // $_SESSION['imageupload']=$file_name;

    }else{
        $_SESSION["message"]="<div class='alert alert-danger'>Can't Uploaded File...!</div>";
        // echo '<script>alert("This extension file not allowed, Please choose a JPG or PNG file.")</script>';
        header("location: {$hostname}/admin/add-post.php");
        die();

    }
    // if(isset())


  session_start();
  $title = mysqli_real_escape_string($conn, $_POST['post_title']);
  $description = mysqli_real_escape_string($conn, $_POST['postdesc']);
  $category = mysqli_real_escape_string($conn, $_POST['category']);
  date_default_timezone_set("asia/kolkata");
  $date = date("d M, Y");
  $author = $_SESSION['user_id'];

  $sql = "INSERT INTO post(title, description,category,post_date,author,post_img)
          VALUES('{$title}','{$description}',{$category},'{$date}',{$author},'{$new_name}');";
  $sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$category}";

  if(mysqli_multi_query($conn, $sql)){
    $_SESSION["addpostmessage"]="<div class='alert alert-success'>Post add successfully...!</div>";
    header("location: {$hostname}/admin/post.php");
  }else{
    $_SESSION["message"]="<div class='alert alert-danger'>Query Failed.</div>";
    header("location: {$hostname}/admin/add-post.php");
  }
}
}
}
else{
   $_SESSION["message"]="<div class='alert alert-danger'>Something Wrong.</div>";
  header("location: {$hostname}/admin/add-post.php");
}
?>
