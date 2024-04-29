<?php
// Include configuration file
require 'config.php';

// Start session
session_start();

// Check if the user is authenticated and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    // Redirect to the login page or an unauthorized access page
    header('Location: login.php'); // or header('Location: unauthorized.php');
    exit(); // Stop further execution
}

// Pagination settings
$records_per_page = 8;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Query to retrieve total number of work records
$sql_total_records = "SELECT COUNT(*) AS total_records FROM TractorUsage";
$result_total_records = mysqli_query($con, $sql_total_records);
$row_total_records = mysqli_fetch_assoc($result_total_records);
$total_records = $row_total_records['total_records'];

// Calculate total number of pages
$total_pages = ceil($total_records / $records_per_page);

// Calculate offset for SQL query
$offset = ($current_page - 1) * $records_per_page;

// Query to retrieve work records for the current page
$sql_work_records = "SELECT tu.id, tu.start_datetime, tu.end_datetime, tu.hours_used, tu.area_covered, t.task_name, tr.TractorNumber 
                      FROM TractorUsage tu
                      INNER JOIN tasks t ON tu.task_id = t.id
                      INNER JOIN tractors tr ON tu.tractor_id = tr.TractorID
                      LIMIT $offset, $records_per_page";
$result_work_records = mysqli_query($con, $sql_work_records);

// Display the work records' table
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
                  <h2>TRACTOR USAGE</h2>
                  <div class="row">
                    <div class="col-lg-6 mt-4">
                      
                    </div>
                    <div class="col-lg-4 mt-4">
                      <div class="input-group mb-3">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Search.."
                        />
                        <button class="btn btn-secondary" type="button">
                          Find
                        </button>
                      </div>
                    </div>

                    <!-- Button trigger modal for adding daily work -->
                    <div class="addNewButton col-lg-2 mt-4">
                      <a href="add-work.php">
                      <button
                        type="button"
                        class="btn btn-secondary rounded me-3 mb-2"
                      >
                      <i class='bx bx-notepad me-2'></i>
                        Add Work
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
                                  <th>Date</th>
                                  <th>Task</th>
                                  <th>Minutes Used</th>
                                  <th>Area Covered (Acres)</th>
                                  <th>Tractor Number</th>
                                  <th>Edit</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                              include 'config.php';

                              // Pagination settings
                              $records_per_page = 8;
                              $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                              $offset = ($current_page - 1) * $records_per_page;

                              // Fetch data from the database
                              $query = "SELECT tu.id, tu.start_datetime, tu.end_datetime, tu.hours_used, tu.area_covered, t.task_name, tr.TractorNumber 
                                        FROM TractorUsage tu
                                        INNER JOIN tasks t ON tu.task_id = t.id
                                        INNER JOIN tractors tr ON tu.tractor_id = tr.TractorID
                                        LIMIT $offset, $records_per_page";
                              $result = mysqli_query($con, $query);

                              // Check if any rows are returned
                              if (mysqli_num_rows($result) > 0) {
                                  $sr_no = ($current_page - 1) * $records_per_page + 1;
                                  while ($row = mysqli_fetch_assoc($result)) {
                                      echo "<tr>";
                                      echo "<td>" . $sr_no++ . "</td>";
                                      echo "<td>" . $row["start_datetime"] . " to " . $row["end_datetime"] . "</td>";
                                      echo "<td>" . $row["task_name"] . "</td>";
                                      echo "<td>" . $row["hours_used"] . "</td>";
                                      echo "<td>" . $row["area_covered"] . "</td>";
                                      echo "<td>" . $row["TractorNumber"] . "</td>";
                                      echo "<td><a href='update-work.php?id=" . $row["id"] . "'><button class='btn btn-info btn-sm'>View</button></a></td>";
                                      echo "</tr>";
                                  }
                              } else {
                                  echo "<tr><td colspan='7'>No records found</td></tr>";
                              }

                              // Close database connection
                              mysqli_close($con);
                              ?>
                          </tbody>
                      </table>
                  </div>
                </section>
                <!-- TRACTOR DETAILS TABLE ENDS -->

                <!-- pagination -->
                <div class="pagination-container">
                  <div class="pagination">
                      <?php if ($current_page > 1) : ?>
                          <a href="?page=<?php echo $current_page - 1; ?>"><i class='bx bx-left-arrow-alt'></i> Previous</a>
                      <?php endif; ?>
                      <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                          <?php if ($i == $current_page) : ?>
                              <span class="current-page"><?php echo $i; ?></span>
                          <?php else : ?>
                              <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                          <?php endif; ?>
                      <?php endfor; ?>
                      <?php if ($current_page < $total_pages) : ?>
                          <a href="?page=<?php echo $current_page + 1; ?>">Next <i class='bx bx-right-arrow-alt'></i></a>
                      <?php endif; ?>
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
