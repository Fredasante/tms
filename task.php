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
                  <h2>TASKS</h2>
                </div>

                <!-- MODEL DETAILS TABLE STARTS -->
                <section id="table" class="container">
                  <div class="row p-2 gap-5">
                    <table class="content-table col-lg-6">
                      <thead>
                        <tr>
                          <th>Sr. No</th>
                          <th>Task Name</th>
                          <th>Active</th>
                          <th>Edit</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>Plowing</td>
                          <td>Yes</td>
                          <td>
                            <button class="btn btn-info btn-sm">View</button>
                          </td>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>Plowing</td>
                          <td>Yes</td>
                          <td>
                            <button class="btn btn-info btn-sm">View</button>
                          </td>
                        </tr>
                        <tr>
                          <td>3</td>
                          <td>Plowing</td>
                          <td>Yes</td>
                          <td>
                            <button class="btn btn-info btn-sm">View</button>
                          </td>
                        </tr>
                        <tr>
                          <td>4</td>
                          <td>Plowing</td>
                          <td>Yes</td>
                          <td>
                            <button class="btn btn-info btn-sm">View</button>
                          </td>
                        </tr>
                        <tr>
                          <td>5</td>
                          <td>Plowing</td>
                          <td>Yes</td>
                          <td>
                            <button class="btn btn-info btn-sm">View</button>
                          </td>
                        </tr>
                      </tbody>
                    </table>

                    <form action="#" class="col-lg-5">
                      <div class="user-details row">
                        <div class="input-box col-md-6">
                          <span class="details">Code:</span>
                          <input type="text" />
                        </div>
                        <div class="form-check col-md-5 ms-5 mt-4 mb-4">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            value=""
                            checked
                          />
                          <label class="form-check-label"> isActive </label>
                        </div>
                      </div>
                      <span class="h6">Task:</span>
                      <div class="input-group input-box mt-1">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Enter task"
                        />
                        <button
                          class="btn btn-primary rounded-end me-3"
                          type="button"
                        >
                          Update
                        </button>
                        <button
                          class="btn btn-outline-secondary rounded"
                          type="button"
                        >
                          Clear
                        </button>
                      </div>
                    </form>
                  </div>
                </section>
                <!-- MODEL DETAILS TABLE ENDS -->
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
