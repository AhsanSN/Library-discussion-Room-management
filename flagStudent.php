<?include_once("global.php");?>
<?
if ($logged==0){ 
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}
if(isset($_POST["studentId"])){
    $studentId = $_POST["studentId"];
    $reason = $_POST["reason"];

    date_default_timezone_set("Asia/Karachi");
    $timePlaced = time();
    
if(false){//(!$studentId)||(!$reason)
    $message = "Please insert both fields.";
    } 
else{ 
    //go
        $sql="INSERT INTO `lib_flags`(`studentId`,`reason`,  `timePlaced`) VALUES ('$studentId', '$reason', '$timePlaced')";
    
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

?>
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
          <li class="nav-item ">
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
          <li class="nav-item active">
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
            <a class="navbar-brand" href="#pablo">Flag Students</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
           
            <ul class="navbar-nav">
            
              
              <li class="nav-item dropdown">
                <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="#">Log out</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              
              <div class="card">
                <div class="card-header card-header-primary">

                  <h4 class="card-title ">Flag Students</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <form style="margin:12px;" method="post" action="">
                     <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Student ID</label>
                          <input name="studentId" id="studentIdBox" type="text" class="form-control" placeholder="" required>
                        </div>
                        </div>
                        <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Reason</label>
                            <select name="reason" class="form-control selectpicker" data-style="btn btn-link">
                              <option value="noReasonSpecified">-- Specify reason --</option>
                              <option value="Left too late">Left too late</option>
                              <option value="Watching movie">Watching movie</option>
                              <option value="Locked the unattended room">Locked the unattended room</option>
                              <option value="Misbehaved">Misbehaved</option>
                              <option value="Eating in the room">Eating in the room</option>
                              <option value="Too little students in the room">Too little students in the room</option>
                              <option value="Too much noise">Too much noise</option>
                            </select>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary">Flag</button>
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

<?
if(isset($_GET["studentId"])){
    $studentId = ($_GET["studentId"]);
    
    ?>
    <script>
        document.getElementById("studentIdBox").value = <?echo '"'.$studentId.'"'?>;
        document.getElementById("studentIdBox").readOnly  = true;
    </script>
    <?
}
?>

</html>
