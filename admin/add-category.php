<?php
include "header.php";
ob_start();
if(isset($_SESSION['addwrongcategorystatus'])){
  echo $_SESSION['addwrongcategorystatus'];
  unset($_SESSION['addwrongcategorystatus']);
}
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add New Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off">
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat" class="form-control" placeholder="Category Name" required>
                      </div>
                      <input type="submit" name="save" class="btn btn-primary" value="Save" required />
                  </form>
                  <!-- /Form End -->
              </div>
          </div>
      </div>
  </div>
  <?php

    if(isset($_POST['save'])){
        // database configuration
        include 'config.php';
        $category =mysqli_real_escape_string($conn, $_POST['cat']);
        // echo $category;

        /* query for check input value exists in category table or not*/
        $sql = "SELECT category_name FROM category where category_name='{$category}'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result)> 0) {
            // if input value exists
            $_POST['cat']="";
            $_SESSION['addwrongcategorystatus']="<div class='alert alert-danger'> Category already exists.</div>";
             header("Location:{$hostname}/admin/add-category.php");

            // echo "<p style = 'color:red;text-align:center;margin: 10px 0';> Category already exists.</p>";
        }else{
            // if input value not exists
             /* query for insert record in category name */
            $sql1 = "INSERT INTO category (category_name)
                    VALUES ('{$category}')";
            $result1=mysqli_query($conn, $sql1);
            if ($result1){

              $_SESSION['addcategorystatus']='<div class="alert alert-success">Category add Sucessfully...!.</div>';
              $_POST['cat']="";
                header("Location:{$hostname}/admin/category.php");
            }else{

              $_SESSION['addwrongcategorystatus']="<div class='alert alert-danger'>Query Failed.</div>";
              $_POST['cat']="";
               header("Location:{$hostname}/admin/add-category.php");

              // echo "<p style = 'color:red;text-align:center;margin: 10px 0';>Query Failed.</p>";
            }
        }
    }
    mysqli_close($conn);

    include "footer.php";
  ?>
