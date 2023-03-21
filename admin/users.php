<style>
@media (max-width:360px){
  #admin-content .post{
    width: 100%;
  }
  #admin-content .tabletxt{
width: 96%;
overflow-x: scroll;

  }
  #admin-content .tabletxt .content-table th{
 font-size: 12px;

  }
</style>
<?php include "header.php";
if(isset($_SESSION['status'])){
  echo $_SESSION['status'];
  unset($_SESSION['status']);
}
if(isset($_SESSION['deleteuser'])){
  echo $_SESSION['deleteuser'];
  unset($_SESSION['deleteuser']);
}
if(isset($_SESSION['updateusermessage'])){
  echo $_SESSION['updateusermessage'];
  unset($_SESSION['updateusermessage']);
}

 if(isset($_GET['page'])){
 $pages=$_GET['page'];
}
else{
  $pages=1;
}
// echo $pages;
?>

  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Users</h1>
              </div>
              <div class="col-md-2 post">
                  <a class="add-new" href="add-user.php">add user</a>
              </div>
              <div class="col-md-12 tabletxt">
                <?php
                  include "config.php"; // database configuration
                  /* Calculate Offset Code */
                  $limit = 5;
                  if(isset($_GET['page'])){
                    $page = $_GET['page'];
                  }else{
                    $page = 1;
                  }

                  $offset = ($page - 1) * $limit;
                  /* select query of user table with offset and limit */
                  $sql = "SELECT * FROM user ORDER BY user_id DESC LIMIT {$offset},{$limit}";
                  $result = mysqli_query($conn, $sql) or die("Query Failed.");
                  if(mysqli_num_rows($result) > 0){
                ?>
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Full Name</th>
                          <th>User Name</th>
                          <th>Role</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                        <?php
                          $serial = $offset + 1;
                          while($row = mysqli_fetch_assoc($result)) {
                        ?>
                          <tr>
                              <td class='id'><?php echo $serial; ?></td>
                              <td><?php echo $row['first_name'] . " ". $row['last_name']; ?></td>
                              <td><?php echo $row['username']; ?></td>
                              <td><?php
                                  if($row['role'] == 0){
                                    echo "Normal";
                                  }else if($row['role'] == 1){
                                    echo "Admin";
                                  }
                                  else if($row['role'] == 2){
                                    echo "Student";
                                  }
                                  else{
                                    echo "Other";
                                  }
                               ?></td>
                              <td class='edit'><a href='update-user.php?id=<?php echo $row["user_id"].".".$pages; ?>' onClick='return updated()'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-user.php?id=<?php echo $row["user_id"].".".$pages; ?>' onClick='return deleted()'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                        <?php
                          $serial++;
                        } ?>
                      </tbody>
                  </table>
                  <script>


                  function deleted(){

                    if(confirm('Are You Sure You Want to Delete User...!')) return  true;
                    else return false;


                    }
                    function updated(){

                      if(confirm('Are You Sure You Want to Update User Detail...!')) return  true;
                      else return false;


                      }

                  </script>
                  <?php
                }else {
                  echo "<h3>No Results Found.</h3>";
                }
                // show pagination
                $sql1 = "SELECT * FROM user";
                $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");

                if(mysqli_num_rows($result1) > 0){

                  $total_records = mysqli_num_rows($result1);

                  $total_page = ceil($total_records / $limit);

                  echo '<ul  class="pagination admin-pagination">';
                  if($page > 1){
                    echo '<li ><a href="users.php?page='.($page - 1).'">Prev</a></li>';
                  }
                  for($i = 1; $i <= $total_page; $i++){
                    if($i == $page){
                      $active = "active";
                    }else{
                      $active = "";
                    }
                    echo '<li class="'.$active.'"><a href="users.php?page='.$i.'">'.$i.'</a></li>';
                  }
                  if($total_page > $page){
                    echo '<li><a href="users.php?page='.($page + 1).'">Next</a></li>';
                  }

                  echo '</ul>';
                }
                  ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
