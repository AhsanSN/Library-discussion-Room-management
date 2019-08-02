<?include_once("global.php");?>
<!DOCTYPE html>
<html lang="en">

<?include("./phpParts/head.php")?>
<body class="" onload="startTime()">

<?
function logout() {
    session_destroy();
  }
  if (isset($_GET['logout'])) {
    logout();
    $logged=0;
  }
  
if ($logged==0){ 
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}


//free room

if(isset($_GET["freeroom"])){
    $room = $_GET["freeroom"]; 

if((!$room)){
    $message = "Please insert both fields.";
    } 
else{ 
    //go
 
    //update room status
    
    //get tracking id
    
    $query_makingRoomsExpire = "select 
    r.bookingId
    from lib_bookings b inner join lib_room r on r.bookingId = b.bookingId where r.room = '$room'
    "; 
    $result_makingRoomsExpire = $con->query($query_makingRoomsExpire);
    if ($result_makingRoomsExpire->num_rows > 0)
    { 
        while($row = $result_makingRoomsExpire->fetch_assoc()) 
        { 
            $bookingId = $row['bookingId'];
        }
    }
        
        //
    $expiry = time()-10;    
    $sql="update lib_bookings set status='free', expiry='$expiry' where room='$room' and bookingId = '$bookingId'";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
        
        
        $sql="update lib_room set status='free' where room='$room'";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
        
        ?>
   
    <?
        
}}


//queue booking
if(isset($_POST['occupants'])&&isset($_POST['studentId'])){
    $occupants = $_POST['occupants'];
    $studentId = $_POST['studentId'];
    
    //update room status
    date_default_timezone_set("Asia/Karachi");
    $timeTaken = date("d-m-Y:h:i:sa");
    
        $sql="insert into lib_bookingQueue (`studentId`, `occupants`, `bookingTime`, `status`) values ('$studentId','$occupants', '$timeTaken', 'waiting')";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
        }
}


//sending notification
if(isset($_GET['notfType'])&&isset($_GET['bookingId'])){
    
    $notfType = $_GET['notfType'];
    $bookingId = $_GET['bookingId'];
    $notfSent = false;
    
    //$studentId = $_GET['studentId'];
    
    
    if($notfType!='bookingQueue'){
        
        $query = "SELECT * FROM lib_bookings where bookingId='$bookingId'"; 
        $result = $con->query($query); 
        if ($result->num_rows > 0)
        { 
            while($row = $result->fetch_assoc()) 
            { 
                $studentId = $row['studentId'];
                $room = $row['room'];
            }
        }
    
        //check if sent
        $query = "SELECT * FROM `lib_notfStatus` n right OUTER join lib_room r on n.bookingId = r.bookingId where r.status!='free' and r.bookingId='$bookingId' and n.notfType='$notfType' order by r.room desc"; 
        $result = $con->query($query); 
        if ($result->num_rows > 0)
        { 
            while($row = $result->fetch_assoc()) 
            { 
                if(($row['bookingId']==$bookingId)&&($row['notfType']==$notfType)){
                    $notfSent = true;
                }
            }
        }
        if($notfSent==false){
           
            ?>
        <script type="text/javascript">
                console.log("sending notification");
            </script>
    
        <?
           include_once("./profiles/sendAllNotf.php"); 
        }
    }
    if($notfType=='bookingQueue'){
        
        $query = "SELECT * FROM lib_bookingQueue where id='$bookingId'"; 
        $result = $con->query($query); 
        if ($result->num_rows > 0)
        { 
            while($row = $result->fetch_assoc()) 
            { 
                $studentId = $row['studentId'];
                $bookingTime = $row['bookingTime'];
            }
        }
        $room = '12';
        
        //check if sent
        $query = "SELECT * FROM `lib_notfStatus` n right OUTER join lib_bookingQueue b on n.bookingId = b.id where b.status='waiting' and b.id='$bookingId' and n.notfType='bookingQueue' order by b.id desc"; 
        $result = $con->query($query); 
        if ($result->num_rows > 0)
        { 
            while($row = $result->fetch_assoc()) 
            { 
                if(($row['bookingId']==$bookingId)&&($row['notfType']==$notfType)){
                    $notfSent = true;
                }
            }
        }
        if($notfSent==false){
           
            ?>
        <script type="text/javascript">
                console.log("sending notification");
            </script>
    
        <?
        include_once("./profiles/sendAllNotfBookingQueue.php"); 
        }
    }

}


