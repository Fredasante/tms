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
// Function to calculate age based on date of birth
function calculateAge($dob) {
    $today = new DateTime();
    $birthdate = new DateTime($dob);
    $age = $birthdate->diff($today)->y;
    return $age;
}

// Query to retrieve total number of users
$sql_total_users = "SELECT COUNT(*) AS total_users FROM users";
$result_total_users = mysqli_query($con, $sql_total_users);
$row_total_users = mysqli_fetch_assoc($result_total_users);
$total_users = $row_total_users['total_users'];

// Query to retrieve number of active users
$sql_active_users = "SELECT COUNT(*) AS active_users FROM users WHERE status = 'active'";
$result_active_users = mysqli_query($con, $sql_active_users);
$row_active_users = mysqli_fetch_assoc($result_active_users);
$active_users = $row_active_users['active_users'];

// Query to retrieve number of inactive users
$sql_inactive_users = "SELECT COUNT(*) AS inactive_users FROM users WHERE status = 'inactive'";
$result_inactive_users = mysqli_query($con, $sql_inactive_users);
$row_inactive_users = mysqli_fetch_assoc($result_inactive_users);
$inactive_users = $row_inactive_users['inactive_users'];

// Query to retrieve recent login activity
$sql_recent_logins = "SELECT users.name, login_history.login_time, login_history.ip_address 
                      FROM login_history
                      INNER JOIN users ON login_history.user_id = users.id
                      ORDER BY login_history.login_time DESC
                      LIMIT 3";
$result_recent_logins = mysqli_query($con, $sql_recent_logins);

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
          <a href="dashboard.php">
            <i class="bx bxs-user-account"></i>
            <span class="text">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="user-master.php">
            <i class="bx bxs-user-account"></i>
            <span class="text">User Master</span>
          </a>
        </li>
        <li>
          <a href="tractor-master.php">
            <img
              src="assets/images/tractor.png"
              style="height: 17px; margin-left: 13px; margin-right: 10px"
              alt="tractor icon"
            />
            <span class="text">Tractor Master</span>
          </a>
        </li>
        <li>
          <a href="model.php">
            <i class="bx bxs-package"></i>
            <span class="text">Model Master</span>
          </a>
        </li>
        <li>
          <a href="report.php">
            <i class="bx bxs-report"></i>
            <span class="text">Reports</span>
          </a>
        </li>
        <li>
          <a href="task.php">
            <i class="bx bx-task"></i>
            <span class="text">Task Master</span>
          </a>
        </li>
        <li>
          <a href="user.php">
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

      <div class="container">
        <h2 class="text-center mt-4 mb-5 dashboard-title">ADMIN DASHBOARD</h2>

        <div class="row gap-5 ms-3">
          <div class="col-md-6 ">
            <div class="card mb-3 " style="max-width: 38rem;">
            <div class="card-header dashboard-one">
              <h2>USER STATISTICS</h2>
            </div>
            <div class="card-body text-secondary">
              <canvas id="userStatisticsChart" width="400" height="330"></canvas>
            </div>
            </div>
          </div>

          <div class="col-md-5">
            <div class="row">
            <div class="dashboard col-12">
            <div class="card mb-3" style="max-width: 30rem;">
            <div class="card-header dashboard-two">
              <h2>RECENT LOGINS</h2>
            </div>
              <table class="content-table">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Timestamp</th>
                            <th>IP Address</th>                       
                          </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result_recent_logins)): ?>
                        <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['login_time']; ?></td>
                        <td><?php echo $row['ip_address']; ?></td>
                        </tr>
                            <?php endwhile; ?>                                   
                        </tbody>
                      </table>
                        </div>
                      </div>

                    <div class="row mt-3 dashboard">
                      <div class="col-12 ">
                        <div class="card mb-3" style="max-width: 18rem;">
                        <div class="card-header dashboard-three">
                          <h2>USERS</h2>
                        </div>
                        <div class="card-body text-secondary">
                          <p>Total Users: <?php echo $total_users; ?></p>
                          <p>Active Users: <?php echo $active_users; ?></p>
                          <p>Inactive Users: <?php echo $inactive_users; ?></p>
                        </div>
                      </div>
                    </div>
                </div>
          </div>
          </div>
        </div>

             
      


    <!-- Add any other dashboard components or metrics here -->

    <!-- Add any necessary JavaScript for interactive dashboard elements -->
      </div>
    </section>

    <!-- CONTENT -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    

    <script>
    // Get user statistics data from PHP
    var totalUsers = <?php echo $total_users; ?>;
    var activeUsers = <?php echo $active_users; ?>;
    var inactiveUsers = <?php echo $inactive_users; ?>;

    // Create the user statistics chart
    var ctx = document.getElementById('userStatisticsChart').getContext('2d');
    var userStatisticsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total Users', 'Active Users', 'Inactive Users'],
            datasets: [{
                label: 'User Statistics',
                data: [totalUsers, activeUsers, inactiveUsers],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)', // Red for total users
                    'rgba(54, 162, 235, 0.5)', // Blue for active users
                    'rgba(255, 206, 86, 0.5)' // Yellow for inactive users
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
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
