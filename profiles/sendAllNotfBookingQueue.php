<?
//include_once("../database.php");
//$studentId = "sa02908";

//get info
$query = "SELECT * from lib_students where cardnumber='$studentId'"; 
$result = $con->query($query); 
if ($result->num_rows > 0)
{ 
    while($row = $result->fetch_assoc()) 
    { 
        $studentId = $row['studentId'];
        $email = $row['email'];
        $mobile = $row['mobile'];
        $name = $row['firstname'];
    }
}

if($notfType=="bookingQueue"){
$email_subject = "Room free for booking." ;
$email_body = "Dear ".$name.", A discussion room is about to get free in few minutes. Kindly, come to the counter to complete your booking." ;
}


//notf sent
$sql="INSERT INTO `lib_notfStatus`(`bookingId`, `notfType`) VALUES ('$bookingId', '$notfType')";
if(!mysqli_query($con,$sql))
{
echo"can not";
}


?>

<script>
    Swal.fire({
      title: '<?echo $email_subject?>',
      html: 
          "<pre style='background-color:#f0e7f3; white-space:pre-wrap;'><code><?echo $email?></code></pre>"
          +"<pre style='background-color:#f0e7f3; white-space:pre-wrap;'><code><?echo $email_body?></code></pre>",
      showConfirmButton: true,
      confirmButtonText:    'Send Whatsapp!',
    }).then(function() {
// Redirect the user
window.open(
  "https://web.whatsapp.com/send?phone=<?echo $mobile?>&text=<?echo $email_body?>",
  '_blank' // <- This is what makes it open in a new window.
);
console.log('The Ok Button was clicked.');
});
</script>


<?
//send push notf 

if($notfType=="bookingQueue"){
$notfBody ="Dear ".$name.", A discussion room is about to get free in few minutes.. Kindly, come to the counter to complete your booking."  ;

}

$token = array();
//get token
$query = "SELECT * from lib_pushTokens where studentId='$studentId'"; 
    $result = $con->query($query); 
    if ($result->num_rows > 0)
    { 
        while($row = $result->fetch_assoc()) 
        { 
            array_push($token, $row['token']);
        }
    }
    
    echo count($token);

//include("https://library.anomoz.com/profiles/notf_sender.php");
//include("./notf_sender.php");

?>










<?php
//push notifications
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

if($single==false){
    
    for($i=0;$i<count($token);$i++){
        ?>
    <script>console.log("yes" )</script>
    <?
        define( 'API_ACCESS_KEY', 'AAAAUjJH48c:APA91bEatEWDjhZvtoi_4KaPoyutmCXq4L4gW4WyAnWRstfY0-ylcNSgAe0M75j3Edy4JZAfT9auEWRAJWll2ZqckW2IRFgEX-xrm8gdorWV3n21rcmvMVQzy9zO3HOiJd3sc0kBCmlN' );

        $data = array("to" => $token[$i],
                      "notification" => array( "title" => "HU - Library", "body" => $notfBody ,"icon" => "./p1.jpg", "click_action" => "https://library.anomoz.com/checkStatus.php?room=".$room));                                                                    
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

?>
