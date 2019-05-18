<?
include_once("global.php");

$roomsAr = array();
$roomsStatusAr = array();

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

//$myObj->roomsAr = $roomsAr;
$myObj->roomsStatusAr = $roomsStatusAr;

$myJSON = json_encode($myObj);

echo $myJSON;
?>