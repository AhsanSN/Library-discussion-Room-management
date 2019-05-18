<?include_once("global.php");?>
<?
if ($logged==0){ 
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}
if(isset($_POST["oldPassword"])){
    $newPassword = $_POST["newPassword"];
    $oldPassword = $_POST["oldPassword"];

if((!$newPassword)||(!$oldPassword)){
    $message = "Please insert both fields.";
    } 
else{ 

        //update room status
        $sql="update yp_vendors  set password='$newPassword' where password='$oldPassword' and email='$session_email '";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
       
        ?>
    <script type="text/javascript">
            window.location = "./dashboard.php";
        </script>
    <?
        
}}
//get flagged students:

?>
<script>
    var flagged_students_lst = [];
    var flagged_students_lst_reason = [];
    var flagged_students_lst_timePlaced = [];
</script>
<?

$query = "SELECT `id`, `studentId`, `reason`, `timePlaced` FROM `lib_flags`
"; 
$result = $con->query($query); 
$i = 0;
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        ?>
        <script>
            flagged_students_lst[<?echo $i?>] = "<?echo $row['studentId']?>"
            flagged_students_lst_reason[<?echo $i?>] = "<?echo $row['reason']?>"
            flagged_students_lst_timePlaced[<?echo $i?>] = "<?echo $row['timePlaced']?>"
        </script>
        <?
        $i +=1;
    }
}

?>
<script>
    console.log("flagged_students_lst", flagged_students_lst);
</script>
<!DOCTYPE html>
<html lang="en">
<?include_once("./phpParts/head.php");?>


<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="assets/img/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo">
        <a href="./" class="simple-text logo-normal">
          HU - Library
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item active  ">
            <a class="nav-link" href="./dashboard.php">
              <i class="material-icons">dashboard</i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./history.php">
              <i class="material-icons">library_books</i>
              <p>History</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./flagStudent.php">
              <i class="material-icons">flag</i>
              <p>Flag Students</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./allDataDownload.php">
              <i class="material-icons">import_export</i>
              <p>Export data</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./settings.php">
              <i class="material-icons">settings</i>
              <p>Settings</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="#pablo">Settings</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              
              <div class="card">
                <div class="card-header card-header-primary">

                  <h4 class="card-title ">Change Password</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <form style="margin:12px;" method="post" action="" autocomplete="off" >
                     <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Old Password</label>
                          <input id="studentIdBox"  name="oldPassword" type="password" class="form-control" placeholder="" required>
                        </div>
                       <div class="form-group col-md-6">
                          <label for="inputEmail4">New Password</label>
                          <input id="studentIdBox"  name="newPassword" type="password" class="form-control" placeholder="" required>
                        </div>
                      </div>
                     

                      <button type="submit" class="btn btn-primary">Change Password</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
     <?include_once("./phpParts/footer.php");?>
     
</body>

</html>
