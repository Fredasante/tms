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

// User is authenticated and is an admin, continue to admin-dashboard page

// Get today's date
$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));

// Get start and end dates for this month
$thisMonthStart = date('Y-m-01');
$thisMonthEnd = date('Y-m-t');

// Get start and end dates for this year
$thisYearStart = date('Y-01-01');
$thisYearEnd = date('Y-12-31');

// Query to retrieve total hours used for today
$sql_total_hours_used_today = "SELECT SUM(hours_used) AS total_hours_used_today FROM TractorUsage WHERE DATE(start_datetime) = '$today'";
$result_total_hours_used_today = mysqli_query($con, $sql_total_hours_used_today);
$row_total_hours_used_today = mysqli_fetch_assoc($result_total_hours_used_today);
$total_hours_used_today = $row_total_hours_used_today['total_hours_used_today'];


// Query to retrieve the total number of tractors recorded work today
$sql_total_tractors_recorded_work_today = "SELECT COUNT(DISTINCT tractor_id) AS total_tractors_recorded_work_today 
                                           FROM TractorUsage 
                                           WHERE DATE(start_datetime) = CURDATE()";
$result_total_tractors_recorded_work_today = mysqli_query($con, $sql_total_tractors_recorded_work_today);
$row_total_tractors_recorded_work_today = mysqli_fetch_assoc($result_total_tractors_recorded_work_today);
$total_tractors_recorded_work_today = $row_total_tractors_recorded_work_today['total_tractors_recorded_work_today'];

// Query to retrieve total area covered today
$sql_total_area_covered_today = "SELECT SUM(area_covered) AS total_area_covered_today FROM TractorUsage WHERE DATE(start_datetime) = CURDATE()";
$result_total_area_covered_today = mysqli_query($con, $sql_total_area_covered_today);
$row_total_area_covered_today = mysqli_fetch_assoc($result_total_area_covered_today);
$total_area_covered_today = $row_total_area_covered_today['total_area_covered_today'];

// Query to retrieve total number of users who recorded work today
$sql_total_users_recorded_work_today = "SELECT COUNT(DISTINCT user_id) AS total_users_recorded_work 
                                        FROM TractorUsage 
                                        WHERE DATE(created_at) = '$today'";
$result_total_users_recorded_work_today = mysqli_query($con, $sql_total_users_recorded_work_today);
$row_total_users_recorded_work_today = mysqli_fetch_assoc($result_total_users_recorded_work_today);
$total_users_recorded_work_today = $row_total_users_recorded_work_today['total_users_recorded_work'];

// Query to retrieve total number of tractors
$sql_total_tractors = "SELECT COUNT(*) AS total_tractors FROM tractors";
$result_total_tractors = mysqli_query($con, $sql_total_tractors);
$row_total_tractors = mysqli_fetch_assoc($result_total_tractors);
$total_tractors = $row_total_tractors['total_tractors'];

// Query to retrieve total hours used for yesterday
$sql_total_hours_used_yesterday = "SELECT SUM(hours_used) AS total_hours_used_yesterday FROM TractorUsage WHERE DATE(start_datetime) = '$yesterday'";
$result_total_hours_used_yesterday = mysqli_query($con, $sql_total_hours_used_yesterday);
$row_total_hours_used_yesterday = mysqli_fetch_assoc($result_total_hours_used_yesterday);
$total_hours_used_yesterday = $row_total_hours_used_yesterday['total_hours_used_yesterday'];

// Query to retrieve the total number of tractors recorded work yesterday
$sql_total_tractors_recorded_work_yesterday = "SELECT COUNT(DISTINCT tractor_id) AS total_tractors_recorded_work_yesterday 
                                               FROM TractorUsage 
                                               WHERE DATE(start_datetime) = CURDATE() - INTERVAL 1 DAY";
$result_total_tractors_recorded_work_yesterday = mysqli_query($con, $sql_total_tractors_recorded_work_yesterday);
$row_total_tractors_recorded_work_yesterday = mysqli_fetch_assoc($result_total_tractors_recorded_work_yesterday);
$total_tractors_recorded_work_yesterday = $row_total_tractors_recorded_work_yesterday['total_tractors_recorded_work_yesterday'];

