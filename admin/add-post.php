
<?php include "header.php";
      include "config.php";
if(isset($_SESSION["message"])){
   echo $_SESSION["message"];
   unset($_SESSION["message"]);
}
?>
  <div id="admin-content">
      <div class="container">
         <div class="row">
             <div class="col-md-12">
                 <h1 class="admin-heading">Add New Post</h1>
             </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form -->
                  <form  action="save-post.php" method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                          <label for="post_title">Title</label>
                          <input type="text" name="post_title" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1"> Description</label>
                          <textarea name="postdesc" class="form-control" rows="5"  required></textarea>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Category</label>
                          <select name="category" class="form-control" required>
                              <option disabled selected> Select Category</option>
                              <?php
                                include "config.php";
                                $sql = "SELECT * FROM category";

                                $result = mysqli_query($conn, $sql) or die("Query Failed.");

                                if(mysqli_num_rows($result) > 0){
                                  while($row = mysqli_fetch_assoc($result)){
                                    echo "<option value='{$row['category_id']}'>{$row['category_name']}</option>";
                                  }
                                }
                              ?>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Post image</label>
                          <input type="file" name="fileToUpload" required id="img">
                          <!-- <button id="uploadbutton">Upload Image</button>
                          <div id="img"></div> <br>-->
                        <span style="color:green">*File should be less than or equal to 1mb.<br>*File should be jpg,jpeg or png format only.</span>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Save"  required />
                  </form>
                  <!--/Form -->


              </div>
          </div>
      </div>
  </div>

<?php include "footer.php"; ?>
<!-- <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script>
$(document).ready(function(){
  $("#uploadbutton").click(function(){
    var imgname=$("#img").val();
    console.log(imgname);
    if(imgname==""){
      alert("Please Select Image");
      return false;
    }
    else{
      $("#img").html(`<h2> hello ${imgname}</h2>`);
      return true;
    }
  })
})
</script> -->
