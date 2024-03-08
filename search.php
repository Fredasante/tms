<?php

include 'connect.php';

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
          <a href="Admin.php">
            <i class="bx bxs-user-account"></i>
            <span class="text">User Master</span>
          </a>
        </li>
        <li>
          <a href="Tractor.html">
            <img
              src="assets/images/tractor.png"
              style="height: 17px; margin-left: 13px; margin-right: 10px"
              alt="tractor icon"
            />
            <span class="text">Tractor Master</span>
          </a>
        </li>
        <li>
          <a href="Model.html">
            <i class="bx bxs-package"></i>
            <span class="text">Model Master</span>
          </a>
        </li>
        <li>
          <a href="Report.html">
            <i class="bx bxs-report"></i>
            <span class="text">Reports</span>
          </a>
        </li>
        <li>
          <a href="Task.html">
            <i class="bx bx-task"></i>
            <span class="text">Task Master</span>
          </a>
        </li>
        <li>
          <a href="User.html">
            <i class="bx bxs-group"></i>
            <span class="text">Daily Work</span>
          </a>
        </li>
      </ul>
      <ul class="side-menu">
        <li>
          <a href="#" class="logout">
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

      <div class="container">
        <div class="jumbotron text-center">
          <h1 class="display-4">TRACTOR MANAGEMENT SYSTEM</h1>
          <p class="lead">Efficiently manage your tractor fleet with ease.</p>

        </div>

        <!-- User Master Section -->
        <div class="">
          <div class="row">
            <div>
              <div class="card">
                <div class="card-header">
                  <h2>USER LIST</h2>
                  <div class="row">
                    <div class="col-lg-5"></div>
                
                    <form method="POST" class="col-lg-4">
                      <div class="input-group mb-3">
                        <input           
                          type="text"
                          class="form-control"
                          placeholder="Enter Search Query"
                          name="search"
                        />
                        <button class="btn btn-secondary" type="submit" name="submit">
                          Find
                        </button>
                      </div>
                    </form>                
                    
                    <!-- Button for adding new user -->
                    <div class="addNewButton col-lg-3">
                      <a href="add-user.php">
                        <button
                          type="button"
                          class="btn btn-secondary rounded me-3 mb-2"
                        >
                          <i class="bx bxs-user me-2"></i>
                          Add New
                        </button>
                      </a>
                    </div>
                  </div>
                </div>

                <!-- USER DETAILS TABLE STARTS -->
            
                  <section id="table" class="container">
                    <div class="row">
                      <table class="content-table">
                        <?php 
                          if (isset($_POST['submit'])) {
                            $search=$_POST['search'];
                            $sql = "Select * from `user` where user_id='$search'";
                            $result = mysqli_query($con,$sql);

                            if($result) {
                              $num = mysqli_num_rows($result);
                              echo $num;
                            }


                          }
                        ?>

                        <thead>
                          <tr>
                            <th>Sr. No</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Status</th>
                            <th>Edit</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php

                            $sql = "SELECT user_id, first_name, last_name, email, phone, status FROM user";

                            $result = mysqli_query($con, $sql);

                            if (mysqli_num_rows($result) > 0) {
                            // Output data of each row
                               while ($row = mysqli_fetch_assoc($result)) {
                              ?>
                            <tr>
                              <td><?php echo $row["user_id"]; ?></td>
                              <td><?php echo $row["first_name"]; ?></td>
                              <td><?php echo $row["last_name"]; ?></td>
                              <td><?php echo $row["email"]; ?></td>
                              <td><?php echo $row["phone"]; ?></td>
                              <td><?php echo $row["status"]; ?></td>
                                <td>
                                <a href="update-user.php?updateid=<?php echo $row["user_id"]; ?>">  
                                  <button type="button" class="btn btn-info btn-sm"> View</button>
                                </a>
                              </td> 
                           </tr>
                          <?php
                        }
                        } else {
                          ?>
                         <tr>
                          <td colspan="7">No users found</td>
                        </tr>
                          <?php
                              }
                           ?>                         
                        </tbody>
                      </table>
                    </div>
                  </section>
                <!-- USER DETAILS TABLE ENDS -->
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
