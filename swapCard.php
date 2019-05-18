<?include_once("global.php");?>
<?
if ($logged==0){ 
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}
$room = $_GET["room"]; 
if(isset($_POST["studentId"]) && isset($_GET["room"])){
    $room = $_GET["room"]; 
    $studentId = $_POST["studentId"];

if((!$room)||(!$studentId)){
    $message = "Please insert both fields.";
    } 
else{ 
    //go
    
    //get tracking id
    
    $query_makingRoomsExpire = "select 
    r.bookingId, b.studentId
    from lib_bookings b inner join lib_room r on r.bookingId = b.bookingId where r.room = '$room'
    "; 
    $result_makingRoomsExpire = $con->query($query_makingRoomsExpire);
    if ($result_makingRoomsExpire->num_rows > 0)
    { 
        while($row = $result_makingRoomsExpire->fetch_assoc()) 
        { 
            $bookingId = $row['bookingId'];
            $beforeId =  $row['studentId'];
        }
    }
    

        //update room status
        $sql="update lib_bookings set studentId='$studentId' where room='$room' and bookingId='$bookingId'";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
        
        //add to data
        date_default_timezone_set("Asia/Karachi");
        $timeSwapped = date("d-m-Y:h:i:sa");
        
        $sql="INSERT INTO `lib_swapCard`(`beforeId`, `afterId`, `bookingId`, `timeSwapped`) VALUES ('$beforeId','$studentId','$bookingId','$timeSwapped')";
    
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
          <<li class="nav-item">
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
            <a class="navbar-brand" href="#pablo">Book a room</a>
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

                  <h4 class="card-title ">Swap Cards - <?echo $room?></h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <form style="margin:12px;" method="post" action="" autocomplete="off" >
                     <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Student ID</label>
                          <input id="studentIdBox"  onkeyup="showFlaggedStudents()" name="studentId" type="text" class="form-control" placeholder="" required>
                        </div>
                       
                      </div>
                      <div style="display:none" class="alert alert-warning" role="alert" id="flaggedStudentsBox">
                          Flag on Student! Reason:
                        </div>

                      <button type="submit" class="btn btn-primary">Swap</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
     <?include_once("./phpParts/footer.php");?>
     <script>
         function showFlaggedStudents(){
            var search = document.getElementById("studentIdBox").value;
            if (search!= '')
            {
                var $myList = $('#flaggedStudentsBox');
                document.getElementById("flaggedStudentsBox").innerHTML = "Flag on Student! Reason:<hr>";
                document.getElementById("flaggedStudentsBox").style.display = "block";
                for (var i = 0; i < flagged_students_lst.length; i++) {
                    if(flagged_students_lst[i].indexOf(search.toLowerCase()) != -1)
                    {
                        console.log("flagged_students_lst_reason[i]", flagged_students_lst_reason[i]);
                        var $deleteLink = $("<span>"+(Date(flagged_students_lst_timePlaced[i])).substr(0,21)+": "+flagged_students_lst_reason[i]+"</span>");
                        $myList.append($deleteLink);
                    }
                }
                if(document.getElementById("flaggedStudentsBox").innerHTML == "Flag on Student! Reason:<hr>"){
                    document.getElementById("flaggedStudentsBox").innerHTML = " ";
                    document.getElementById("flaggedStudentsBox").style.display = "none";
                }
                
            }
            if (search== '')
            {
                document.getElementById("flaggedStudentsBox").innerHTML = " ";
                document.getElementById("flaggedStudentsBox").style.display = "none";
            }
        }


     </script>
</body>

</html>
