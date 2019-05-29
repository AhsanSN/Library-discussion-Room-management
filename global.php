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
        $query = "SELECT *  FROM lib_users WHERE email='$session_email' AND password='$session_password'";
}
$result = $con->query($query);
if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()) 
    {
    $logged=1;
    $session_role = $row['role'];
    $session_name = $row['name'];
    
    /**
    ?>
    <script>console.log("$session_role<?echo $session_role ?>")</script>
    <?
    **/
    }
    
}
else
{
        $logged=0;
}
?>