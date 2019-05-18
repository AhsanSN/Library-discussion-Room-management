<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);

echo dirname($_SERVER['DOCUMENT_ROOT']);
set_include_path("." . PATH_SEPARATOR . ($UserDir = dirname($_SERVER['DOCUMENT_ROOT'])) . "/pear/php" . PATH_SEPARATOR . get_include_path());
require_once "Mail.php";

$room = "202";

$host = "mail.anomoz.com";
$username = "discussion_rooms.library@anomoz.com";
$password = "rqkhbu6t";
$port = "587";
$to = $studentId."@st.habib.edu.pk";

echo $to;
//$to = "snahmed1998@gmail.com";

$email_from = "Discussion Room - Library <discussion_rooms.library@anomoz.com>";
$email_address = "discussion_rooms.library@anomoz.com";


$headers = array (
    'From' => $email_from,
    'To' => $to, 'Subject' => $email_subject, 
    'Reply-To' => $email_address
    );
$smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => true, 'username' => $username, 'password' => $password));
$mail = $smtp->send($to, $headers, $email_body);


if (PEAR::isError($mail)) {
echo("<p>" . $mail->getMessage() . "</p>");
} else {
echo("<p>Message successfully sent!</p>");
}
?>
