<?include_once("global.php");?>


<!DOCTYPE html>
<html lang="en">
<?include_once("./phpParts/head.php");?>


<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="assets/img/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-success" role="alert" id="success" style="display:none;">
                  <b>Associated Student ID changed.</span>
                </div>
              <div class="card">
                <div class="card-header card-header-primary">

                  <h4 class="card-title ">Change Notification Student ID</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <form style="margin:12px;" method="post" action="" autocomplete="off" >
                     <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Previous Student ID</label>
                          <input id="studentIdBox" name="studentId" type="text" class="form-control" placeholder="" required readonly>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">New Student ID</label>
                          <input id="studentIdBoxNew" name="studentIdNew" type="text" class="form-control" placeholder="" required>
                        </div>
                       <div class="form-group col-md-6" style="display:none;">
                          <input id="token" name="token" type="text" class="form-control" placeholder="" required>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary">Change</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
     <?include_once("./phpParts/footer.php");?>
     
</body>

</html>

<?
if(isset($_POST["studentId"])&&isset($_POST["studentIdNew"])){
    $studentId = $_POST["studentId"];
    $studentIdNew = $_POST["studentIdNew"];
    $token = $_POST["token"];
    ?>
    <script>
        localStorage.setItem("studentId", "<?echo $studentIdNew?>")
    </script>
    <?

if((!$studentIdNew)||(!$studentId)){
    $message = "Please insert both fields.";
    } 
else{ 
    //go
    
        //update room status
        $sql="update lib_pushTokens set studentId='$studentIdNew' where studentId='$studentId' and token='$token'";
        if(!mysqli_query($con,$sql))
        {
        echo"can not";
       
        }
      
        
        ?>
        
        <?php
                if(isset($_GET['retUrl'])){
                    $retUrl = $_GET['retUrl'];
                }
                ?>
                
    <script type="text/javascript">
            document.getElementById("success").style.display = "block"
            window.location = "<?echo $retUrl?>";
        </script>
    <?
        
}}


?>
<script>
         document.getElementById("studentIdBox").value = localStorage.getItem("studentId");
         document.getElementById("token").value = localStorage.getItem("token");
     </script>