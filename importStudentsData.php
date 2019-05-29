<?php
$host='localhost';
$username='anomozco_nooruser';
$user_pass='rWg#M$vFYk]+';
$database_in_use='anomozco_noor';

$conn = mysqli_connect($host,$username,$user_pass,$database_in_use);
if (!$conn)
{
    echo"not connected";
}
if (!mysqli_select_db($conn,$database_in_use))
{
    echo"database not selected";
}

require_once('vendor/php-excel-reader/excel_reader2.php');
require_once('vendor/SpreadsheetReader.php');

include_once("global.php");

if ($logged==0){ 
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}

if (isset($_POST["import"]))
{
    
    
  $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = 'uploads/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
                $cardnumber = "";
                if(isset($Row[0])) {
                    $cardnumber = mysqli_real_escape_string($conn,$Row[0]);
                }
                
                $surname = "";
                if(isset($Row[1])) {
                    $surname = mysqli_real_escape_string($conn,$Row[1]);
                }
                
                $firstname="";
                if(isset($Row[2])) {
                    $firstname = mysqli_real_escape_string($conn,$Row[2]);
                }
                
                $email = "";
                if(isset($Row[3])) {
                    $email = mysqli_real_escape_string($conn,$Row[3]);
                }
                
                $mobile="";
                if(isset($Row[4])) {
                    $mobile = mysqli_real_escape_string($conn,$Row[4]);
                }
                
                $categorycode = "";
                if(isset($Row[5])) {
                    $categorycode = mysqli_real_escape_string($conn,$Row[5]);
                }
                
                $sort1="";
                if(isset($Row[6])) {
                    $sort1 = mysqli_real_escape_string($conn,$Row[6]);
                }
                
                $sort2 = "";
                if(isset($Row[7])) {
                    $sort2 = mysqli_real_escape_string($conn,$Row[7]);
                }
                
                if (!empty($cardnumber) || !empty($firstname)) {
                    //echo ".$cardnumber.",".$surname.",".$firstname.",".$email.",".$mobile.",".$categorycode.",".$sort1.",".$sort2.","<br>";
                    //$query = "insert into lib_students('cardnumber','surname','firstname','email','mobile','categorycode','sort1','sort2') values('".$cardnumber."','".$surname."','".$firstname."','".$email."','".$mobile."','".$categorycode."','".$sort1."','".$sort2."')";
                    $query = "insert into lib_students(`cardnumber`,`surname`,`firstname`,`email`,`mobile`,`categorycode`,`sort1`,`sort2`) values('$cardnumber','$surname','$firstname','$email','$mobile','$categorycode','$sort1','$sort2')";

                    $result = mysqli_query($conn, $query);
                
                    if (! empty($result)) {
                        $type = "success";
                        $message = "Excel Data Imported into the Database";
                    } else {
                        $type = "error";
                        $message = "Problem in Importing Excel Data";
                    }
                }
                else{
                    //echo ".$cardnumber.",".$surname.",".$firstname.",".$email.",".$mobile.",".$categorycode.",".$sort1.",".$sort2.","<br>";

                }
             }
        
         }
  }
  else
  { 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
  }
}
?>

<!DOCTYPE html>
<html>    
<head>
<style>    
body {
	font-family: Arial;
	width: 550px;
}

.outer-container {
	background: #F0F0F0;
	border: #e0dfdf 1px solid;
	padding: 40px 20px;
	border-radius: 2px;
}

.btn-submit {
	background: #333;
	border: #1d1d1d 1px solid;
    border-radius: 2px;
	color: #f0f0f0;
	cursor: pointer;
    padding: 5px 20px;
    font-size:0.9em;
}

.tutorial-table {
    margin-top: 40px;
    font-size: 0.8em;
	border-collapse: collapse;
	width: 100%;
}

.tutorial-table th {
    background: #f0f0f0;
    border-bottom: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

.tutorial-table td {
    background: #FFF;
	border-bottom: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

#response {
    padding: 10px;
    margin-top: 10px;
    border-radius: 2px;
    display:none;
}

.success {
    background: #c7efd9;
    border: #bbe2cd 1px solid;
}

.error {
    background: #fbcfcf;
    border: #f3c6c7 1px solid;
}

div#response.display-block {
    display: block;
}
</style>
</head>

<body>
    <h2>Import Students Data</h2>
    
    <div class="outer-container">
        <form action="" method="post"
            name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <div>
                <label>Choose Excel
                    File</label> <input type="file" name="file"
                    id="file" accept=".xls,.xlsx">
                <button type="submit" id="submit" name="import"
                    class="btn-submit">Import</button>
        
            </div>
        
        </form>
        
    </div>
    <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
    
         
<?php
    $sqlSelect = "SELECT * FROM lib_students";
    $result = mysqli_query($conn, $sqlSelect);

if (mysqli_num_rows($result) > 0)
{
?>
        
    <table class='tutorial-table'>
        <thead>
            <tr>
                <th>cardnumber</th>
                <th>surname</th>
                <th>firstname</th>
                <th>email</th>
                <th>mobile</th>
                <th>categorycode</th>
                <th>sort1</th>
                <th>sort2</th>
            </tr>
        </thead>
<?php
    while ($row = mysqli_fetch_array($result)) {
?>                  
        <tbody>
        <tr>
            <td><?php  echo $row['cardnumber']; ?></td>
            <td><?php  echo $row['surname']; ?></td>
            <td><?php  echo $row['firstname']; ?></td>
            <td><?php  echo $row['email']; ?></td>
            <td><?php  echo $row['mobile']; ?></td>
            <td><?php  echo $row['categorycode']; ?></td>
            <td><?php  echo $row['sort1']; ?></td>
            <td><?php  echo $row['sort2']; ?></td>
        </tr>
<?php
    }
?>
        </tbody>
    </table>
<?php 
} 
?>

</body>
</html>