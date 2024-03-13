

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

      <div class="container">
        <div class="jumbotron text-center">
          <h1 class="display-4">TRACTOR MANAGEMENT SYSTEM</h1>
          <p class="lead">Efficiently manage your tractor fleet with ease.</p>
        </div>

        <div id="signUp" class="pt-4 pb-4">
          <div class="signup-container shadow">
            <div class="mb-3">
              <a href="tractor-master.php">
                <button class="btn btn-secondary ps-3 pe-3 mb-4">
                  <i class="bx bxs-chevrons-left"></i>
                  Tractor List
                </button></a
              >
            </div>
            <div class="title">NEW TRACTOR REGISTRATION</div>
            <p class="">Fill the form below to register a new tractor</p>

            <div class="content">
              <form id="add-user-form" action="" method="POST">
                <div class="user-details">
                  <div class="input-box">
                      <span class="details">Tractor Number</span>
                      <input
                        type="text"
                        placeholder="Enter tractor number"
                         required
                      />
                  </div>
                    <div class="input-box">
                      <span class="details">Serial Number</span>
                      <input
                        type="text"
                        placeholder="Enter serial number"
                        required
                      />
                    </div>
                    <div class="input-box">
                      <span class="details">Tractor Model/Brand</span>
                      <select name="" id="">
                          <option value="defaultSelect">
                          Select type of model
                          </option>
                          <option value="mahindra">Mahindra</option>
                          <option value="holland">
                           New Holland
                          </option>
                         <option value="horse">Wheel Horse</option>
                      </select>
                    </div>
                    <div class="input-box">
                      <span class="details">Horsepower</span>
                      <input type="number" required />
                    </div>               
      
                    
                    <div class="addNewButton mt-5 ms-auto">
                      <button
                        type="button"
                        class="btn btn-primary pt-2 ps-5 pe-5 pb-2">
                        Save
                      </button>
                    </div>             
              </form>
            </div>
          </div>
        </div>
        <!-- INPUT MODAL DETAILS FOR USER ENDS -->
      </div>
    </section>
    <!-- CONTENT -->


    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js
"></script>

    <!-- Link to custom JS file -->
    <script src="assets/js/script.js"></script>

  </body>
</html>