// Query to retrieve total area covered for yesterday
$sql_total_area_covered_yesterday = "SELECT SUM(area_covered) AS total_area_covered FROM TractorUsage WHERE DATE(start_datetime) = '$yesterday'";
$result_total_area_covered_yesterday = mysqli_query($con, $sql_total_area_covered_yesterday);
$row_total_area_covered_yesterday = mysqli_fetch_assoc($result_total_area_covered_yesterday);
$total_area_covered_yesterday = $row_total_area_covered_yesterday['total_area_covered'];

// Query to retrieve total number of users who recorded work yesterday
$sql_total_users_recorded_work_yesterday = "SELECT COUNT(DISTINCT user_id) AS total_users_recorded_work 
                                        FROM TractorUsage 
                                        WHERE DATE(created_at) = '$yesterday'";
$result_total_users_recorded_work_yesterday = mysqli_query($con, $sql_total_users_recorded_work_yesterday);
$row_total_users_recorded_work_yesterday = mysqli_fetch_assoc($result_total_users_recorded_work_yesterday);
$total_users_recorded_work_yesterday = $row_total_users_recorded_work_yesterday['total_users_recorded_work'];


// Query to retrieve the total number of tractors recorded work for this month
$sql_total_tractors_recorded_work_this_month = "SELECT COUNT(DISTINCT tractor_id) AS total_tractors_recorded_work_this_month 
                                                FROM TractorUsage 
                                                WHERE MONTH(start_datetime) = MONTH(CURDATE()) 
                                                AND YEAR(start_datetime) = YEAR(CURDATE())";
$result_total_tractors_recorded_work_this_month = mysqli_query($con, $sql_total_tractors_recorded_work_this_month);
$row_total_tractors_recorded_work_this_month = mysqli_fetch_assoc($result_total_tractors_recorded_work_this_month);
$total_tractors_recorded_work_this_month = $row_total_tractors_recorded_work_this_month['total_tractors_recorded_work_this_month'];

// Query to retrieve total hours used for this month
$sql_total_hours_used_this_month = "SELECT SUM(hours_used) AS total_hours_used FROM TractorUsage WHERE DATE(start_datetime) BETWEEN '$thisMonthStart' AND '$thisMonthEnd'";
$result_total_hours_used_this_month = mysqli_query($con, $sql_total_hours_used_this_month);
$row_total_hours_used_this_month = mysqli_fetch_assoc($result_total_hours_used_this_month);
$total_hours_used_this_month = $row_total_hours_used_this_month['total_hours_used'];

// Query to retrieve total area covered for this month
$sql_total_area_covered_this_month = "SELECT SUM(area_covered) AS total_area_covered FROM TractorUsage WHERE DATE(start_datetime) BETWEEN '$thisMonthStart' AND '$thisMonthEnd'";
$result_total_area_covered_this_month = mysqli_query($con, $sql_total_area_covered_this_month);
$row_total_area_covered_this_month = mysqli_fetch_assoc($result_total_area_covered_this_month);
$total_area_covered_this_month = $row_total_area_covered_this_month['total_area_covered'];

// Query to retrieve total number of users who recorded work this month
$sql_total_users_recorded_work_this_month = "SELECT COUNT(DISTINCT user_id) AS total_users_recorded_work 
                                        FROM TractorUsage 
                                        WHERE DATE(created_at) BETWEEN '$thisMonthStart' AND '$thisMonthEnd'";
$result_total_users_recorded_work_this_month = mysqli_query($con, $sql_total_users_recorded_work_this_month);
$row_total_users_recorded_work_this_month = mysqli_fetch_assoc($result_total_users_recorded_work_this_month);
$total_users_recorded_work_this_month = $row_total_users_recorded_work_this_month['total_users_recorded_work'];

// Query to retrieve the total number of tractors recorded work for this year
$sql_total_tractors_recorded_work_this_year = "SELECT COUNT(DISTINCT tractor_id) AS total_tractors_recorded_work_this_year 
                                               FROM TractorUsage 
                                               WHERE YEAR(start_datetime) = YEAR(CURDATE())";
