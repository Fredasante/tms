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

// Initialize variables with empty values
$name = '';
$email = '';
$phone = '';
$dateOfBirth = '';
$address = '';
$gender = '';
$typeOfUser = '';
$status = '';

$id = $_GET['updateid'];

$sql = "SELECT * FROM `users` WHERE id = $id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $name = $row['name'];
    $email = $row['email'];
    $phone = $row['phone'];
    $dateOfBirth = $row['date_of_birth'];
    $address = $row['address'];
    $gender = $row['gender'];
    $typeOfUser = $row['type_of_user'];
    $status = $row['status'];
} else {
    echo "User data not found";
}

if (isset($_POST['submit'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $typeOfUser = $_POST['typeOfUser'];
    $status = isset($_POST['status']) ? 'active' : 'inactive'; // Get status from checkbox

    // Update user information in the database
    $sql = "UPDATE `users` SET name=?, email = ?, phone = ?, date_of_birth = ?, address = ?, gender = ?, type_of_user = ?, status = ?, updated_at = NOW() WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssssssss", $name, $email, $phone, $dateOfBirth, $address, $gender, $typeOfUser, $status, $id);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            header('location:user-master.php');
        } else {
            echo 'No changes made';
        }

        mysqli_stmt_close($stmt);
    } else {
        echo 'Error in query preparation';
    }
}


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
          <a href="dashboard.php">
            <i class="bx bxs-user-account"></i>
            <span class="text">User Master</span>
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

        <div id="signUp" class="pt-4 pb-4">
          <div class="signup-container shadow">
            <div class="title">EDIT USER FORM</div>
            <div class="content">
              <form action="#" method="POST">
                <div class="form-check check-container gap-1 mt-4 mb-3">
                  <input type="checkbox" id="status" name="status" class="form-check-input" <?php echo ($status == 'active') ? 'checked' : ''; ?>>

                  <label class="form-check-label">Active </label>
                </div>
                <div class="user-details">
                   <div class="input-box">
                    <span class="details">Name</span>
                    <input type="text" placeholder="Enter name" required name="name" value="<?php echo $name; ?>" />
                  </div>
                  <div class="input-box">
                    <span class="details">Select type of user</span>
                    <select name="typeOfUser" id="" >
                      <option>Select type of user</option>
                      <option value="admin">Admin</option>
                      <option value="user">User</option>
                    </select>
                  </div>
                   <div class="input-box">
                    <span class="details">Email</span>
                    <input
                      type="email"
                      placeholder="Enter your email"
                      name="email"
                      value="<?php echo $email; ?>"
                      required
                    />
                  </div>
                  <div class="input-box">
                    <span class="details">Phone Number</span>
                    <input
                      type="text"
                      placeholder="Enter your number"
                      name="phone"
                      value="<?php echo $phone; ?>"
                      required
                    />
                  </div>
                 <div class="input-box">
                    <span class="details">Date of Birth</span>
                    <input type="date" required name="dateOfBirth" value="<?php echo $dateOfBirth; ?>"/>
                  </div>
                    <div class="input-box">
                    <span class="details">Address</span>
                    <input
                      type="text"
                      placeholder="Enter your address"
                      name="address"
                      value="<?php echo $address; ?>"
                      required
                    />
                  </div>
                  <div class="input-box hidden">
                    <span class="details">Password</span>
                    <input
                      type="password"
                      placeholder="Enter your password"
                      name="password"
                    />
                  </div>
                   <div class="input-box hidden">
                    <span class="details">Confirm Password</span>
                    <input
                      type="password"
                      placeholder="Confirm your password"
                      name="confirmPassword"
                    />
                  </div>
<!-- 
                <div class="input-box">
                    <span class="details">Select gender</span>
                    <select name="gender" id="">
                      <option value="default">Select gender</option>
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                    </select>
                  </div>
                </div> -->

                  <div class="gender-details col-5">
                    <input type="radio" id="male" name="gender" value="male" <?php if ($gender === 'male') echo 'checked'; ?>>
                    <input type="radio" id="female" name="gender" value="female" <?php if ($gender === 'female') echo 'checked'; ?>>
                    <span class="gender-title">Gender</span>
                    <div class="category">
                      <label for="male">
                        <span class="dot one"></span>
                        <span class="gender">Male</span>
                      </label>
                      <label for="female">
                        <span class="dot two"></span>
                        <span class="gender">Female</span>
                      </label>
                    </div>
                  </div> 
<!-- 
                  <div class="gender-details col-md-4">
                    <input type="radio" name="gender" id="male" />
                    <input type="radio" name="gender" id="female" />
                    <span class="gender-title">Gender</span>
                    <div class="category">
                      <label for="male">
                        <span class="dot one"></span>
                        <span class="gender">Male</span>
                      </label>
                      <label for="female">
                        <span class="dot two"></span>
                        <span class="gender">Female</span>
                      </label>
                    </div>
                  </div> -->

                  <div class="col-md-6 input-box">
                    <span class="details">Reset</span>
                    <button
                      id="toggleButton"
                      type="button"
                      class="btn btn-info"
                    >
                      Reset Password
                    </button>
                  </div>
                </div>

                <div class="d-flex align-items-center justify-content-end mt-5">
                  <button type="submit" name="submit" class="btn btn-secondary ps-4 pe-4">
                    Save Changes
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- CONTENT -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

      <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js
"></script>

    <!-- Link to custom JS file -->
    <script src="assets/js/script.js"></script>

  
  </body>
</html>
