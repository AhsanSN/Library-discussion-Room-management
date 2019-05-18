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
</script>
<?

//number of rooms booked uptil now
$query = "select 
	*
from lib_room order by id asc
"; 
$result = $con->query($query); 

?>
<!DOCTYPE html>
<html lang="en">
<?include("./phpParts/head.php")?>

<body class="">
  <div class="wrapper ">
    <div class="main-panel" style="width:100%">
     
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
                                echo"<tr>";
                                echo "<td>".$row['room']."</td>";
                                echo "<td>".$row['capacity']."</td>";
                                if($row['status']=='booked'){
                                    echo '<td><button class="btn btn-success btn-sm" style="background-color: red; width: 100px;">BOOKED<div class="ripple-container"></div></button></td>';
                                }
                                if($row['status']=='free'){
                                    echo '<td><button class="btn btn-success btn-sm" style="background-color: green; width: 100px;">FREE<div class="ripple-container"></div></button></td>';
                                }
                                if($row['status']=='expired'){
                                    echo '<td><button class="btn btn-success btn-sm" style="background-color: #d87e3c; width: 100px;">expired<div class="ripple-container"></div></button></td>';
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
    if( !arraysEqual($.parseJSON(result).roomsStatusAr, roomsStatus)){
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
