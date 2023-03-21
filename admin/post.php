<?php

if(isset($_GET['page'])){
$pages=$_GET['page'];
}
else{
 $pages=1;
}
include "header.php";
if(isset($_SESSION["addpostmessage"])){
  echo $_SESSION["addpostmessage"];
  unset($_SESSION["addpostmessage"]);
}
if(isset($_SESSION['daletepostmessage'])){
  echo $_SESSION['daletepostmessage'];
  unset($_SESSION['daletepostmessage']);
}
if(isset($_SESSION['updatepostmessage'])){
  echo $_SESSION['updatepostmessage'];
  unset($_SESSION['updatepostmessage']);
}
 ?>
<style>
@media (max-width:656px){
  #admin-content .content-table{
      border: 1px solid #000;
      width: 560px;
      font-size:11.8px;
      margin: 0 0 20px;
  }
  #admin-content .add-new{
    width: 560px;
  }
  #admin-content .tabletxt{
width: 90%;

  }
}
@media (max-width:600px){
  #admin-content .content-table{
      border: 1px solid #000;
      width: 500px;
      font-size:11.8px;
      margin: 0 0 20px;
  }
  #admin-content .add-new{
    width: 500px;
  }
  #admin-content .tabletxt{
width: 90%;

  }
}
@media (max-width:500px){
  #admin-content .content-table{
      border: 1px solid #000;
      width: 457px;
      font-size:11px;
      margin: 0 0 20px;
      /* overflow-x: scroll; */
  }
  #admin-content .add-new{
    width: 101%;
  }
}

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

}


/* // @media (max-width:500px){
//     body{
//         overflow-x:hidden;
//     }
//   #admin-content .content-table{
//       border: 1px solid #000;
//       width: 70%;
//       font-size:11.8px;
//       margin: 0 0 20px;
//   }
//   #admin-content .post{
//     width: 96.6%;
//   }
//   #admin-content .tabletxt{
// width: 520px;

// overflow-x: scroll;

//   }

// }

// @media (max-width:360px){
//   #admin-content .post{
//     width: 100%;
//   }
//   #admin-content .tabletxt{
// width: 96%;

// overflow-x: scroll;

//   }
//   #admin-content .tabletxt .content-table th{
//  font-size: 12px;

//   }

// } */

 </style>
    <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-3 post">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12 tabletxt">
                <?php
                  include "config.php"; // database configuration
                  /* Calculate Offset Code */
                  $limit = 10;
                  if(isset($_GET['page'])){
                    $page = $_GET['page'];
                  }else{
                    $page = 1;
                  }
                  $offset = ($page - 1) * $limit;

                  if($_SESSION["user_role"] == '1'){
                    /* select query of post table for admin user */
                    $sql = "SELECT post.post_id, post.title, post.description,post.post_date,
                    category.category_name,user.username,post.category FROM post
                    LEFT JOIN category ON post.category = category.category_id
                    LEFT JOIN user ON post.author = user.user_id
                    ORDER BY post.post_id DESC LIMIT {$offset},{$limit}";
                  }elseif($_SESSION["user_role"] == '0'||$_SESSION["user_role"] == '2'||$_SESSION["user_role"] == '3'){
                    /* select query of post table for normal user */
                    $sql = "SELECT post.post_id, post.title, post.description,post.post_date,
                    category.category_name,user.username,post.category FROM post
                    LEFT JOIN category ON post.category = category.category_id
                    LEFT JOIN user ON post.author = user.user_id
                    WHERE post.author = {$_SESSION['user_id']}
                    ORDER BY post.post_id DESC LIMIT {$offset},{$limit}";
                  }

                  $result = mysqli_query($conn,$sql) or die("Query Failed ho gyi.");
                  if(mysqli_num_rows($result) > 0){
                ?>
                  <table class="content-table" >
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                        <?php
                        $serial = $offset + 1;
                        while($row = mysqli_fetch_assoc($result)) {?>
                          <tr>
                              <td class='id'><?php echo $serial; ?></td>
                              <td><?php echo $row['title']; ?></td>
                              <td><?php echo $row['category_name']; ?></td>
                              <td><?php echo $row['post_date']; ?></td>
                              <td><?php echo $row['username']; ?></td>
                              <td class='edit'><a href='update-post.php?id=<?php echo $row['post_id'];?>&page=<?php echo $pages ?>' onClick='return updated()'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php?id=<?php echo $row['post_id']; ?>&catid=<?php echo $row['category']; ?>&page=<?php echo $pages;?>' onClick='return deleted()'><i class='fa fa-trash-o' ></i></a></td>

                          </tr>
                          <?php
                          $serial++;
                        } ?>
                      </tbody>
                  </table>

                  <script>


                  function deleted(){

                    if(confirm('Are You Sure You Want to Delete Post...!')) return  true;
                    else return false;


                    }
                    function updated(){

                      if(confirm('Are You Sure You Want to Update Post...!')) return  true;
                      else return false;


                      }

                  </script>
                  <?php
                }else {
                  echo "<h3>No Results Found.</h3>";
                }
                // show pagination
                if($_SESSION["user_role"] == '1'){
                  /* select query of post table for admin user */
                  $sql1 = "SELECT * FROM post";
                }elseif($_SESSION["user_role"] == '0'||$_SESSION["user_role"] == '2'||$_SESSION["user_role"] == '3'){
                  /* select query of post table for normal user */
                  $sql1 = "SELECT * FROM post
                  WHERE author = {$_SESSION['user_id']}";
                }
                $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");

                if(mysqli_num_rows($result1) > 0){

                  $total_records = mysqli_num_rows($result1);

                  $total_page = ceil($total_records / $limit);

                  echo '<ul class="pagination admin-pagination">';
                  if($page > 1){
                    echo '<li><a href="post.php?page='.($page - 1).'">Prev</a></li>';
                  }
                  for($i = 1; $i <= $total_page; $i++){
                    if($i == $page){
                      $active = "active";
                    }else{
                      $active = "";
                    }
                    echo '<li class="'.$active.'"><a href="post.php?page='.$i.'">'.$i.'</a></li>';
                  }
                  if($total_page > $page){
                    echo '<li><a href="post.php?page='.($page + 1).'">Next</a></li>';
                  }

                  echo '</ul>';
                }
                  ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
