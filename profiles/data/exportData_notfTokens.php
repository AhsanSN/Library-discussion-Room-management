<?php
class DBController {
	private $host = "localhost";
	private $user = "anomozco_nooruser";
	private $password = 'rWg#M$vFYk]+';
	private $database = "anomozco_noor";
	private $conn;
	
        function __construct() {
        $this->conn = $this->connectDB();
	}	
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}
        function runQuery($query) {
                $result = mysqli_query($this->conn,$query);
                while($row=mysqli_fetch_assoc($result)) {
                $resultset[] = $row;
                }		
                if(!empty($resultset))
                return $resultset;
	}
}

$db_handle = new DBController();
$productResult = $db_handle->runQuery("select * from lib_pushTokens");

?>

<style>
body {
    font-size: 0.95em;
    font-family: arial;
    color: #212121;
}
th {
    background: #E6E6E6;
    border-bottom: 1px solid #000000;
}
#table-container {
    width: 850px;
    margin: 50px auto;
}
table#tab {
    border-collapse: collapse;
    width: 100%;
}
table#tab th, table#tab td {
    border: 1px solid #E0E0E0;
    padding: 8px 15px;
    text-align: left;
    font-size: 0.95em;
}
.btn {
    padding: 8px 4px 8px 1px;
}
#btnExport {
    padding: 10px 40px;
    background: #499a49;
    border: #499249 1px solid;
    color: #ffffff;
    font-size: 0.9em;
    cursor: pointer;
}
</style>
<h2 style="text-align:center;">Notification Tokens Data</h2>

<div id="table-container">
    <div class="btn">
        <button onclick="exportTableToExcel('tab', 'HULib-notificationTokens')" id="btnExport" name='export'
                value="Export to Excel" class="btn btn-info">Export to
                excel</button>
    </div>
    <table id="tab">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th width="20%">Student ID</th>
                <th width="20%">Token</th>
          
            </tr>
        </thead>
        <tbody>
 
            <?php
            $query = $db_handle->runQuery("select * from lib_pushTokens order by id desc");
            if (! empty($productResult)) {
                foreach ($productResult as $key => $value) {
                    ?>
                 
                     <tr>
                <td><?php echo $productResult[$key]["id"]; ?></td>
                <td><?php echo $productResult[$key]["studentId"]; ?></td>
                <td><?php echo substr($productResult[$key]["token"], 0, 30)."*****" ?></td>
            </tr>
           <?php
                }
            }
            ?>
      </tbody>
    </table>

    <div class="btn">
        <button onclick="exportTableToExcel('tab', 'HULib-notificationTokens')" id="btnExport" name='export'
                value="Export to Excel" class="btn btn-info">Export to
                excel</button>
    </div>
</div>
<footer>&copy; Copyright 2019 <a href="https://www.anomoz.com">Anomoz</a></footer>
<script>
    function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
</script>