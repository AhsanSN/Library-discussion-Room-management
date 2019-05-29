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
date_default_timezone_set("Asia/Karachi");
if(isset($_POST["studentId"]) && isset($_GET["room"])){
    $room = $_GET["room"]; 
    $studentId = $_POST["studentId"];
    $nStudents = $_POST["nStudents"];
    $reason = $_POST["reason"];
    
    $timeTaken = date("d-m-Y:h:i:sa");//strval(date("d-m-Y"))+strval(date("h:i:sa")) ;
    $expiry = time()+ 3600*(2);
    
if((!$room)||(!$studentId)){
    $message = "Please insert both fields.";
    } 
else{ 
    //go
    
    function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
    }
    
    $bookingId = generateRandomString();
    
    $sql="INSERT INTO `lib_bookings`(`studentId`, `dateTimeTaken`, `nStudents`, `room`, `expiry`, `status`, `bookingId`, `purpose`) VALUES ('$studentId', '$timeTaken', '$nStudents', '$room', '$expiry', 'booked', '$bookingId', '$reason')";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
        
        //update room status
        $sql="update lib_room set status='booked', bookingId='$bookingId' where room='$room'";
    
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
    var students_id_lst = [];
    var students_name_lst = [];
    var students_mobile_lst = [];

    var flagged_students_lst = [];
    var flagged_students_lst_reason = [];
    var flagged_students_lst_timePlaced = [];
</script>
<?

$query = "SELECT `id`, `studentId`, `reason`, `timePlaced` FROM `lib_flags` order by id desc
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
            flagged_students_lst_timePlaced[<?echo $i?>] = "<?echo date('d-m-Y H:i', $row['timePlaced'])?>"
        </script>
        <?
        $i +=1;
    }
}

$query = "SELECT * from lib_students order by id desc
"; 
$result = $con->query($query); 
$i = 0;
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        ?>
        <script>
            students_id_lst[<?echo $i?>] = "<?echo $row['cardnumber']?>"
            students_mobile_lst[<?echo $i?>] = "<?echo $row['mobile']?>"
            students_name_lst[<?echo $i?>] = "<?echo $row['firstname']." ".$row['surname']?>"
        </script>
        <?
        $i +=1;
    }
}

?>
<script>
    //console.log("students_id_lst", students_id_lst);
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
            <a class="nav-link" href="./allDataDownload.php" >
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

                  <h4 class="card-title ">Book Room - <?echo $room?></h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <form style="margin:12px;" method="post" action="" autocomplete="off" >
                     <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Student ID</label>
                          <input id="studentIdBox" onkeyup="showFlaggedStudents()" name="studentId" type="text" class="form-control" placeholder="" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Student Name:</label>
                        <input id="studentNameBox" value="" name="studentName" type="text" class="form-control" placeholder="" style="padding:9px;" required readonly>
                        </div>
                       
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Number of occupants</label>
                          <input name="nStudents" type="number" class="form-control" placeholder="" required>
                        </div>
                        
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Mobile No.</label>
                        <input id="mobileBox" value="" name="mobile" type="text" class="form-control" placeholder="" style="padding:9px;" required readonly>
                        </div>
                        
                      </div>
                      
                      <div class="form-row">
                      
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Purpose</label>
                            <select name="reason" class="form-control selectpicker" data-style="btn btn-link">
                              <option value="noReasonSpecified">-- Specify reason --</option>
                              <option value="Group Study">Group Study</option>
                              <option value="Presentation">Presentation</option>
                              <option value="Assignment">Assignment</option>
                              <option value="Session">Session</option>
                              <option value="Interview">Interview</option>
                            </select>
                        </div>
                    </div>
                        
                      <div style="display:none" class="alert alert-warning" role="alert" id="flaggedStudentsBox">
                          Flag on Student! Reason:
                        </div>

                      <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Book</button>
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
     var count = 0;
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
                        //console.log("flagged_students_lst_reason[i]", flagged_students_lst_timePlaced[i]);
                        var $deleteLink = $("<span>"+((flagged_students_lst_timePlaced[i])).substr(0,21)+": "+flagged_students_lst_reason[i]+"</span>");
                        $myList.append($deleteLink);
                    }
                }
                if(document.getElementById("flaggedStudentsBox").innerHTML == "Flag on Student! Reason:<hr>"){
                    document.getElementById("flaggedStudentsBox").innerHTML = " ";
                    document.getElementById("flaggedStudentsBox").style.display = "none";
                }
                //show studentname
                count = 0;
                var countI = 0;
                //search = Number(search)
                for (var i = 0; i < students_id_lst.length; i++) {
                    if(students_id_lst[i].indexOf(search) != -1)
                    {
                        //console.log("students_id_lst[i]", students_id_lst[i], students_name_lst[i]);
                        count +=1;
                        countI=i;
                    }
                }
                if(count==1){
                    document.getElementById("studentNameBox").value = (students_name_lst[countI]).toString();
                    document.getElementById("mobileBox").value = (students_mobile_lst[countI]).toString();
                    document.getElementById("submitBtn").disabled = false;
                    
                }
                if(count!=1){
                    document.getElementById("studentNameBox").value = "";
                    document.getElementById("mobileBox").value = "";
                    document.getElementById("submitBtn").disabled = true;

                }
                
            }
            if (search== '')
            {
                document.getElementById("flaggedStudentsBox").innerHTML = " ";
                document.getElementById("flaggedStudentsBox").style.display = "none";
                document.getElementById("studentNameBox").value = "";
                document.getElementById("submitBtn").disabled = true;
            }
            
        }


     </script>
</body>

</html>
