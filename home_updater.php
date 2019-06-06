<?
include_once("global.php");

$roomsAr = array();
$roomsStatusAr = array();
$bookingQueueAr = array();

//booked rooms
$query = "select * from lib_room order by id asc"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
       array_push($roomsAr,$row['room']);
       array_push($roomsStatusAr,$row['status']);
    }
}

//waiting queue
$query_bookingQue = "select 
*
from lib_bookingQueue where status='waiting' order by id asc
"; 
$result_bookingQue = $con->query($query_bookingQue); 
if ($result_bookingQue->num_rows > 0)
{ 
    while($row = $result_bookingQue->fetch_assoc()) 
    { 
       array_push($bookingQueueAr,$row['studentId']);
    }
}



//$myObj->roomsAr = $roomsAr;
$myObj->roomsStatusAr = $roomsStatusAr;
$myObj->bookingQueueAr = $bookingQueueAr;

$myJSON = json_encode($myObj);

echo $myJSON;
?>