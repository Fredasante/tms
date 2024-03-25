<?php 

require 'config.php';

session_start();

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
          <div id="signUp">
            <div class="signup-container">
              <a href="work-master.php">
                <button class="mb-4 btn btn-secondary"><i class='bx bx-chevrons-left me-2'></i>
                Back
                </button>
              </a>
              <div class="title">EDIT WORK DETAILS</div>                         
                            <div class="content">
                              <form action="#">
                                <div class="user-details">
                                  <div class="input-box">
                                    <span class="details"
                                      >Start Date & Time:</span
                                    >
                                    <input type="datetime-local" required />
                                  </div>
                                  <div class="input-box">
                                    <span class="details"
                                      >End Date & Time:</span
                                    >
                                    <input type="datetime-local" required />
                                  </div>

                                  <div class="input-box">
                                    <span class="details">Tractor Number</span>
                                    <select name="" id="">
                                      <option value="">--Select Tractor Number--</option>
                                      <option value="">112</option>
                                      <option value="">223</option>
                                    </select>
                                  </div>
                                  <div class="input-box">
                                    <span class="details">Task</span>
                                    <select name="" id="">
                                      <option value="">--Select Task--</option>
                                      <option value="">Land Clearing</option>
                                      <option value="">Construction</option>
                                    </select>
                                  </div>

                                  <div class="input-box">
                                    <span class="details">Hours Used:</span>
                                    <input type="number" required />
                                  </div>
                                  <div class="input-box">
                                    <span class="details">Area Covered:</span>
                                    <input type="number" required />
                                  </div>

                                  <div class="input-box">
                                    <span class="details">Note:</span>
                                    <textarea
                                      cols="83"
                                      rows="4"
                                      placeholder="Enter message"
                                      class="p-2"
                                    ></textarea>
                                  </div>
                                </div>

                              <div class="addNewButton mt-4">
                                <button
                                class="btn btn-secondary rounded me-3 mb-2 px-4 py-2"
                              >
                               Save
                              </button>
                            </div>
                              </form>
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
