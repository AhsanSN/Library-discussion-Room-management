<?include_once("global.php");?>
<?
if ($logged==0){ 
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}

?>
<!DOCTYPE html>
<html lang="en">
<?include("./phpParts/head.php")?>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="assets/img/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo">
        <a href="./" class="simple-text logo-normal">
          HU - Library
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item ">
            <a class="nav-link" href="./dashboard.php">
              <i class="material-icons">dashboard</i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="./history.php">
              <i class="material-icons">library_books</i>
              <p>History</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./flagStudent.php">
              <i class="material-icons">flag</i>
              <p>Flag Students</p>
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="./allDataDownload.php">
              <i class="material-icons">import_export</i>
              <p>Export data</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./settings.php">
              <i class="material-icons">settings</i>
              <p>Settings</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="#pablo">Import/Export Data</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
          
          
        <div class="container-fluid">
            <?if ($session_role=="admin"){?>
         <a href="./importStudentsData.php" target="_blank"> <button type="submit" class="btn btn-primary">Import Students Data</button></a>
         <?}?>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">

                  <h4 class="card-title ">Download Data</h4>
                  <p class="card-category">All your data now under one shelf.</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <th>
                          ID
                        </th>
                        <th class="text-primary">
                          Type of Data
                        </th>
                        <th>
                          Description
                        </th>
                        <th>
                          View/Download
                        </th>
                      </thead>
                      <tbody>

                        <tr>
                        <td>1</td>
                        <td>Bookings</td>
                        <td>Contains details of all bookings done uptil now.</td>
                        <td><a href="./profiles/data/exportData_bookings.php" target="_blank"><button class="btn btn-success btn-sm">View<div class="ripple-container"></div></button></a></td>
                        </tr>
                        
                        <?if ($session_role=="admin"){?>

                        <tr>
                        <td>2</td>
                        <td>Flagged Students</td>
                        <td>Contains details of all the students flagged uptil now.</td>
                        <td><a href="./profiles/data/exportData_flagged.php" target="_blank"><button class="btn btn-success btn-sm">View<div class="ripple-container"></div></button></a></td>
                        </tr>
                            
                        <tr>
                        <td>3</td>
                        <td>Swapped Cards</td>
                        <td>Contains details of all the bookings during with card was swapped.</td>
                        <td><a href="./profiles/data/exportData_swappedCards.php" target="_blank"><button class="btn btn-success btn-sm">View<div class="ripple-container"></div></button></a></td>
                        </tr>    
                       
                        <tr>
                        <td>4</td>
                        <td>Page Visits</td>
                        <td>Contains details of students's visit on the "Check Status" page indicating how many times the page was accessed and by whom.</td>
                        <td><a href="./profiles/data/exportData_statusChecked.php" target="_blank"><button class="btn btn-success btn-sm">View<div class="ripple-container"></div></button></a></td>
                        </tr>
                        
                        <tr>
                        <td>5</td>
                        <td>Notification Tokens</td>
                        <td>Contains a list of all the tokens obtained from all the devices.</td>
                        <td><a href="./profiles/data/exportData_notfTokens.php" target="_blank"><button class="btn btn-success btn-sm">View<div class="ripple-container"></div></button></a></td>
                        </tr>
                        
                        <tr>
                        <td>6</td>
                        <td>Queued Student</td>
                        <td>Contains a list of all the students who were added to the queue.</td>
                        <td><a href="./profiles/data/exportData_queueStudents.php" target="_blank"><button class="btn btn-success btn-sm">View<div class="ripple-container"></div></button></a></td>
                        </tr>
                        
                        <?}?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<?include("./phpParts/footer.php")?>

</body>

</html>
