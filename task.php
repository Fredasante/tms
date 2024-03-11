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
            <button class="logout-btn" type="button" onclick="location.href='logout.php'" class="logout">
                <i class="bx bxs-log-out-circle"></i>
                <span class="">Logout</span>
            </button>
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
    <script src="script.js"></script>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js
"></script>
  </body>
</html>
