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

// Initialize variables for search
$start_date = "";
$end_date = "";
$search_query = "";

// Process search form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input dates
    $start_date = mysqli_real_escape_string($con, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($con, $_POST['end_date']);
    
    // Construct the search query
    if (!empty($start_date) && !empty($end_date)) {
        $search_query = "AND DATE(tu.start_datetime) BETWEEN '$start_date' AND '$end_date'";
    } elseif (!empty($start_date)) {
        $search_query = "AND DATE(tu.start_datetime) >= '$start_date'";
    } elseif (!empty($end_date)) {
        $search_query = "AND DATE(tu.start_datetime) <= '$end_date'";
    }
}

// Set the number of records per page
$records_per_page = 10;

// Determine current page number
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($current_page - 1) * $records_per_page;

// Fetch total number of records for the logged-in user, including search criteria
$total_records_query = "SELECT COUNT(*) AS total_records
                        FROM TractorUsage tu
                        INNER JOIN Tractors t ON tu.tractor_id = t.TractorID
                        INNER JOIN tasks tsk ON tu.task_id = tsk.id
                        WHERE tu.user_id = $user_id
                        $search_query";
$total_records_result = mysqli_query($con, $total_records_query);
$total_records_row = mysqli_fetch_assoc($total_records_result);
$total_records = $total_records_row['total_records'];

// Calculate total pages
$total_pages = ceil($total_records / $records_per_page);

// Fetch tractor usage records for the logged-in user, including search criteria and pagination
$query = "SELECT tu.id, tu.start_datetime, tu.hours_used, tu.area_covered, t.TractorNumber, tsk.task_name 
          FROM TractorUsage tu
          INNER JOIN Tractors t ON tu.tractor_id = t.TractorID
          INNER JOIN tasks tsk ON tu.task_id = tsk.id
          WHERE tu.user_id = $user_id
          $search_query
          ORDER BY tu.start_datetime DESC
          LIMIT $records_per_page OFFSET $offset"; // Apply pagination
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

        <div>
          <div class="row">
            <div>
              <div class="card">
                <div class="card-header">
                  <h2 class="mb-4">DAILY WORK</h2>
                  <form class="row" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="col-lg-3">
                        <div class="row user-details">
                          <div class="col-md-6 input-box">
                            <p>Start Date:</p>
                            <input type="date" name="start_date" id="start_date" value="<?php echo $start_date; ?>">
                          </div>
                          <div class="col-md-6 input-box">
                            <p>End Date:</p>
                            <input type="date" name="end_date" id="end_date" value="<?php echo $end_date; ?>">
                          </div>
                        </div>                
                    </div>

                    <div class="buttonSample col-lg-1 pt-1 smallPadding">
                      <a href="add-daily-work.php">
                      <button
                        type="submit"
                        class="btn btn-secondary rounded me-3 mb-2"
                      >
                        Search
                      </button>
                      </a>
                    </div>

                    <div class="col-lg-2"></div>

                    <div class="col-lg-4 smallPadding searchSmall">
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

                    <!-- Button for adding daily work -->
                    <div class="addNewButton col-lg-2 smallPadding">
                      <a href="add-daily-work.php">
                      <button
                        type="button"
                        class="btn btn-secondary rounded me-3 mb-2"
                      >
                      <i class='bx bx-calendar-check me-2'></i>
                        Add New
                      </button>
                      </a>
                    </div>
                  </form>
                </div>

              <!-- TRACTOR USAGE TABLE STARTS -->

            <section id="table" class="container">
              <div class="row">
                <table class="content-table">
                  <thead>
                      <tr>
                          <th>Date</th>
                          <th>Task</th>
                          <th>Minutes Used</th>
                          <th>Area Covered (Acres)</th>
                          <th>Tractor Number</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                      // Loop through each tractor usage record and display it in a table row
                      $latest_record = null; // Initialize variable to hold the latest record
                      while ($row = mysqli_fetch_assoc($result)) {
                          // Store the latest record
                          if (!$latest_record) {
                              $latest_record = $row;
                          }
                          echo '<tr>';
                          echo '<td>' . $row['start_datetime'] . '</td>';
                          echo '<td>' . $row['task_name'] . '</td>';
                          echo '<td>' . $row['hours_used'] . '</td>';
                          echo '<td>' . $row['area_covered'] . '</td>';
                          echo '<td>' . $row['TractorNumber'] . '</td>';
                          // If this is the latest record, display the edit button
                          if ($latest_record && $latest_record['id'] === $row['id']) {
                              echo '<td><a href="update-daily-work.php?id=' . $latest_record['id'] . '"><button class="btn btn-sm btn-info">Edit</button></a></td>';
                          } else {
                              echo '<td></td>'; // Empty cell for non-latest records
                          }
                          echo '</tr>';
                      }
                      ?>
                  </tbody>
              </table>
              </div>
         
            </section>
              <!-- TRACTOR USAGE DETAILS TABLE ENDS -->
            
                <!-- Pagination -->
                <!-- <div class="pagination-container">
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
                </div> -->
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
