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
          <a href="logout.php" class="logout">
            <i class="bx bxs-log-out-circle"></i>
            <span class="text-danger">Logout</span>
          </a>
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
        <a href="#" class="profile me-5">
          <img src="assets/images/people.png" />
        </a>
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
                  <h2>TRACTOR LIST</h2>
                  <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-3">
                      <label for="search">Search:</label>
                      <input
                        type="text"
                        class="form-control"
                        id="search"
                        placeholder="Enter keyword"
                      />
                    </div>
                    <div class="col-lg-3">
                      <label for="filterBy">Filter By:</label>
                      <select class="form-control" id="filterBy">
                        <option value="selectDefault">
                          Select option below
                        </option>
                        <option value="brand">Brand</option>
                        <option value="model">Model</option>
                        <option value="tractorNumber">Tractor Number</option>
                        <option value="hoursePower">Horsepower</option>
                      </select>
                    </div>
                    <div class="col-lg-2 mt-4">
                      <button class="btn btn-secondary text-semibold">
                        Filter
                      </button>
                    </div>
                    <!-- Button trigger modal -->
                    <div class="addNewButton col-lg-2 mt-4">
                      <button
                        type="button"
                        class="btn btn-primary rounded me-3 mb-2"
                        data-bs-toggle="modal"
                        data-bs-target="#tractorModal"
                      >
                        Add New
                      </button>
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
                          <th>Tractor Number</th>
                          <th>Brand</th>
                          <th>Model</th>
                          <th>Horsepower</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>GA 1234</td>
                          <td>Mahindra</td>
                          <td>White Field Boss 4-210</td>
                          <td>30</td>
                          <td>
                            <button class="btn btn-info btn-sm">Edit</button>
                          </td>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>GA 1234</td>
                          <td>Mahindra</td>
                          <td>White Field Boss 4-210</td>
                          <td>30</td>
                          <td>
                            <button class="btn btn-info btn-sm">Edit</button>
                          </td>
                        </tr>
                        <tr>
                          <td>3</td>
                          <td>GA 1234</td>
                          <td>Mahindra</td>
                          <td>White Field Boss 4-210</td>
                          <td>30</td>
                          <td>
                            <button class="btn btn-info btn-sm">Edit</button>
                          </td>
                        </tr>
                        <tr>
                          <td>4</td>
                          <td>GA 1234</td>
                          <td>Mahindra</td>
                          <td>White Field Boss 4-210</td>
                          <td>30</td>
                          <td>
                            <button class="btn btn-info btn-sm">Edit</button>
                          </td>
                        </tr>
                        <tr>
                          <td>5</td>
                          <td>GA 1234</td>
                          <td>Mahindra</td>
                          <td>White Field Boss 4-210</td>
                          <td>30</td>
                          <td>
                            <button class="btn btn-info btn-sm">Edit</button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </section>
                <!-- TRACTOR DETAILS TABLE ENDS -->

                <!-- Modal -->
                <div
                  class="modal fade"
                  id="tractorModal"
                  tabindex="-1"
                  aria-labelledby="addNewTractor"
                  aria-hidden="true"
                >
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addNewTractor">
                          Add New Tractor
                        </h1>
                        <button
                          type="button"
                          class="btn-close"
                          data-bs-dismiss="modal"
                          aria-label="Close"
                        ></button>
                      </div>
                      <div class="modal-body">
                        <!-- INPUT MODAL DETAILS FOR TRACTOR STARTS -->
                        <div id="signUp">
                          <div class="signup-container">
                            <div class="title">NEW TRACTOR REGISTRATION</div>
                            <p class=""></p>
                            <div class="content">
                              <form action="#">
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
                                    <span class="details"
                                      >Tractor Model/Brand</span
                                    >
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
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <!-- INPUT MODAL DETAILS FOR TRACTOR ENDS -->
                      </div>

                      <div class="modal-footer">
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
    <script src="script.js"></script>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js
"></script>
  </body>
</html>
