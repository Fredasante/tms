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
        <span class="text">Admin Master</span>
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

      <div class="container"><h4>Reports</h4></div>
    </section>

    <!-- CONTENT -->

    <script src="assets/js/script.js"></script>

    <!-- Bootstrap js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js
"></script>
  </body>
</html>
