<?php
require 'config.php';

// Start the session
session_start();

// Check if the user is not authenticated or if the user is not an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    // Redirect the user to the login page or an unauthorized access page
    header('Location: login.php'); // or header('Location: unauthorized.php');
    exit(); // Stop further execution
}

// The user is authenticated and is an admin, continue to user-master page

$sql = "SELECT * FROM Tractors";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Boxicons -->
    <link
      href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css"
      rel="stylesheet"
    />
    <!-- My CSS -->
    <link rel="stylesheet" href="assets/css/style.css" />

    <!-- Boostrap CDN -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css
"
    />

    <title>Admin Hub</title>
  </head>
  <body>
    <!-- SIDEBAR -->
  <section id="sidebar">
    <a href="#" class="brand">
        <i class="bx bxs-smile"></i>
        <span class="text">Admin Hub</span>
    </a>
    <ul class="side-menu top">
        <li>
            <a href="dashboard.php" <?php if (strpos($_SERVER['REQUEST_URI'], 'dashboard.php') !== false) echo 'class="active"'; ?>>
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="user-master.php" <?php if (strpos($_SERVER['REQUEST_URI'], 'user-master.php') !== false) echo 'class="active"'; ?>>
                <i class="bx bxs-user-account"></i>
                <span class="text">User Master</span>
            </a>
        </li>
        <li>
            <a href="tractor-master.php" <?php if (strpos($_SERVER['REQUEST_URI'], 'tractor-master.php') !== false) echo 'class="active"'; ?>>
                <i class='bx bxs-car-wash' ></i>
                <span class="text">Tractor Master</span>
            </a>
        </li>
        <li>
            <a href="model.php" <?php if (strpos($_SERVER['REQUEST_URI'], 'model.php') !== false) echo 'class="active"'; ?>>
                <i class="bx bxs-package"></i>
                <span class="text">Model Master</span>
            </a>
        </li>
        <li>
            <a href="report.php" <?php if (strpos($_SERVER['REQUEST_URI'], 'report.php') !== false) echo 'class="active"'; ?>>
                <i class="bx bxs-report"></i>
                <span class="text">Reports</span>
            </a>
        </li>
        <li>
            <a href="task.php" <?php if (strpos($_SERVER['REQUEST_URI'], 'task.php') !== false) echo 'class="active"'; ?>>
                <i class="bx bx-task"></i>
                <span class="text">Task Master</span>
            </a>
        </li>
        <li>
          <a href="work-master.php" <?php if (basename($_SERVER['PHP_SELF']) == 'work-master.php') echo 'class="active"'; ?>>
              <i class="bx bx-task"></i>
              <span class="text">Work Master</span>
          </a>
        </li>
        <li>
            <a href="daily-work.php" <?php if (strpos($_SERVER['REQUEST_URI'], 'daily-work.php') !== false) echo 'class="active"'; ?>>
                <i class="bx bxs-group"></i>
                <span class="text">Daily Work</span>
            </a>
        </li>
    </ul>
    <ul class="side-menu">
        <li>
            <form action="logout.php" method="post">
                <button type="submit" class="logout-btn">
                    <i class="bx bxs-log-out-circle"></i>
                    <span>Logout</span>
                </button>
            </form>
        </li>
    </ul>
  </section>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
      <!-- NAVBAR -->
      <nav>
        <i class="bx bx-menu"></i>
        <a href="#" class="nav-link">Categories</a>
        <form action="#">
          <div class="form-input">
            <input type="search" placeholder="Search..." />
            <button type="submit" class="search-btn">
              <i class="bx bx-search"></i>
            </button>
          </div>
        </form>
      </nav>
      <!-- NAVBAR -->

      <div id="tractorMaster" class="container">
        <div class="jumbotron text-center">
          <h1 class="display-4">TRACTOR MANAGEMENT SYSTEM</h1>
          <p class="lead">Efficiently manage your tractor fleet with ease.</p>
        </div>

        <!-- Tractors Section -->
        <div>
          <div class="row">
            <div>
              <div class="card">
                <div class="card-header">
                  <h2>TRACTOR LIST</h2>
                  <div class="row">
                    <div class="col-lg-5"></div>
                
                    <div class="col-lg-4">
                      <div class="input-group mb-3">
                        <input
                          id="live_search"           
                          type="text"
                          class="form-control"
                          placeholder="Enter Search Query"
                        />
                        <button class="btn btn-tertiary" type="button">
                          Find
                        </button>
                      </div>
                    </div>                
                    
                    <!-- Button for adding new user -->
                    <div class="addNewButton col-lg-3">
                      <a href="add-tractor.php">
                        <button
                          type="button"
                          class="btn btn-secondary rounded me-3 mb-2"
                        >
                          <i class="bx bxs-user me-2"></i>
                          Add New
                        </button>
                      </a>
                    </div>
                  </div>
                </div>

                <!-- TRACTOR DETAILS TABLE STARTS -->
                <section id="table" class="container">
                    <div class="row">
                        <table class="content-table">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Tractor Number</th>
                                    <th>Model/Brand</th>
                                    <th>Horsepower</th>
                                    <th>Serial Number</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $srNo = 1; // Initialize serial number counter
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <tr>
                                        <td><?php echo $srNo++; ?></td>
                                        <td><?php echo $row['TractorNumber']; ?></td>
                                        <td>
                                            <?php
                                            // Fetch model/brand from TractorModels table based on ModelID
                                            $modelID = $row['ModelID'];
                                            $modelQuery = "SELECT ModelName FROM TractorModels WHERE ModelID = $modelID";
                                            $modelResult = mysqli_query($con, $modelQuery);
                                            $modelRow = mysqli_fetch_assoc($modelResult);
                                            echo $modelRow['ModelName'];
                                            ?>
                                        </td>
                                        <td><?php echo $row['Horsepower']; ?></td>
                                        <td><?php echo $row['SerialNumber']; ?></td>
                                        <td>
                                            <a href="update-tractor.php?id=<?php echo $row['TractorID']; ?>">
                                                <button class="btn btn-info btn-sm">Edit</button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </section>
                <!-- TRACTOR DETAILS TABLE ENDS -->     
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- CONTENT -->

    <!-- Link to custom JS file -->
    <script src="assets/js/script.js"></script>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js
"></script>
  </body>
</html>
