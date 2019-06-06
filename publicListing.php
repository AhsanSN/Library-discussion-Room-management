<?include_once("global.php");?>
<?
if ($logged==0){ 
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}

?>
<script>
    var roomsStatus = []
    var bookingQueue = []
</script>
<?

//number of rooms booked uptil now
$query = "select 
	r.room, r.capacity, b.expiry, r.status
from lib_room r inner join lib_bookings b on r.bookingId = b.bookingId order by r.id asc
"; 
$result = $con->query($query); 

//waiting queue
$query_bookingQue = "select 
*
from lib_bookingQueue where status='waiting' order by id asc
"; 
$result_bookingQue = $con->query($query_bookingQue); 



?>
<!DOCTYPE html>
<html lang="en">
<?include("./phpParts/head.php")?>

<body class="">
  <div class="wrapper ">
          <div class="sidebar" data-color="purple" data-background-color="white" data-image="assets/img/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo">
        <a class="simple-text logo-normal">
          Booking Queue
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
            <?
            $i = 0;
            if ($result_bookingQue->num_rows > 0)
            { 
                while($row = $result_bookingQue->fetch_assoc()) 
                { 
                    ?>
                                <script>
                                    bookingQueue[<?echo $i?>] = "<?echo $row['studentId']?>";
                                </script>
                                <?
                                $i+=1;
                    echo '<li class="nav-item ">
            <a class="nav-link">
              <p>'.$row['id'].') St. Id: '.$row['studentId']." - Occupants".": ".$row['occupants'].'</p>
            </a>
          </li>';
                }
                
            }
            ?>
        </ul>
      </div>
    </div>

    <div class="main-panel" >
           <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
        </div>
      </nav>

      <!-- End Navbar -->
      <div class="content" style="margin-top:0px;">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">

                  <h4 class="card-title ">Rooms Status</h4>
                  <p class="card-category">Check all rooms status in realtime.</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <th class="text-primary">
                          Room Number
                        </th>
                        <th>
                          Capacity
                        </th>
                        <th>
                          Status
                        </th>
                        <th>
                          Booking Till
                        </th>
                      </thead>
                      <tbody>

                        <?php
                        $i = 0;
                        if ($result->num_rows > 0)
                        { 
                            
                            while($row = $result->fetch_assoc()) 
                            { 
                                ?>
                                <script>
                                    roomsStatus[<?echo $i?>] = "<?echo $row['status']?>";
                                </script>
                                <?
                                $i+=1;
                                date_default_timezone_set("Asia/Karachi");
                                $currentDateTime = date('Y/m/d H:i:s',$row['expiry']);
                                $newDateTime = date('h:i A', strtotime($currentDateTime));
                                echo"<tr>";
                                echo "<td>".$row['room']."</td>";
                                echo "<td>".$row['capacity']."</td>";
                                if($row['status']=='booked'){
                                    echo '<td><button class="btn btn-success btn-sm" style="background-color: red; width: 100px;">BOOKED<div class="ripple-container"></div></button></td>';
                                    echo "<td>".$newDateTime."</td>";
                                }
                                if($row['status']=='free'){
                                    echo '<td><button class="btn btn-success btn-sm" style="background-color: green; width: 100px;">FREE<div class="ripple-container"></div></button></td>';
                                    echo "<td>--</td>";
                                    
                                }
                                if($row['status']=='expired'){
                                    echo '<td><button class="btn btn-success btn-sm" style="background-color: #d87e3c; width: 100px;">expired<div class="ripple-container"></div></button></td>';
                                    echo "<td>--</td>";
                                    
                                }
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
<?include("./phpParts/footer.php")?>

<div class="item"></div>
<script>

function arraysEqual(arr1, arr2) {
    for(var i = arr1.length; i--;) {
        if(arr1[i] !== arr2[i])
            return false;
    }

    return true;
}

function sleep(delay) {
        var start = new Date().getTime();
        while (new Date().getTime() < start + delay);
      }

$(".item").each(function() {
$this = $(this);
$.ajaxSetup({cache:false});
function timeLeft() {
$.ajax({
  type: "POST",
  url: "home_updater.php",
  dataType: "html",
  success: function(result) {
    $this.html(result);
    timeLeft();
    if( !arraysEqual($.parseJSON(result).roomsStatusAr, roomsStatus) || !arraysEqual($.parseJSON(result).bookingQueueAr, bookingQueue) ){
        console.log("result", $.parseJSON(result).roomsStatusAr, roomsStatus)
        window.open("./publicListing.php","_self")
    }
    sleep(1000);
    console.log("result", $.parseJSON(result).roomsStatusAr, roomsStatus)

  }
});
}
timeLeft();
});
</script>

</body>

</html>
