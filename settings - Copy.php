<?include_once("global.php");?>
<?
if ($logged==0){ 
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}

if(isset($_POST["studentId"])&&isset($_POST["newPhone"])&&isset($_POST["oldPhone"])){
    $studentId = $_POST["studentId"];
    $newPhone = $_POST["newPhone"];
    $oldPhone = $_POST["oldPhone"];
    
     $sql="update lib_students set mobile='$newPhone' where mobile='$oldPhone' and cardnumber='$studentId'";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
}

if(isset($_GET["makeAdmin"])){
    $email = $_GET["makeAdmin"];
    
     $sql="update lib_users  set role='admin' where email='$email'";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
}

if(isset($_GET["downgradeAdmin"])){
    $email = $_GET["downgradeAdmin"];
    
    $sql="update lib_users  set role='staff' where email='$email'";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
}

if(isset($_GET["removeUser"])){
    $email = $_GET["removeUser"];
    
    $sql="delete from lib_users where email='$email'";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
}

if(isset($_POST["name"])&&isset($_POST["email"])&&isset($_POST["password"])){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    
     $sql="insert into lib_users(name, email, password, role) values('$name', '$email', '$password', 'staff')";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
}


if(isset($_POST["oldPassword"])){
    $newPassword = $_POST["newPassword"];
    $oldPassword = $_POST["oldPassword"];

if((!$newPassword)||(!$oldPassword)){
    $message = "Please insert both fields.";
    } 
else{ 

        //update room status
        $sql="update lib_users  set password='$newPassword' where password='$oldPassword' and email='$session_email '";
    
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


if(isset($_POST["flagComment"])){
    $flagComment = $_POST["flagComment"];

if((!$flagComment)){
    $message = "Please insert both fields.";
    } 
else{ 

        //update room status
        $sql="insert into lib_editOptions (`comment`, `cat`) values ('$flagComment', 'flag')";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
       
        
}}


//remove option
if(isset($_GET["removeFlagOption"])){
    $removeOption = $_GET["removeFlagOption"];

if((!$removeOption)){
    $message = "Please insert both fields.";
    } 
else{ 

        //update room status
        $sql="delete from lib_editOptions where id='$removeOption' and cat='flag'";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
       
        
}}


if(isset($_POST["queueCommentAdd"])){
    $flagComment = $_POST["queueCommentAdd"];

if((!$flagComment)){
    $message = "Please insert both fields.";
    } 
else{ 

        //update room status
        $sql="insert into lib_editOptions (`comment`, `cat`) values ('$flagComment', 'cancelQueue')";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
       
        
}}


//remove option
if(isset($_GET["queueOptionRemove"])){
    $removeOption = $_GET["queueOptionRemove"];

if((!$removeOption)){
    $message = "Please insert both fields.";
    } 
else{ 

        //update room status
        $sql="delete from lib_editOptions where id='$removeOption' and cat='cancelQueue'";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
       
        
}}


$query_bookedRoomsList = "select * from lib_editOptions where cat='flag'"; 
   
$query_cancelQueue = "select * from lib_editOptions where cat='cancelQueue'"; 

   
$query_users = "select * from lib_users"; 

?>
<script>
    var students_id_lst = [];
    var students_name_lst = [];
    var students_mobile_lst = [];

</script>
<?
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
          <li class="nav-item active">
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
            <div class="col-lg-6 col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">

                  <h4 class="card-title ">Change Phone Number - Student</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <form style="margin:12px;" method="post" action="" autocomplete="off" >
                     <div class="form-row">
                         <div class="form-group col-md-6">
                          <label for="inputEmail4">Student Id</label>
                          <input id="studentIdBox" onkeyup="showFlaggedStudents()" name="studentId" type="text" class="form-control" placeholder="" required>
                          </div>
                         <div class="form-group col-md-6">
                          <label for="inputEmail4">Student Name:</label>
                        <input id="studentNameBox" value="" name="studentName" type="text" class="form-control" placeholder="" style="padding:9px;" required readonly>
                        </div>
                       <div class="form-group col-md-6">
                          <label for="inputEmail4">New Phone Number</label>
                          <input id="newPhoneBox" onkeyup="validNumber()" name="newPhone" type="text" class="form-control" placeholder="" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Old Phone Number</label>
                          <input id="oldPhoneBox"  name="oldPhone" type="text" class="form-control" placeholder="" style="padding:9px;"  required readonly>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Change Number</button>
                    </form>
                  </div>
                </div>
              </div>
              
              <div class="card" style="margin-top: 40px;">
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

        
            <div class="col-lg-6 col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">

                  <h4 class="card-title ">Flag Options</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    
                    
                    <table class="table">
                        <tbody>
                          <?php
                          $result_bookedRoomList = $con->query($query_bookedRoomsList); 
                            if ($result_bookedRoomList->num_rows > 0)
                            { 
                                while($row = $result_bookedRoomList->fetch_assoc()) 
                                { 
                                    echo "<tr>";
                                    echo "<td>".$row['comment']."</td>";
                                    echo '<td><a href="./settings.php?removeOption='.$row['id'].'"><button class="btn btn-social btn-just-icon btn-google" style="background-color:red;"><i class="material-icons">cancel</i></button></a></td>';
                                    echo "</tr>";
                                }
                            }
                          ?>
                          
                        </tbody>
                      </table>
                      <tr>
                            <td>
                                <form method="post" action="" style="background-color:#f5eef6;padding:10px;">
                                    <label for="inputEmail4">Insert new Flag</label>
                                    <input name="flagComment" type="text" class="form-control" placeholder="" required>
                                    <button type="submit" class="btn btn-primary">Insert</button>
                                </form>
                            </td>
                          </tr>
                  </div>
                </div>
            </div>
            
                              <div class="card">
                <div class="card-header card-header-primary">

                  <h4 class="card-title ">Cancel Booking Queue Reasons</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    
                    
                    <table class="table">
                        <tbody>
                          <?php
                          $result_cancelQueue = $con->query($query_cancelQueue); 
                            if ($result_cancelQueue->num_rows > 0)
                            { 
                                while($row = $result_cancelQueue->fetch_assoc()) 
                                { 
                                    echo "<tr>";
                                    echo "<td>".$row['comment']."</td>";
                                    echo '<td><a href="./settings.php?queueOptionRemove='.$row['id'].'"><button class="btn btn-social btn-just-icon btn-google" style="background-color:red;"><i class="material-icons">cancel</i></button></a></td>';
                                    echo "</tr>";
                                }
                            }
                          ?>
                          
                        </tbody>
                      </table>
                      <tr>
                            <td>
                                <form method="post" action="" style="background-color:#f5eef6;padding:10px;">
                                    <label for="inputEmail4">Insert new Flag</label>
                                    <input name="queueCommentAdd" type="text" class="form-control" placeholder="" required>
                                    <button type="submit" class="btn btn-primary">Insert</button>
                                </form>
                            </td>
                          </tr>
                  </div>
                </div>
            </div>

          </div>
        </div>
        
        
        
        <?if($session_role=="admin"){?>
                <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              
              <div class="card">
                <div class="card-header card-header-primary">

                  <h4 class="card-title ">Users</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    
                    
                    <table class="table">
                        <thead class=" text-primary">
                        <th>
                          Name
                        </th>
                        <th class="text-primary">
                          Email
                        </th>
                        <th>
                          Role
                        </th>
                        <th>
                          Action
                        </th>
                        
                      </thead>
                        <tbody>
                          <?php
                          $result_users = $con->query($query_users); 
                            if ($result_users->num_rows > 0)
                            { 
                                while($row = $result_users->fetch_assoc()) 
                                { 
                                    echo "<tr>";
                                    echo "<td>".$row['name']."</td>";
                                    echo "<td>".$row['email']."</td>";
                                    echo "<td>".$row['role']."</td>";
                                    echo '<td><a href="./settings.php?makeAdmin='.$row['email'].'"><button class="btn btn-social btn-just-icon btn-google" style="background-color:green;"><i class="material-icons">arrow_upward</i></button></a></td>';
                                    echo '<td><a href="./settings.php?downgradeAdmin='.$row['email'].'"><button class="btn btn-social btn-just-icon btn-google" style="background-color:orange;"><i class="material-icons">arrow_downward</i></button></a></td>';
                                    echo '<td><a href="./settings.php?removeUser='.$row['email'].'"><button class="btn btn-social btn-just-icon btn-google" style="background-color:red;"><i class="material-icons">cancel</i></button></a></td>';
                                    echo "</tr>";
                                }
                            }
                          ?>
                          
                        </tbody>
                      </table>
                      <tr>
                    <td>
                        <form method="post" action="" style="background-color:#f5eef6;padding:10px;">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                  <label for="inputEmail4">Name</label>
                                  <input name="name" type="text" class="form-control" placeholder="" required>
                                </div>
                                <div class="form-group col-md-4">
                                  <label for="inputEmail4">Email</label>
                                  <input name="email" type="email" class="form-control" placeholder="" required>
                                </div>
                                <div class="form-group col-md-4">
                                  <label for="inputEmail4">Password</label>
                                  <input name="password" type="password" class="form-control" placeholder="" required>
                                </div>
                               
                              </div>
                            
                            <button type="submit" class="btn btn-primary">Insert User</button>
                        </form>
                    </td>
                  </tr>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?}?>

      </div>
     <?include_once("./phpParts/footer.php");?>
     <script>
     var count = 0;
         function showFlaggedStudents(){
            var search = document.getElementById("studentIdBox").value;
            if (search!= '')
            {
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
                    document.getElementById("oldPhoneBox").value = (students_mobile_lst[countI]).toString();
                }
                if(count!=1){
                    document.getElementById("studentNameBox").value = "";
                    document.getElementById("oldPhoneBox").value = "";
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

    function validNumber(){
        if(document.getElementById("newPhoneBox").value.length==12){
            document.getElementById("submitBtn").disabled = false;
                
            }else{
                document.getElementById("submitBtn").disabled = true;
            }
    }
     </script>
     
</body>

</html>
