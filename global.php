<?
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 100);
ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 100);
ini_set('session.save_path', '/tmp');

session_start();

//maybe you want to precise the save path as well
include_once("database.php");

//maybe you want to precise the save path as well
//cheaking
if (isset($_SESSION['email'])&&isset($_SESSION['password']))
{
    $session_password = $_SESSION['password'];
    $session_email =  $_SESSION['email'];
    $query = "SELECT *  FROM yp_vendors WHERE email='$session_email' AND password='$session_password'";
}
$result = $con->query($query);
if ($result->num_rows > 0){
    $logged=1;
}
else
{
        $logged=0;
}

$g_rooms = array("202", "203", "204",  "205",  "206",  "207",  "208");
$g_roomCapacity = array("3", "2", "3",  "5",  "7",  "2",  "4");

?>