//number of rooms booked uptil now
$query = "select 
	(count(room)) as 'amount'
from lib_bookings t order by room
"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        $nRoomsBookedTillNow= $row['amount'];
    }
}

//updating rooms in case of expiry
$query_makingRoomsExpire = "select 
*
from lib_bookings where status = 'booked'
"; 
$result_makingRoomsExpire = $con->query($query_makingRoomsExpire);
if ($result_makingRoomsExpire->num_rows > 0)
{ 
    while($row = $result_makingRoomsExpire->fetch_assoc()) 
    { 
        if($row['expiry']<time()){
            $room = $row['room'];
            $sql="update lib_room set status='expired' where room='$room'";
        
            if(!mysqli_query($con,$sql))
            {
            echo"can not";
            }
            
            $sql="update lib_bookings set status='expired' where room='$room'";
        
            if(!mysqli_query($con,$sql))
            {
            echo"can not";
            }
            
        }
    }
}

//free rooms
$query = "select 
	(count(room)) as 'amount'
from lib_room where status = 'free'
"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        $nFreeRooms= $row['amount'];
    }
}

//booked rooms
$query = "select 
	(count(room)) as 'amount'
from lib_room where status = 'booked'
"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        $nBookedRooms= $row['amount'];
    }
}

//expired rooms
$query = "select 
	(count(room)) as 'amount'
from lib_room where status = 'expired'
"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        $nExpiredRooms= $row['amount'];
    }
}

//booked rooms list
$query_bookedRoomsList = "select 
*
from lib_room r inner join lib_bookings b on r.bookingId = b.bookingId where r.status = 'booked' order by b.room desc
"; 

//expired rooms list
$query_expiredRoomsList = "select 
b.bookingId, b.studentId, min(n.notfType) as notfType, r.room, b.expiry
from lib_room r inner join lib_bookings b on r.bookingId = b.bookingId left outer join lib_notfStatus n on n.bookingId=b.bookingId 
where r.status = 'expired' and ((n.notfType is null)or(n.notfType='-1min')or(n.notfType='10min'))GROUP by b.bookingId order by  b.room ASC"; 
// and ((n.notfType is null)or(n.notfType='-1min')) 

$result_expiredRoomList = $con->query($query_expiredRoomsList); 

//free rooms list
$query_freeRoomsList = "select 
*
from lib_room where status = 'free' order by room desc
"; 
$result_freeRoomList = $con->query($query_freeRoomsList); 

//free rooms list for booking
$query_freeRoomsListBooking = "select 
*
from lib_room where status = 'free' order by room desc
"; 
$result_freeRoomListBooking = $con->query($query_freeRoomsListBooking); 

//waiting queue
$query_bookingQue = "select 
q.id, q.studentId, q.occupants, q.bookingTime, q.status, n.notfType
from lib_bookingQueue q left outer join lib_notfStatus n on n.bookingId=q.id 
where q.status = 'waiting' order by q.id asc"; 
$result_bookingQue = $con->query($query_bookingQue); 




?>
<script>
    var sentNotfStatus = [];
    var sentNotfRoom = [];
</script>
<?

//sent notf status
$query = "SELECT * FROM `lib_notfStatus` n right OUTER join lib_room r on n.bookingId = r.bookingId where r.status!='free' order by r.room desc
"; 
$result = $con->query($query); 
$i = 0;
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        ?>
        <script>
            sentNotfStatus[<?echo $i?>] = "<?echo $row['notfType']?>"
            sentNotfRoom[<?echo $i?>] = "<?echo $row['room']?>"
        </script>
        <?
        $i +=1;
    }
}

