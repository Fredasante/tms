<?php
include 'config.php';

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit;
}

// Retrieve the logged-in user's ID from the session
$user_id = $_SESSION['user_id'];

// Fetch tractor numbers from the database
$query = "SELECT TractorID, TractorNumber FROM tractors";
$result = mysqli_query($con, $query);
$tractor_numbers = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fetch tasks from the database
$query = "SELECT id, task_name FROM tasks WHERE active = 1"; // Assuming 'active' column indicates active tasks
$result = mysqli_query($con, $query);
$tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $start_datetime = $_POST['start_datetime'];
    $end_datetime = $_POST['end_datetime'];
    $tractor_number = $_POST['tractor_number']; // Adjusted to match the form field name
    $task_name = $_POST['task']; // Adjusted to match the form field name
    $hours_used = $_POST['hours_used'];
    $area_covered = $_POST['area_covered'];
    $note = $_POST['note'];

    // Get tractor ID based on tractor number
    $query = "SELECT TractorID FROM tractors WHERE TractorNumber = '$tractor_number'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $tractor_id = $row['TractorID'];

    // Get task ID based on task name
    $query = "SELECT id FROM tasks WHERE task_name = '$task_name'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $task_id = $row['id'];

    // Insert data into the database
    $query = "INSERT INTO TractorUsage (start_datetime, end_datetime, tractor_id, task_id, hours_used, area_covered, note, user_id, created_at, updated_at) 
              VALUES ('$start_datetime', '$end_datetime', '$tractor_id', '$task_id', '$hours_used', '$area_covered', '$note', '$user_id', NOW(), NOW())";
    
    // Execute the query
    $result = mysqli_query($con, $query);
    
    // Check if the insertion was successful
    if ($result) {
        // Redirect to daily-work.php
        header("Location: daily-work.php");
        exit; // Ensure that no further code is executed after redirection
    } else {
        echo "Error: " . mysqli_error($con);
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
              <a href="daily-work.php">
                <button class="mb-4 btn btn-secondary"><i class='bx bx-chevrons-left me-2'></i>
                Back
                </button>
              </a>
              <div class="title">DAILY WORK</div>
                            <p class="">
                              Fill in the details below to record daily work
                              activity.
                            </p>
                            <div class="content">
                           <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="user-details">
        <div class="input-box">
            <span class="details">Start Date & Time:</span>
            <input type="datetime-local" name="start_datetime" required />
        </div>
        <div class="input-box">
            <span class="details">End Date & Time:</span>
            <input type="datetime-local" name="end_datetime" required />
        </div>
        <div class="input-box">
            <span class="details">Tractor Number:</span>
            <select name="tractor_number" required>
                <option value="">--Select Tractor Number--</option>
                <?php foreach ($tractor_numbers as $tractor): ?>
                    <option value="<?php echo $tractor['TractorNumber']; ?>"><?php echo $tractor['TractorNumber']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="input-box">
            <span class="details">Task:</span>
            <select name="task" required>
                <option value="">--Select Task--</option>
                <?php foreach ($tasks as $task): ?>
                    <option value="<?php echo $task['task_name']; ?>"><?php echo $task['task_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="input-box">
            <span class="details">Hours Used:</span>
            <input type="number" name="hours_used" required />
        </div>
        <div class="input-box">
            <span class="details">Area Covered:</span>
            <input type="number" name="area_covered" required />
        </div>
        <div class="input-box">
            <span class="details">Note:</span>
            <textarea name="note" cols="83" rows="4" placeholder="Enter message" class="p-2"></textarea>
        </div>
    </div>
    <div class="addNewButton mt-4">
        <button type="submit" class="btn btn-secondary rounded me-3 mb-2 px-4 py-2">Save</button>
    </div>
</form>
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