$result_total_tractors_recorded_work_this_year = mysqli_query($con, $sql_total_tractors_recorded_work_this_year);
$row_total_tractors_recorded_work_this_year = mysqli_fetch_assoc($result_total_tractors_recorded_work_this_year);
$total_tractors_recorded_work_this_year = $row_total_tractors_recorded_work_this_year['total_tractors_recorded_work_this_year'];

// Query to retrieve total hours used for this year
$sql_total_hours_used_this_year = "SELECT SUM(hours_used) AS total_hours_used FROM TractorUsage WHERE DATE(start_datetime) BETWEEN '$thisYearStart' AND '$thisYearEnd'";
$result_total_hours_used_this_year = mysqli_query($con, $sql_total_hours_used_this_year);
$row_total_hours_used_this_year = mysqli_fetch_assoc($result_total_hours_used_this_year);
$total_hours_used_this_year = $row_total_hours_used_this_year['total_hours_used'];

// Query to retrieve total area covered for this year
$sql_total_area_covered_this_year = "SELECT SUM(area_covered) AS total_area_covered FROM TractorUsage WHERE DATE(start_datetime) BETWEEN '$thisYearStart' AND '$thisYearEnd'";
$result_total_area_covered_this_year = mysqli_query($con, $sql_total_area_covered_this_year);
$row_total_area_covered_this_year = mysqli_fetch_assoc($result_total_area_covered_this_year);
$total_area_covered_this_year = $row_total_area_covered_this_year['total_area_covered'];

// Query to retrieve total number of users who recorded work this year
$sql_total_users_recorded_work_this_year = "SELECT COUNT(DISTINCT user_id) AS total_users_recorded_work 
                                        FROM TractorUsage 
                                        WHERE DATE(created_at) BETWEEN '$thisYearStart' AND '$thisYearEnd'";
$result_total_users_recorded_work_this_year = mysqli_query($con, $sql_total_users_recorded_work_this_year);
$row_total_users_recorded_work_this_year = mysqli_fetch_assoc($result_total_users_recorded_work_this_year);
$total_users_recorded_work_this_year = $row_total_users_recorded_work_this_year['total_users_recorded_work'];

// Query to retrieve total number of tractors
$sql_total_tractors_this_year = "SELECT COUNT(*) AS total_tractors FROM tractors";
$result_total_tractors_this_year = mysqli_query($con, $sql_total_tractors_this_year);
$row_total_tractors_this_year = mysqli_fetch_assoc($result_total_tractors_this_year);
$total_tractors_this_year = $row_total_tractors_this_year['total_tractors'];