?>
  <div class="wrapper">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="assets/img/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo" data-toggle="tooltip" data-placement="right" title="user's name">
        <a href="./" class="simple-text logo-normal">
          <?echo $session_name."'s Panel"?>
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
      <?include("./phpParts/navBar.php")?>
        
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
            <div class="alert alert-primary" role="alert" style="display:none;" id="pageReloadPop">
            Update detected. Page reloading...
        </div>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">store</i>
                  </div>
                  <p class="card-category">Rooms Free</p>
                  <h3 class="card-title"><?echo $nFreeRooms?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                     Number of free discussion rooms
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">content_copy</i>
                  </div>
                  <p class="card-category">Rooms occupied</p>
                  <h3 class="card-title" id="nBookedRooms"><?echo $nBookedRooms?>                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                     Number of rooms occupied
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">info_outline</i>
                  </div>
                  <p class="card-category">Rooms Expired</p>
                  <h3 class="card-title" id="nExpiredRooms"><?echo $nExpiredRooms?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                     Number of rooms expired
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">library_books</i>
                  </div>
                  <p class="card-category">Total bookings</p>
                  <h3 class="card-title"><?echo $nRoomsBookedTillNow?></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                     Number of rooms booked since day 1
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <span class="nav-tabs-title" data-toggle="tooltip" data-placement="right" title="Current status of all rooms">Overview</span>
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <li class="nav-item">
                          <a class="nav-link active" href="#profile" data-toggle="tab">
                            Expired
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#messages" data-toggle="tab">
                            Booked
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#settings" data-toggle="tab">
                            Free
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="profile">
                      <table class="table">
                          <script>
                              var expiryTime = [];
                              var expiryRoom = [];
                              
                              var bookingTime = [];
                              var bookingRoom = [];
                              var bookingBookingId = [];
                          </script>
                        <tbody>
                          <?php
                          $i=0;
                            if ($result_expiredRoomList->num_rows > 0)
                            { 
                                while($row = $result_expiredRoomList->fetch_assoc()) 
                                { 

                                    ?>
                                    <script>expiryTime[<?echo $i?>] = "<?echo $row['expiry']?>"</script>
                                    <script>expiryRoom[<?echo $i?>] = "<?echo $row['room']?>"</script>
                                
                                    <?
                                    
                                     if(true){
                                    echo "<tr>";
                                    echo '<td>';
                                    echo '<label id="expTime'.$row['room'].'" class="form-check-label" >
                                  Calculating
                                </label>';
                                    echo "</td>";
                                    echo "<td>Room ".$row['room']."</td>";
                                    
                                    if(($row['notfType']==null)||($row['notfType']=='10min')){
                                        echo '<td data-toggle="tooltip" data-placement="right" title="send notification"><a href="./dashboard.php?bookingId='.$row['bookingId'].'&notfType=-1min"><button class="btn btn-social btn-just-icon btn-google" style="background-color:green;"><i class="material-icons">notifications</i></button></a></td>';

                                    }
                                    else{
                                        echo '<td><a href="#"><button class="btn btn-social btn-just-icon btn-google" style="background-color:#babab9;"><i class="material-icons">notifications</i></button></a></td>';
                                    }
                                    
                                    echo '<td data-toggle="tooltip" data-placement="right" title="place a flag on the student"><a href="./flagStudent.php?studentId='.$row['studentId'].'"><button class="btn btn-social btn-just-icon btn-google" style="background-color:#e77b2b;"><i class="material-icons">flag</i></button></a></td>';
                                    //echo '<td><a href="./extendTimeRoom.php?room='.$row['room'].'"><button class="btn btn-social btn-just-icon btn-twitter"><i class="material-icons">plus_one</i></button><br></a></td>';
                                    echo '<td data-toggle="tooltip" data-placement="right" title="free room"><a href="?freeroom='.$row['room'].'"><button class="btn btn-social btn-just-icon btn-google" style="background-color:red;"><i class="material-icons">cancel</i></button></a></td>';
                                    
                                    echo "</tr>";
                                    $i +=1;
                                     }
                                     
                                }
                            }
                          ?>
                         
                          <tr>
                            <td>
                              <div class="form-check">
                                <label class="form-check-label">
                                  
                                </label>
                              </div>
                            </td>
                            
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="tab-pane" id="messages">
                      <table class="table">
                        <tbody>
                          <?php
                          $i=0;
                          $result_bookedRoomList = $con->query($query_bookedRoomsList); 
                            if ($result_bookedRoomList->num_rows > 0)
                            { 
                                while($row = $result_bookedRoomList->fetch_assoc()) 
                                { 
                                    ?>
                                    <script>bookingTime[<?echo $i?>] = "<?echo $row['expiry']?>"</script>
                                    <script>bookingRoom[<?echo $i?>] = "<?echo $row['room']?>"</script>
                                    <script>bookingBookingId[<?echo $i?>] = "<?echo $row['bookingId']?>"</script>
                                    <?
                                    date_default_timezone_set("Asia/Karachi");
                                    $currentDateTime = date('Y/m/d H:i:s',$row['expiry']);
                                    $newDateTime = date('h:i A', strtotime($currentDateTime));

                                    echo "<tr>";
                                    echo '<td>';
                                    echo '<label id="bookTime'.$row['room'].'" class="form-check-label" >
                                  '.$newDateTime.'
                                </label>';
                                    echo "</td>";
                                    echo "<td>Room ".$row['room']."</td>";
                                    echo '<td data-toggle="tooltip" data-placement="right" title="place flag on the student"><a href="./flagStudent.php?studentId='.$row['studentId'].'"><button class="btn btn-social btn-just-icon btn-google" style="background-color:#e77b2b;"><i class="material-icons">flag</i></button></a></td>';
                                    //echo '<td><a href="./extendTimeRoom.php?room='.$row['room'].'"><button class="btn btn-social btn-just-icon btn-twitter"><i class="material-icons">plus_one</i></button><br></a></td>';
                                    echo '<td data-toggle="tooltip" data-placement="right" title="swap student card"><a href="./swapCard.php?room='.$row['room'].'"><button class="btn btn-social btn-just-icon btn-twitter"><i class="material-icons">swap_horiz</i></button></a></td>';
                                    echo '<td data-toggle="tooltip" data-placement="right" title="free room"><a href="./freeRoom.php?room='.$row['room'].'"><button class="btn btn-social btn-just-icon btn-google" style="background-color:red;"><i class="material-icons">cancel</i></button></a></td>';
                                    echo "</tr>";
                                    $i+=1;
                                }
                            }
                          ?>
                                            <script>console.log("bookingBookingId"+bookingBookingId);</script>

                          <tr>
                            <td>
                              <div class="form-check">
                                <label class="form-check-label">
                                  
                                </label>
                              </div>
                            </td>

                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="tab-pane" id="settings">
                      <table class="table">
                        <tbody>
                          <?php
                            if ($result_freeRoomList->num_rows > 0)
                            { 
                                while($row = $result_freeRoomList->fetch_assoc()) 
                                { 
                                    echo "<tr>";
                                    echo "<td>";
                                    echo "<div class='form-check'>";
                                    echo '<label class="form-check-label">
                                  ---
                                </label>';
                                    echo "</div>";
                                    echo "</td>";
                                    echo "<td>Room ".$row['room']."</td>";
                                    echo "</tr>";
                                }
                            }
                          ?>
                         
                          <tr>
                            <td>
                              <div class="form-check">
                                <label class="form-check-label">
                                  
                                </label>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12">
                            <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <span class="nav-tabs-title">Booking Panel</span>
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="add students to the queue when all rooms are busy">
                          <a class="nav-link active" href="#bookingQueue" data-toggle="tab">
                            Queue
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#book" data-toggle="tab">
                            Book
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="bookingQueue">
                <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <thead class="text-success">
                      <th>StudentId</th>
                      <th>Occupants</th>
                      <th>Booking Time</th>
                      <th>Action</th>
                    </thead>
                    <tbody>
                      <?
                      if ($result_bookingQue->num_rows > 0)
                            { 
                                while($row = $result_bookingQue->fetch_assoc()) 
                                { 
                                    echo "<tr>";
                                    echo "<td>".$row['studentId']."</td>";
                                    echo "<td>".$row['occupants']."</td>";
                                    echo "<td>".substr($row['bookingTime'],-10)."</td>";
                                    if($row['notfType']==null){//$nFreeRooms>5){
                                        echo '<td data-toggle="tooltip" data-placement="right" title="send notification"><a href="./dashboard.php?bookingId='.$row['id'].'&notfType=bookingQueue"><button class="btn btn-social btn-just-icon btn-google" style="background-color:orange;"><i class="material-icons">notifications</i></button></a></td>';
                                    }
                                    else{
                                        echo '<td data-toggle="tooltip" data-placement="right" title="notification already sent"><a href="#"><button class="btn btn-social btn-just-icon btn-google" style="background-color:#babab9;"><i class="material-icons">notifications</i></button></a></td>';
                                    }
                                    
                                    echo '<td data-toggle="tooltip" data-placement="right" title="remove entry from queue"><a href="./cancelQueueEntry.php?id='.$row['id'].'"><button class="btn btn-social btn-just-icon btn-google" style="background-color:red;"><i class="material-icons">cancel</i></button></a></td>';
                                    echo '<td data-toggle="tooltip" data-placement="right" title="book room for this entry"><a href="./bookRoomFromQueue.php?id='.$row['id'].'"><button class="btn btn-social btn-just-icon btn-google" style="background-color:green;"><i class="material-icons">check_box</i></button></a></td>';

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
                                <div class="form-group col-md-6">
                                  <label for="inputEmail4">Student ID</label>
                                  <input id="studentId" name="studentId" type="text" class="form-control" placeholder="" required>
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="inputEmail4">Number of occupants</label>
                                  <input name="occupants" type="number" class="form-control" placeholder="" required>
                                </div>
                               
                              </div>
                            
                            <button type="submit" class="btn btn-primary">Insert to Queue</button>
                        </form>
                    </td>
                  </tr>
                </div>

                    </div>
                    <div class="tab-pane" id="book">
                      <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <thead class="text-success">
                      <th>Room</th>
                      <th>Capacity</th>
                      <th>Book</th>
                    </thead>
                        <tbody>
                      <?
                      if ($result_freeRoomListBooking->num_rows > 0)
                            { 
                                while($row = $result_freeRoomListBooking->fetch_assoc()) 
                                { 
                                    echo "<tr>";
                                    echo "<td>".$row['room']."</td>";
                                    echo "<td>".$row['capacity']."</td>";
                                    echo '<td data-toggle="tooltip" data-placement="right" title="book room"><a href="./bookRoom.php?room='.$row['room'].'"><button class="btn btn-success btn-sm">Book!<div class="ripple-container"></div></button></a></td>';
                                    echo "</tr>";
                                }
                            }
                      ?>
                    
                    </tbody>
                      </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
            <?include("./phpParts/footer.php")?>

        <script>
            //changing clock
            var url = new URL(window.location.href) ;
            console.log("sentNotfStatus", sentNotfStatus);
            console.log("sentNotfRoom", sentNotfRoom);
            
            //get url parameters
             var bookingId   = null;
            var notfType = null;

            try {
                bookingId   = url.searchParams.get("bookingId");
                notfType = url.searchParams.get("notfType");
                queId = url.searchParams.get("queId");
            }
            catch(err) {
              console.log("no parameter");
            }
                
                    
            function startTime() {
                //expiry
                for (var i=0; i<expiryTime.length; i++){
                    var timeInt =  Math.trunc(new Date().getTime()/1000) - expiryTime[i];
                    
                    d = Number(timeInt);
                    var h = Math.floor(d / 3600);
                    var m = Math.floor(d % 3600 / 60);
                    var s = Math.floor(d % 3600 % 60);
                
                    var hDisplay = h > 0 ? h + (h == 1 ? " hour, " : " hours,") : "";
                    var mDisplay = m > 0 ? m + (m == 1 ? " minute, " : " minutes,") : "";
                    var sDisplay = s > 0 ? s + (s == 1 ? " second, " : " seconds ") : "";
                    timeInt =  hDisplay + mDisplay+sDisplay; 
    
                    document.getElementById('expTime'+expiryRoom[i]).innerHTML =timeInt+" ago."
                }
                
                //booking
                for (var i=0; i<bookingTime.length; i++){
                    var timeInt =  bookingTime[i] - Math.trunc(new Date().getTime()/1000);
                    d = Number(timeInt);
                    var h = Math.floor(d / 3600);
                    var m = Math.floor(d % 3600 / 60);
                    var s = Math.floor(d % 3600 % 60);
                
                    var hDisplay = h > 0 ? h + (h == 1 ? " hour, " : " hours,") : "";
                    var mDisplay = m > 0 ? m + (m == 1 ? " minute, " : " minutes,") : "";
                    var sDisplay = s > 0 ? s + (s == 1 ? " second, " : " seconds ") : "";
                    timeInt =  hDisplay + mDisplay+sDisplay; 
                    
                    //console.log("parameter", bookingId, bookingBookingId[i], notfType);
                    /**
                    //5 min notification for queued bookings
                    if((d<300) && (bookingId!=bookingBookingId[i]) && (notfType!='5minQueued') ){
                        
                        //check if notification sent
                        var haveSent10minNotf = false;
                        for (var j=0; j<sentNotfStatus.length; j++){
                            console.log("-----", sentNotfStatus[j], '10min', sentNotfRoom[j], bookingRoom[i])
                            if(sentNotfStatus[j]==='10min' &&  sentNotfRoom[j]===bookingRoom[i])
                            haveSent10minNotf = true;
                            
                        }
                        
                        if(haveSent10minNotf==false){
                            console.log("searchParams", queId, notfType);
                            console.log("send 10 min notification to", bookingBookingId[i]);
                            window.open("./dashboard.php?bookingId="+bookingBookingId[i]+"&notfType=10min","_self")
                        }
                        
                    }
                    **/
                    
                    //10 min notification
                    if((d<600) && (bookingId!=bookingBookingId[i]) && (notfType!='10min') ){
                        
                        //check if notification sent
                        var haveSent10minNotf = false;
                        for (var j=0; j<sentNotfStatus.length; j++){
                            console.log("-----", sentNotfStatus[j], '10min', sentNotfRoom[j], bookingRoom[i])
                            if(sentNotfStatus[j]==='10min' &&  sentNotfRoom[j]===bookingRoom[i])
                            haveSent10minNotf = true;
                            
                        }
                        
                        if(haveSent10minNotf==false){
                            console.log("searchParams", bookingId, notfType);
                            console.log("send 10 min notification to", bookingBookingId[i]);
                            window.open("./dashboard.php?bookingId="+bookingBookingId[i]+"&notfType=10min","_self")
                        }
                        
                    }
                    //expiry notification
                    //console.log("d", d)
                    if((d<-5) && (((bookingId!=bookingBookingId[i]) && (notfType!='-1min')) || ((bookingId==bookingBookingId[i]) && (notfType=='10min')))){
                        console.log("yes1")
                        //check if notification sent
                        var haveSent1minNotf = false;
                        for (var j=0; j<sentNotfStatus.length; j++){
                            console.log("-----", sentNotfStatus[j], '-1min', sentNotfRoom[j], bookingRoom[i])
                            if(sentNotfStatus[j]==='-1min' &&  sentNotfRoom[j]===bookingRoom[i])
                            haveSent1minNotf = true;
                            
                        }
                        
                        if(haveSent1minNotf==false){
                            console.log("yes2")
                            console.log("searchParams", bookingId, notfType);
                            console.log("send -1 min notification to", bookingBookingId[i]);
                            window.open("./dashboard.php?bookingId="+bookingBookingId[i]+"&notfType=-1min","_self")
                        }
                        
                    }
    
                    //document.getElementById('bookTime'+bookingRoom[i]).innerHTML =timeInt+" to expire."
                }
                var t = setTimeout(startTime, 500);
                }
   

                  </script>
                  <script>
                      if(notfSent=="yes"){
                          window.open("mailto:"+"<?echo $email?>"+'?cc=&subject='+"<?echo $email_subject?>"+'&body='+"<?echo $email_body?>", '_self');

                            window.open(
                              "https://web.whatsapp.com/send?phone=<?echo $mobile?>&text=<?echo $email_body?>",
                              '_blank' // <- This is what makes it open in a new window.
                            );
                      }
                  </script>
</body>

</html>
