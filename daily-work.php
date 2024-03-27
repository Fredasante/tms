<?php
include 'config.php';

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit;
}

// Retrieve the logged-in user's ID from the session
$user_id = $_SESSION['user_id'];

// Fetch tractor usage records for the logged-in user
$query = "SELECT tu.start_datetime, tu.hours_used, tu.area_covered, t.TractorNumber, tsk.task_name 
          FROM TractorUsage tu
          INNER JOIN Tractors t ON tu.tractor_id = t.TractorID
          INNER JOIN tasks tsk ON tu.task_id = tsk.id
          WHERE tu.user_id = $user_id";
$result = mysqli_query($con, $query);

if (!$result) {
    // Handle query error
    die("Error fetching records: " . mysqli_error($con));
}
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

    <title>User Hub</title>
  </head>
  <body>
    <!-- SIDEBAR -->
  <section id="sidebar">
    <a href="#" class="brand">
        <i class="bx bxs-smile"></i>
        <span class="text">User Hub</span>
    </a>
    <ul class="side-menu top">
        <?php if (isset($_SESSION['user_id'])): // Check if user is authenticated ?>
            <?php if ($_SESSION['user_type'] === 'admin'): ?>
                <li>
                    <a href="dashboard.php" <?php if (basename($_SERVER['PHP_SELF']) == 'dashboard.php') echo 'class="active"'; ?>>
                        <i class='bx bxs-dashboard'></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="user-master.php" <?php if (basename($_SERVER['PHP_SELF']) == 'user-master.php') echo 'class="active"'; ?>>
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
                    <a href="model.php" <?php if (basename($_SERVER['PHP_SELF']) == 'model.php') echo 'class="active"'; ?>>
                        <i class="bx bxs-package"></i>
                        <span class="text">Model Master</span>
                    </a>
                </li>
                <li>
                    <a href="report.php" <?php if (basename($_SERVER['PHP_SELF']) == 'report.php') echo 'class="active"'; ?>>
                        <i class="bx bxs-report"></i>
                        <span class="text">Reports</span>
                    </a>
                </li>
                <li>
                    <a href="task.php" <?php if (basename($_SERVER['PHP_SELF']) == 'task.php') echo 'class="active"'; ?>>
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
            <?php endif; ?>
            <li>
                <a href="daily-work.php" <?php if (basename($_SERVER['PHP_SELF']) == 'daily-work.php') echo 'class="active"'; ?>>
                    <i class="bx bxs-group"></i>
                    <span class="text">Daily Work</span>
                </a>
            </li>
        <?php endif; ?>
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

      <div id="work" class="container">
        <div class="jumbotron text-center">
          <h1 class="display-4">TRACTOR MANAGEMENT SYSTEM</h1>
          <p class="lead">Efficiently manage your tractor fleet with ease.</p>
        </div>

        <!-- User Section -->
        <div>
          <div class="row">
            <div>
              <div class="card">
                <div class="card-header">
                  <h2>VIEW DAILY WORK</h2>
                  <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-3 mt-4">
                      <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          Click to Filter
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="#">Weekly</a></li>
                          <li><a class="dropdown-item" href="#">Monthly</a></li>
                          <li><a class="dropdown-item" href="#">Yearly</a></li>
                        </ul>
                      </div>                    
                    </div>
                    <div class="col-lg-4 mt-4">
                      <div class="input-group mb-3">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Search.."
                        />
                        <button class="btn btn-primary" type="button">
                          Find
                        </button>
                      </div>
                    </div>

                    <!-- Button trigger modal for adding daily work -->
                    <div class="addNewButton col-lg-2 mt-4">
                      <a href="add-daily-work.php">
                      <button
                        type="button"
                        class="btn btn-secondary rounded me-3 mb-2"
                      >
                        Add New
                      </button>
                      </a>
                    </div>
                  </div>
                </div>

                <!-- USER DETAILS TABLE STARTS -->
           <table class="content-table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Task</th>
            <th>Hours Used</th>
            <th>Area Covered (m)</th>
            <th>Tractor Number</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Loop through each tractor usage record and display it in a table row
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['start_datetime'] . '</td>';
            echo '<td>' . $row['task_name'] . '</td>';
            echo '<td>' . $row['hours_used'] . '</td>';
            echo '<td>' . $row['area_covered'] . '</td>';
            echo '<td>' . $row['TractorNumber'] . '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
                <!-- USER DETAILS TABLE ENDS -->

                <!-- Modal for adding daily work  activity-->
                <div
                  class="modal fade"
                  id="userModal"
                  tabindex="-1"
                  aria-labelledby="addNewUser"
                  aria-hidden="true"
                >
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addNewUser">
                          Add New Task
                        </h1>
                        <button
                          type="button"
                          class="btn-close"
                          data-bs-dismiss="modal"
                          aria-label="Close"
                        ></button>
                      </div>
                      <div class="modal-body">
                        <!-- INPUT MODAL DETAILS FOR TASK STARTS -->
                        <div id="signUp">
                          <div class="signup-container">
                            <div class="title">DAILY WORK</div>
                            <p class="">
                              Fill in the details below to record daily work
                              activity.
                            </p>
                            <div class="content">

                            </div>
                          </div>
                        </div>
                        <!-- INPUT MODAL DETAILS FOR TASK ENDS -->
                      </div>

                  
                    </div>
                  </div>
                </div>
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
