<?php include "header.php";
$useridandpage = $_GET['id'];
$userid_page=explode('.',$useridandpage);
$page=end($userid_page);
$userid=$userid_page[0];
if($_SESSION["user_role"] == '0'){
  header("Location: {$hostname}/admin/post.php");
}
if(isset($_POST['submit'])){
  include "config.php";

  $userid =mysqli_real_escape_string($conn,$_POST['user_id']);
  $fname =mysqli_real_escape_string($conn,$_POST['f_name']);
  $lname = mysqli_real_escape_string($conn,$_POST['l_name']);
  $user = mysqli_real_escape_string($conn,$_POST['username']);
  $role = mysqli_real_escape_string($conn,$_POST['role']);

  $sql = "UPDATE user SET first_name = '{$fname}', last_name = '{$lname}', username = '{$user}', role = '{$role}' WHERE user_id = {$userid}";

    if(mysqli_query($conn,$sql)){
      $_SESSION['updateusermessage']='<div class="alert alert-success">User Detail Update Successfully...!</div>';
      header("Location: {$hostname}/admin/users.php?page=$page");
    }
}
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Modify User Details</h1>
              </div>
              <div class="col-md-offset-4 col-md-4">
                <?php
                include "config.php";
                $user_id = $userid;
                $sql = "SELECT * FROM user WHERE user_id = {$user_id}";
                $result = mysqli_query($conn, $sql) or die("Query Failed.");
                if(mysqli_num_rows($result) > 0){
                  while($row = mysqli_fetch_assoc($result)){
                ?>
                  <!-- Form Start -->
                  <form  action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="user_id" class="form-control" value="<?php echo $row['user_id'];  ?>">
                      </div>
                          <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name'];  ?>" required>
                      </div>
                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name'];  ?>" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="username" class="form-control" value="<?php echo $row['username'];  ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" value="<?php echo $row['username']; ?>">
                            <?php
                              if($row['role'] == 1){
                                echo "<option value='0'>Normal User</option>
                                      <option value='1' selected>Admin</option>
                                      <option value='2'>Student</option>
                                      <option value='3'>Other</option>";
                              }else if($row['role']==0){
                                echo "<option value='0' selected>Normal User</option>

                                      <option value='2'>Student</option>
                                      <option value='3'>Other</option>";
                              }
                              else if($row['role']==2){
                                echo "<option value='0'>Normal User</option>

                                      <option value='2' selected>Student</option>
                                      <option value='3'>Other</option>";
                              }
                              else{
                                echo "<option value='0'>Normal User</option>

                                      <option value='2'>Student</option>
                                      <option value='3' selected>Other</option>";
                              }
                            ?>
                          </select>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                  <!-- /Form -->
                  <?php
                }
              }
                   ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