// Display the dashboard
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

      <div id="page1" class="container page">
        <div class="jumbotron text-center">
          <h1 class="display-4">TRACTOR MANAGEMENT SYSTEM</h1>
          <p class="lead">Efficiently manage your tractor fleet with ease.</p>
        </div>
      </div>

      <section class="container">

      <div class="container">

        <h4 class="dashboard-titles mb-3">TRACTOR USAGE STATISTICS</h4>

        <!-- today -->
        <main class="mb-4 box1">`
            <h4 class="dashboard-title">TODAY</h4>
            <ul class="box-info">
                        <li>
                    <i class='bx bxs-dashboard'></i>
                            <span class="text">					
                    <p>TRACTORS USED</p>
            <?php if (empty($total_tractors_recorded_work_today)): ?>
                <h3>0</h3>
                <?php else: ?>
                    <h3><?php echo $total_tractors_recorded_work_today; ?></h3>
                <?php endif; ?>
                            </span>
                        </li>
                        <li>
                            <i class='bx bxs-watch'></i>
                            <span class="text">
                                <p>MINUTES USED</p>
                    <?php if (empty($total_hours_used_today)): ?>
                    <h5>0</h5>
                    <?php else: ?>
                    <h5><?php echo $total_hours_used_today; ?></h5>
                    <?php endif; ?>
                            </span>
                        </li>
                        <li>
                            <i class='bx bxs-area'></i>
                            <span class="text">
                                <p>AREA COVERED</p>
                        <?php if (empty($total_area_covered_today)): ?>
                            <h5>0</h5>
                        <?php else: ?>
                            <h5><?php echo $total_area_covered_today; ?></h5>
                        <?php endif; ?>
                            </span>
                        </li>
                        <li>
                            <i class='bx bxs-user'></i>
                            <span class="text">
                        <p>TOTAL USERS</p>
                        <?php if (empty($total_users_recorded_work_today)): ?>
                            <h5>0</h5>
                        <?php else: ?>
                            <h5><?php echo $total_users_recorded_work_today; ?></h5>
                        <?php endif; ?>
                            </span>
                        </li>
                    </ul>
        </main>

        <!-- yesterday -->
        <main class="mb-4 box1">
            <h4 class="dashboard-title">YESTERDAY</h4>
            <ul class="box-info">
                        <li>
                    <i class='bx bxs-dashboard'></i>
                            <span class="text">					
                    <p>TRACTORS USED</p>
                        <?php if (empty($total_tractors_recorded_work_yesterday)): ?>
                        <h3>0</h3>
                        <?php else: ?>
                            <h3><?php echo $total_tractors_recorded_work_yesterday; ?></h3>
                        <?php endif; ?>
                        </span>
                        </li>
                        <li>
                            <i class='bx bxs-watch'></i>
                            <span class="text">
                                <p>MINUTES USED</p>
                            <?php if (empty($total_hours_used_yesterday)): ?>
                            <h5>0</h5>
                            <?php else: ?>
                            <h5><?php echo $total_hours_used_yesterday; ?></h5>
                            <?php endif; ?>
                            </span>
                        </li>
                        <li>
                            <i class='bx bxs-area'></i>
                            <span class="text">
                        <p>AREA COVERED</p>
                        <?php if (empty($total_area_covered_yesterday)): ?>
                            <h5>0</h5>
                        <?php else: ?>
                            <h5><?php echo $total_area_covered_yesterday; ?></h5>
                        <?php endif; ?>
                            </span>
                        </li>
                        <li>
                            <i class='bx bxs-user'></i>
                            <span class="text">
                        <p>TOTAL USERS</p>
                        <?php if (empty($total_users_recorded_work_yesterday)): ?>
                            <h5>0</h5>
                        <?php else: ?>
                            <h5><?php echo $total_users_recorded_work_yesterday; ?></h5>
                        <?php endif; ?>
                            </span>
                        </li>
                    </ul>
        </main>

        <!-- this month -->
        <main class="mb-4 box1">
            <h4 class="dashboard-title">THIS MONTH</h4>

            <ul class="box-info">
                <li>
                    <i class='bx bxs-dashboard' ></i>
                    <span class="text">
                        <p>TRACTORS USED</p>
                <?php if (empty($total_tractors_recorded_work_this_month)): ?>
                    <h3>0</h3>
                <?php else: ?>
                    <h3><?php echo $total_tractors_recorded_work_this_month; ?></h3>
                <?php endif; ?>      
                    </span>
                </li>

                <li>
                    <i class='bx bxs-watch'></i>
                    <span class="text">
                    <p>MINUTES USED</p>
                    <?php if (empty($total_hours_used_this_month)): ?>
                    <h5>0</h5>
                    <?php else: ?>
                    <h5><?php echo $total_hours_used_this_month; ?></h5>
                    <?php endif; ?>
                    </span>
                </li>

                <li>
                    <i class='bx bxs-area'></i>
                    <span class="text">
                        <p>AREA COVERED</p>
                        <?php if (empty($total_area_covered_this_month)): ?>
                            <h5>0</h5>
                        <?php else: ?>
                            <h5><?php echo $total_area_covered_this_month; ?></h5>
                        <?php endif; ?>
                    </span>
                </li>

                <!-- This Year -->
                <li>
                    <i class='bx bxs-user'></i>
                    <span class="text">
                        <p>TOTAL USERS</p>
                        <?php if (empty($total_users_recorded_work_this_month)): ?>
                            <h5>0</h5>
                        <?php else: ?>
                            <h5><?php echo $total_users_recorded_work_this_month; ?></h5>
                        <?php endif; ?>
                    </span>
                </li>
            </ul>
        </main>

        <!-- this year -->
        <main class="mb-5 box1">
            <h4 class="dashboard-title">THIS YEAR</h4>
            <ul class="box-info">
                <li>
                    <i class='bx bxs-dashboard' ></i>
                    <span class="text">
                    <p>TRACTORS USED</p>
                <?php if (empty($total_tractors_recorded_work_this_year)): ?>
                    <h3>0</h3>
                <?php else: ?>
                    <h3><?php echo $total_tractors_recorded_work_this_year; ?></h3>
                <?php endif; ?>
                    </span>
                </li>

                <li>
                    <i class='bx bxs-watch'></i>
                    <span class="text">
                    <p>MINUTES USED</p>
                    <?php if (empty($total_hours_used_this_year)): ?>
                    <h5>0</h5>
                    <?php else: ?>
                    <h5><?php echo $total_hours_used_this_year; ?></h5>
                    <?php endif; ?>
                    </span>
                </li>

                <li>
                    <i class='bx bxs-area'></i>
                    <span class="text">
                        <p>AREA COVERED</p>
                        <?php if (empty($total_area_covered_this_year)): ?>
                            <h5>0</h5>
                        <?php else: ?>
                            <h5><?php echo $total_area_covered_this_year; ?></h5>
                        <?php endif; ?>
                    </span>
                </li>

                <li>
                    <i class='bx bxs-user'></i>
                    <span class="text">
                        <p>TOTAL USERS</p>
                        <?php if (empty($total_users_recorded_work_this_year)): ?>
                            <h5>0</h5>
                        <?php else: ?>
                            <h5><?php echo $total_users_recorded_work_this_year; ?></h5>
                        <?php endif; ?>
                    </span>
                </li>
            </ul>
        </main>


</section>
       <!-- <div class="row">
          <div class="col-md-6 ">
            <div class="card mb-3 " style="max-width: 38rem;">
            <div class="card-header dashboard-one">
              <h2>COMPARISON OF DATA - TODAY & YESTERDAY</h2>
            </div>
            <div class="card-body text-secondary">
              <canvas id="myChart" width="400" height="143"></canvas>
            </div>
            </div>
          </div>

          </div>
        </div>
      </div> -->     
</section>
    <!-- CONTENT -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Get the PHP data
    var todayData = {
        totalHoursUsed: <?php echo empty($total_hours_used) ? 0 : $total_hours_used; ?>,
        totalAreaCovered: <?php echo empty($total_area_covered) ? 0 : $total_area_covered; ?>,
        totalUsers: <?php echo empty($total_users_recorded_work_today) ? 0 : $total_users_recorded_work_today; ?>,
        totalTractors: <?php echo empty($total_tractors) ? 0 : $total_tractors; ?>
    };

    var yesterdayData = {
        totalHoursUsed: <?php echo empty($total_hours_used_yesterday) ? 0 : $total_hours_used_yesterday; ?>,
        totalAreaCovered: <?php echo empty($total_area_covered_yesterday) ? 0 : $total_area_covered_yesterday; ?>,
        totalUsers: <?php echo empty($total_users_recorded_work_yesterday) ? 0 : $total_users_recorded_work_yesterday; ?>,
        totalTractors: <?php echo empty($total_tractors_yesterday) ? 0 : $total_tractors_yesterday; ?>
    };

    // Create the bar chart
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total Hours Used', 'Total Area Covered', 'Total Users', 'Total Tractors'],
            datasets: [{
                label: 'Today',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                data: [todayData.totalHoursUsed, todayData.totalAreaCovered, todayData.totalUsers, todayData.totalTractors]
            }, {
                label: 'Yesterday',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                data: [yesterdayData.totalHoursUsed, yesterdayData.totalAreaCovered, yesterdayData.totalUsers, yesterdayData.totalTractors]
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>


    <script src="assets/js/script.js"></script>

    <!-- Bootstrap js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js
"></script>
  </body>
</html>
