<?include_once("global.php");?>
<?

$noBooking = true;

if(isset($_GET["room"])){
    $noBooking = false;

    $room = $_GET["room"]; 
$query = "select 
	b.studentId, b.dateTimeTaken, b.expiry
    from lib_bookings b inner join lib_room r on b.bookingId = r.bookingId where r.room = '$room' and r.status!='free'
"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        $studentId= $row['studentId'];
        $dateTimeTaken= $row['dateTimeTaken'];
        $expiry= $row['expiry'];
        ?>
        <script>var expiryTime = <?echo $expiry?></script>
        <?
        
        //page visit

        //check if entry
        $query = "select * from lib_pageVisits where studentId='$studentId'"; 
        $result = $con->query($query); 
        if ($result->num_rows > 0)
        { 
            while($row = $result->fetch_assoc()) 
            { 
                //update by 1
                $sql="update lib_pageVisits set count=count+1 where studentId='$studentId'";
                if(!mysqli_query($con,$sql))
                {
                echo"can not";
                }
            }
        }
        else{
        	//create entry
        	$sql="insert into lib_pageVisits(studentId, count) values ('$studentId', 1)";
            if(!mysqli_query($con,$sql))
            {
            echo"can not";
            }
        }
    }
}
else{
    $noBooking = true;
}
date_default_timezone_set("Asia/Karachi");
$dateTimeTaken = substr($dateTimeTaken, 11, 5).substr($dateTimeTaken, -2);
$expiry = date("d-m-Y:h:i:sa", $expiry);
$expiry = substr($expiry, 11, 5).substr($expiry, -2);
//$expiry = strtotime($dateTimeTaken);
}

//number of rooms booked uptil now
$query = "select 
	*
from lib_bookings where studentId='$studentId' order by id desc
"; 
$result = $con->query($query); 




?>
<!DOCTYPE html>
<html lang="en">

<?php include("./phpParts/head.php")?>

<body class="" onload="startTime()">
  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="assets/img/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
     
      
    </div>
    <div class="main-panel">
      <!-- Navbar -->
 
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success" role="alert" id="notfSuccess" style="display:none;">
                  <b>Notification turned on!</b> <span id="studentIdBox"></span>
                </div>
                
                <?php
                $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
                ?>
                
                <script>
                    document.getElementById("studentIdBox").innerHTML ="<p style='font-size: 13px;'>All notifications for "+localStorage.getItem("studentId")+" will be sent to you. To change the ID associated, <a href='./changeNotfId.php?retUrl=<?echo $actual_link?>' style='color: #801b00;'>click here.</a><p>"//localStorage.getItem("studentId");

                    
                </script>
              <div class="card" align="center">
                <div class="card-header card-header-primary">

                  <h4 class="card-title ">Room - <?echo $room?></h4>
                </div>
                <div class="card-body" align="center">
                  <div class="table-responsive" align="center">
                <? if($noBooking==false){?>

                    <div style="margin:12px; " align="center" class="text-center">
                        <h4>Booked by: <?echo $studentId?></h4>
                        <h4>Booking time: <?echo $dateTimeTaken?></h4>
                        <h4>Expires at: <?echo $expiry?></h4>

                      <p id="bookTimeLeft">time left</p>
                        
                        <button id="onNotfBtn" onclick="yes()" class="btn btn-primary">Keep me notified!</button>

                    </div>
                  <?
                  
                  }else{
                      echo"No booking found.";
                  }
                  
                  ?>
                                    </div>

                </div>
              </div>
              
              <? if($noBooking==false){?>
              
                                          <div class="card">
                <div class="card-header card-header-primary">

                  <h4 class="card-title ">Past Bookings of <?echo $studentId?></h4>
                  <p class="card-category">Find all the past bookings here</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <th class="text-primary">
                          Room Number
                        </th>
                        <th>
                          Date
                        </th>
                        <th>
                          Time
                        </th>
                        <th>
                          Occupants
                        </th>
                      </thead>
                      <tbody>

                        <?php
                        if ($result->num_rows > 0)
                        { 
                            
                            while($row = $result->fetch_assoc()) 
                            { 
                                echo"<tr>";
                                echo "<td>".$row['room']."</td>";
                                echo "<td>".substr($row['dateTimeTaken'],0,10)."</td>";
                                echo "<td>".substr($row['dateTimeTaken'],-10)."</td>";
                                echo "<td>".$row['nStudents']."</td>";
                                echo "</tr>";

                            }
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <?}?>

              
              
            </div>
          </div>
        </div>
      </div>
      <form action="" id="tokenForm" method="post" style="display:none;">
          <input id="tokenValue" name="token">
          <input id="studentId" name="studentId">
      </form>
      
   <?php include("./phpParts/footer.php")?>
   <?php include("./profiles/push_button.php")?>

<script>
            //changing clock
            function startTime() {
                //expiry
                var timeInt =  expiryTime- Math.trunc(new Date().getTime()/1000) ;
                                    //console.log("expiryTime", timeInt)
                    d = Number(timeInt);
                    var expired = false;
                    if (d>=0){
                        d=d
                        expired = false
                    }
                    else{
                         d = -(d);
                         expired = true
                    }
                    var h = Math.floor(d / 3600);
                    var m = Math.floor(d % 3600 / 60);
                    var s = Math.floor(d % 3600 % 60);
                
                    var hDisplay = h > 0 ? h + (h == 1 ? " hour, " : " hours,") : " ";
                    var mDisplay = m > 0 ? m + (m == 1 ? " minute, " : " minutes ") : " ";
                    timeInt =  hDisplay + mDisplay; 
                    
                    if (expired==false){
                        document.getElementById('bookTimeLeft').innerHTML =timeInt+" to expire."

                    }
                    else{
                        document.getElementById('bookTimeLeft').style.color ="red"
                         document.getElementById('bookTimeLeft').innerHTML ="Expired "+timeInt+" ago."
                    }
                
                var t = setTimeout(startTime, 500);
                }
   
   
   
   //turn button off
   console.log("token expiry:", (new Date().getTime() / 1000), Number(localStorage.getItem("tokenExpiry")))
   
   if(((new Date().getTime() / 1000)<Number(localStorage.getItem("tokenExpiry")))&&(localStorage.getItem("tokenExpiry")!=null)){
       document.getElementById("onNotfBtn").style.display="none";
       document.getElementById("notfSuccess").style.display="block";
       console.log("hide buttton");
   }
   else{
       document.getElementById("onNotfBtn").style.display="block";
       document.getElementById("notfSuccess").style.display="none";
       console.log("show buttton");
   }


document.getElementById("studentId").value = "<?echo $studentId?>";


</script>
</body>
<?
//enter token
if(isset($_POST["token"])){
 $token= $_POST["token"];
 $studentId= $_POST["studentId"];
 ?>
 <script>
    document.getElementById("notfSuccess").style.display='block';
    localStorage.setItem("studentId", "<?echo $studentId?>");
 </script>
 <?
    //check if entry
        $query = "select * from lib_pushTokens where studentId='$studentId' and token='$token'"; 
        $result = $con->query($query); 
        if ($result->num_rows > 0)
        { 
            
        }
        else{
        	//create entry
        	$sql="insert into lib_pushTokens(studentId, token) values ('$studentId', '$token')";
            if(!mysqli_query($con,$sql))
            {
            echo"can not";
            }
        }
 	
}
?>
</html>
