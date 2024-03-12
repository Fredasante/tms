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

// Function to generate a random six-digit code
function generateCode() {
    return str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

// Initialize variables with empty values
$name = '';
$email = '';
$phone = '';
$dateOfBirth = '';
$address = '';
$password = '';
$confirmPassword = '';
$gender = '';
$typeOfUser = '';

$errors = array(); // Array to store validation errors

if (isset($_POST['submit'])) {
    // Retrieve form data and sanitize inputs
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $dateOfBirth = mysqli_real_escape_string($con, $_POST['dateOfBirth']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($con, $_POST['confirmPassword']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $typeOfUser = mysqli_real_escape_string($con, $_POST['typeOfUser']);

    // Check if password and confirm password match
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match";
    }

    // Generate a unique six-digit code
    $code = generateCode();
    while (true) {
        $sql_check_code = "SELECT * FROM `users` WHERE code = ?";
        $stmt_check_code = mysqli_prepare($con, $sql_check_code);
        mysqli_stmt_bind_param($stmt_check_code, "s", $code);
        mysqli_stmt_execute($stmt_check_code);
        $result_check_code = mysqli_stmt_get_result($stmt_check_code);
        if (mysqli_num_rows($result_check_code) == 0) {
            break;
        }
        $code = generateCode();
    }

    // Proceed with form submission if no validation errors
    if (empty($errors)) {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement
        $sql = "INSERT INTO `users` (name, email, phone, date_of_birth, address, password, gender, type_of_user, code, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

        // Bind parameters and execute the statement
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssss", $name, $email, $phone, $dateOfBirth, $address, $hashedPassword, $gender, $typeOfUser, $code);
        $result = mysqli_stmt_execute($stmt);

        // Check if the query was successful
        if ($result) {
            header('location:user-master.php');
            exit(); // Ensure script stops execution after redirect
        } else {
            die(mysqli_error($con));
        }

        // Close the statement
        mysqli_stmt_close($stmt);
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
              <a href="user-master.php">
                <button class="btn btn-secondary ps-3 pe-3 mb-4">
                  <i class="bx bxs-chevrons-left"></i>
                  User List
                </button></a
              >
            </div>
            <div class="title">NEW USER REGISTRATION</div>
            <p class="">Fill the form below to register a new user</p>

            <div class="content">
              <form id="add-user-form" action="" method="POST">
                <div class="user-details">
                   <div class="input-box">
                    <span class="details">Name</span>
                    <input type="text" placeholder="Enter name" required name="name" />
                  </div>
                  <div class="input-box">
                    <span class="details">Select type of user</span>
                    <select name="typeOfUser" id="" required>
                      <option value="defaultSelect">Select type of user</option>
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
                      required
                    />
                  </div>
                  <div class="input-box">
                    <span class="details">Phone Number</span>
                    <input
                      type="text"
                      placeholder="Enter your number"
                      name="phone"
                      required
                    />
                  </div>
                  <div class="input-box">
                    <span class="details">Date of Birth</span>
                    <input type="date" required name="dateOfBirth"/>
                  </div>
                  <div class="input-box">
                    <span class="details">Address</span>
                    <input
                      type="text"
                      placeholder="Enter your address"
                      name="address"
                      required
                    />
                  </div>
                  <div class="input-box">
                    <span class="details">Password</span>
                    <input
                      type="password"
                      placeholder="Enter your password"
                      name="password"
                      required
                    />
                  </div>
                  <div class="input-box">
                    <span class="details">Confirm Password</span>
                    <input
                      type="password"
                      placeholder="Confirm your password"
                      name="confirmPassword"
                      required
                    />
                  </div>

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
                <div class="input-box">
                    <span class="details">Select gender</span>
                    <select name="gender" id="">
                      <option value="defaultSelect">Select gender</option>
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                    </select>
                  </div>
                </div> -->

                 <!-- Display validation errors -->
                  <?php if (!empty($errors)): ?>
                   <div class="alert alert-danger">
                      <ul>
                    <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                    </ul>
                   </div>
                  <?php endif; ?>

                <div class="d-flex align-items-center justify-content-end mt-5">
                  <button type='submit' class="btn btn-secondary ps-4 pe-4" name="submit">Save</button>
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
