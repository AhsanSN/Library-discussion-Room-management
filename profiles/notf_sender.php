<?php
//client's token. (key)
$single= true;
if ($_GET['key'])
{
    $key = $_GET['key'];
    $single = true;
}
else{
    $key = $token;
    $single = false;
}
// Server key from Firebase Console

?>
    <script>console.log("hereksajdkjasbdkjabsdjkbjkasdbjkbaskjdbkdb" )</script>
    <?
    //echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
if($single==false){
    
    for($i=0;$i<count($token);$i++){
        ?>
    <script>console.log("yes" )</script>
    <?
        define( 'API_ACCESS_KEY', 'AAAAUjJH48c:APA91bEatEWDjhZvtoi_4KaPoyutmCXq4L4gW4WyAnWRstfY0-ylcNSgAe0M75j3Edy4JZAfT9auEWRAJWll2ZqckW2IRFgEX-xrm8gdorWV3n21rcmvMVQzy9zO3HOiJd3sc0kBCmlN' );

        $data = array("to" => $token[$i],
                      "notification" => array( "title" => "HU - Library", "body" => $notfBody ,"icon" => "../p1.jpg", "click_action" => "https://library.anomoz.com/checkStatus.php?room=".$room));                                                                    
        $data_string = json_encode($data); 
        //echo "The Json Data : ".$data_string; 
        $headers = array
        (
             'Authorization: key=' . API_ACCESS_KEY, 
             'Content-Type: application/json'
        );                                                                                 
        $ch = curl_init();  
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );                                                                  
        curl_setopt( $ch,CURLOPT_POST, true );  
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, $data_string);                                                                  
        $result = curl_exec($ch);
        curl_close ($ch);
        //echo "<p>&nbsp;</p>";
        //echo "The Result : ".$result;
    }
}
else{
            define( 'API_ACCESS_KEY', 'AAAAUjJH48c:APA91bEatEWDjhZvtoi_4KaPoyutmCXq4L4gW4WyAnWRstfY0-ylcNSgAe0M75j3Edy4JZAfT9auEWRAJWll2ZqckW2IRFgEX-xrm8gdorWV3n21rcmvMVQzy9zO3HOiJd3sc0kBCmlN' );

    $data = array("to" => $key,
                      "notification" => array( "title" => "Anomoz", "body" => "A place for anonymous chatting.","icon" => "../p1.jpg", "click_action" => "https://library.anomoz.com/checkStatus.php?room=".$room));                                                                    
        $data_string = json_encode($data); 
        echo "The Json Data : ".$data_string; 
        $headers = array
        (
             'Authorization: key=' . API_ACCESS_KEY, 
             'Content-Type: application/json'
        );                                                                                 
        $ch = curl_init();  
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );                                                                  
        curl_setopt( $ch,CURLOPT_POST, true );  
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, $data_string);                                                                  
        $result = curl_exec($ch);
        curl_close ($ch);
        echo "<p>&nbsp;</p>";
        echo "The Result : ".$result;
}
?>