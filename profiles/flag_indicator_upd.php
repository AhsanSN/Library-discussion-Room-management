<?
include_once("global.php");


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
        }
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
from lib_room where status = 'booked'
"; 

//expired rooms list
$query_expiredRoomsList = "select 
*
from lib_room where status = 'expired'
"; 
$result_expiredRoomList = $con->query($query_expiredRoomsList); 

//free rooms list
$query_freeRoomsList = "select 
*
from lib_room where status = 'free'
"; 
$result_freeRoomList = $con->query($query_freeRoomsList); 

//free rooms list for booking
$query_freeRoomsListBooking = "select 
*
from lib_room where status = 'free'
"; 
$result_freeRoomListBooking = $con->query($query_freeRoomsListBooking); 


$myObj->nBookedRooms = $nBookedRooms;
$myObj->nExpiredRooms = $nExpiredRooms;

$myJSON = json_encode($myObj);

echo $myJSON;
echo"asdadssd";
?>