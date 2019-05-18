<?include_once("global.php");?>
<?
if ($logged==0){ 
    ?>
    <script type="text/javascript">
            window.location = "./";
        </script>
    <?
}

//number of rooms booked uptil now
$query = "select 
	*
from lib_bookings order by id desc
"; 
$result = $con->query($query); 

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
          <li class="nav-item active">
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
          <li class="nav-item">
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
            <a class="navbar-brand" href="#pablo">Past Bookings</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
           
            <ul class="navbar-nav">
            
              
              <li class="nav-item dropdown">
                <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="#">Log out</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <!--
              <div class="form-check form-check-radio">
                  <label class="form-check-label">
                      <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" >
                      Room 201
                      <span class="circle">
                          <span class="check"></span>
                      </span>
                  </label>
                  <label class="form-check-label">
                      <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" >
                      Room 202
                      <span class="circle">
                          <span class="check"></span>
                      </span>
                  </label>
              </div>
            -->
              <div class="card">
                <div class="card-header card-header-primary">

                  <h4 class="card-title ">Past Bookings</h4>
                  <p class="card-category">Find all the past bookings here</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                        <th>
                          ID
                        </th>
                        <th class="text-primary">
                          Room Number
                        </th>
                        <th>
                          Booked By
                        </th>
                        <th>
                          Date
                        </th>
                        <th>
                          Time
                        </th>
                        <th>
                          Occupants
                        </th>
                        <th>
                          Purpose
                        </th>
                      </thead>
                      <tbody>

                        <?php
                        if ($result->num_rows > 0)
                        { 
                            
                            while($row = $result->fetch_assoc()) 
                            { 
                                echo"<tr>";
                                echo "<td>".$row['id']."</td>";
                                echo "<td>".$row['room']."</td>";
                                echo "<td>".$row['studentId']."</td>";
                                echo "<td>".substr($row['dateTimeTaken'],0,10)."</td>";
                                echo "<td>".substr($row['dateTimeTaken'],-10)."</td>";
                                echo "<td>".$row['nStudents']."</td>";
                                echo "<td>".$row['purpose']."</td>";
                                echo "</tr>";

                            }
                        }
                        ?>
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
