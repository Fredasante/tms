<?php
// Include configuration file
require 'config.php';

// Start the session
session_start();

// Define variables to store alert messages
$alertMessage = '';

if (isset($_POST['submit'])) {
    // Check if $con is a valid MySQL connection object
    if ($con) {
        // Retrieve form data and sanitize inputs
        $loginCode = isset($_POST['loginCode']) ? mysqli_real_escape_string($con, $_POST['loginCode']) : '';
        $password = isset($_POST['password']) ? mysqli_real_escape_string($con, $_POST['password']) : '';

        // Check if loginCode and password are set
        if (!empty($loginCode) && !empty($password)) {
            // Query to select user based on loginCode
            $sql = "SELECT * FROM users WHERE code = '$loginCode'";
            $result = mysqli_query($con, $sql);

            if ($result) {
                // Check if user with the given loginCode exists
                if (mysqli_num_rows($result) > 0) {
                    // Fetch the user data
                    $user = mysqli_fetch_assoc($result);

                    // Verify password
                    if (password_verify($password, $user['password'])) {
                        // Check if user is active
                        if ($user['status'] === 'active') {
                            // Password is correct and user is active, proceed with authentication
                            // Set session variables
                            $_SESSION['user_id'] = $user['id'];
                            $_SESSION['user_type'] = $user['type_of_user'];

                            // Insert login record into login history table
                            $ip_address = $_SERVER['REMOTE_ADDR'];
                            $user_id = $user['id'];
                            $sql_insert_login = "INSERT INTO login_history (user_id, ip_address) VALUES ('$user_id', '$ip_address')";
                            mysqli_query($con, $sql_insert_login);

                            // Redirect the user to the dashboard
                            if ($_SESSION['user_type'] === 'admin') {
                                header('location: dashboard.php');
                            } else {
                                header('location: daily-work.php');
                            }
                            exit();
                        } else {
                            // User is inactive, display error message
                            $alertMessage = '<div class="alert alert-danger text-center" role="alert">Your account is inactive. Please contact the administrator.</div>';
                        }
                    } else {
                        // Password is incorrect
                        $alertMessage = '<div class="alert alert-danger text-center" role="alert">Incorrect password credentials</div>';
                    }
                } else {
                    // User with the given loginCode does not exist
                    $alertMessage = '<div class="alert alert-danger text-center" role="alert">User not found</div>';
                }
            } else {
                // Error executing the query
                $alertMessage = '<div class="alert alert-danger text-center" role="alert">Error: ' . mysqli_error($con) . '</div>';
            }
        } else {
            // LoginCode or password is empty
            $alertMessage = '<div class="alert alert-warning text-center" role="alert">LoginCode or password cannot be empty</div>';
        }
    } else {
        $alertMessage = '<div class="alert alert-danger text-center" role="alert">Error: Unable to connect to the database</div>';
    }
}
?>







<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tractor Management System</title>
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="assets/css/style.css" />
  </head>
  <body>
    <div id="login" class="container-all">
      <div class="row">
        <div class="col-md-6 hero-image"></div>

        <div class="col-md-6 col2">
          <div class="container-content text-center">
            <h4 class="fw-bold">TRACTOR MANAGEMENT SYSTEM</h4>
            <div class="tractor-div mx-auto"></div>

            <div class="mt-2 error-container">
            <?php echo $alertMessage; ?>

            </div>


          <form action="" method="post" autocomplete="off">
            <h6>Login ID</h6>
            <div class="form-container">
              <input type="number" placeholder="Enter Your Login ID" name="loginCode" id="loginCode" required />
              <button class="normal"></button>
            </div>

            <h6 class="mt-4">Password</h6>
            <div class="form-container">
              <input type="password" placeholder="Enter Your Password" name="password" id="password" required />
              <button class="normal"></button>
            </div>

            <div class="row mt-3">
              <div class="col-12" style="text-align: center !important">
                <button type="submit" name="submit" class="mt-4 submit rounded">Login</button>
              </div>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>
</html>
