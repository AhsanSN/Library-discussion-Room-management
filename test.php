<?

$expiredRooms_notf = array();

array_push($expiredRooms_notf,strval(202));
array_push($expiredRooms_notf,strval(203));
array_push($expiredRooms_notf,strval(204));
array_push($expiredRooms_notf,strval(205));
array_push($expiredRooms_notf,strval(206));

if (!in_array(strval(207), $expiredRooms_notf)){
    echo"yes";
}

echo print_r($expiredRooms_notf)
?>