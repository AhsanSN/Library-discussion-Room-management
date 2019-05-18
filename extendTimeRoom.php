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
if(isset($_GET["room"])){
    $room = $_GET["room"]; 

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
                $expiry = time()+ 3600*(1);

    $sql="update lib_bookings set status='booked',expiry='$expiry' where room='$room' and bookingId = '$bookingId'";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not 1";
        }
        
        $sql="update lib_room set status='booked' where room='$room'";
    
        if(!mysqli_query($con,$sql))
        {
        echo"can not 2";
        }
        
        ?>
    <script type="text/javascript">
            window.location = "./dashboard.php";
        </script>
    <?
        
}}


?>
<html>
</html>