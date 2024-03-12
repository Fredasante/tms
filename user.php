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
                        <img src="assets/images/tractor.png" style="height: 17px; margin-left: 13px; margin-right: 10px" alt="tractor icon" />
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
            <?php endif; ?>
            <li>
                <a href="user.php">
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
                    <div class="col-lg-6 mt-4">
                      <div class="filter-container">
                        <label class="mt-1">From:</label>
                        <input type="date" class="date-input ms-2 me-2" />
                        <label class="mt-1">To:</label>
                        <input type="date" class="date-input ms-2 me-2" />
                        <div class="altBtn col-lg-2">
                          <button
                            type="button"
                            class="btn btn-secondary rounded ms-1 mb-2"
                          >
                            Filter
                          </button>
                        </div>
                      </div>
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
                      <button
                        type="button"
                        class="btn btn-secondary rounded me-3 mb-2"
                        data-bs-toggle="modal"
                        data-bs-target="#userModal"
                      >
                        Add New
                      </button>
                    </div>
                  </div>
                </div>

                <!-- USER DETAILS TABLE STARTS -->
                <section id="table" class="container">
                  <div class="row">
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
                        <tr>
                          <td>24/01/2023</td>
                          <td>Plowing</td>
                          <td>5</td>
                          <td>2000</td>
                          <td>112233</td>
                        </tr>
                        <tr>
                          <td>24/01/2023</td>
                          <td>Plowing</td>
                          <td>5</td>
                          <td>2000</td>
                          <td>112233</td>
                        </tr>
                        <tr>
                          <td>24/01/2023</td>
                          <td>Plowing</td>
                          <td>5</td>
                          <td>2000</td>
                          <td>112233</td>
                        </tr>
                        <tr>
                          <td>24/01/2023</td>
                          <td>Plowing</td>
                          <td>5</td>
                          <td>2000</td>
                          <td>112233</td>
                        </tr>
                        <tr>
                          <td>24/01/2023</td>
                          <td>Plowing</td>
                          <td>5</td>
                          <td>2000</td>
                          <td>112233</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </section>
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
                                    <input
                                      type="text"
                                      placeholder="Enter Tractor Number"
                                      required
                                    />
                                  </div>
                                  <div class="input-box">
                                    <span class="details">Task</span>
                                    <select name="" id="">
                                      <option value="">Plowing</option>
                                      <option value="">Land Clearing</option>
                                      <option value="">Construction</option>
                                      <option value="">Harvesting</option>
                                      <option value="">Cultivating</option>
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
                              </form>
                            </div>
                          </div>
                        </div>
                        <!-- INPUT MODAL DETAILS FOR TASK ENDS -->
                      </div>

                      <div class="modal-footer me-5">
                        <div class="addNewButton">
                          <button
                            type="button"
                            class="btn btn-primary pt-2 ps-5 pe-5 pb-2"
                          >
                            Save
                          </button>
                        </div>
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
