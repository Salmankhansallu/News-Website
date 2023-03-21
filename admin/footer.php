<!-- Footer -->

<style>
body{
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}
#footer{

  margin-top: auto;
}
 @media (max-width:500px){
  #footer{
    width: 100%;

  }
}
@media (max-width:360px){
  #footer{
    width: 100%;
  }
}

</style>
<?php
date_default_timezone_set("asia/kolkata");
$year=date('Y');
$month=date('m');
$day=date('d');

?>

<body>
<div id ="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
              <?php
                include "config.php";

                $sql = "SELECT * FROM settings";

                $result = mysqli_query($conn, $sql) or die("Query Failed.");
                if(mysqli_num_rows($result) > 0){
                  while($row = mysqli_fetch_assoc($result)) {
              ?>
                <span>© Copyright <?php echo $day."/". $month."/".$year." || Powered By ".$row['footerdesc']; ?></span>
              <?php
                }
              }
              ?>
            </div>
        </div>
    </div>
</div>
</body>
