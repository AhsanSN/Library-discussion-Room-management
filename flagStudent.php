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

$query_editOptions = "select 
    * from lib_editOptions"; 
    $result_makingRoomsExpire = $con->query($query_editOptions);
    

?>
<script>
    var students_id_lst = [];
    var students_name_lst = [];

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
            students_name_lst[<?echo $i?>] = "<?echo $row['firstname']." ".$row['surname']?>"
        </script>
        <?
        $i +=1;
    }
}

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
                          <input name="studentId" id="studentIdBox" type="text" onkeyup="showFlaggedStudents()"  class="form-control" placeholder="" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Student Name:</label>
                        <input id="studentNameBox" value="" name="studentName" type="text" class="form-control" placeholder="" style="padding:9px;" required readonly>
                        </div>
                        </div>
                        <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Reason</label>
                            <select name="reason" class="form-control selectpicker" data-style="btn btn-link">
                              <option value="noReasonSpecified">-- Specify reason --</option>
                              
                              <?
                              if ($result_makingRoomsExpire->num_rows > 0)
                                { 
                                    while($row = $result_makingRoomsExpire->fetch_assoc()) 
                                    { 
                                        $bookingId = $row['comment'];
                                        echo '<option value="'.$bookingId.'">'.$bookingId.'</option>';

                                    }
                                }
                              
                              ?>
                            </select>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Flag</button>
                    </form>
                  </div>
                  <div style="display:none" class="alert alert-warning" role="alert" id="flaggedStudentsBox">
                          Flag on Student! Reason:
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
                    document.getElementById("submitBtn").disabled = false;
                    
                }
                if(count!=1){
                    document.getElementById("studentNameBox").value = "";
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

</html>
