<?php
include 'config.php';

// Check if the ID parameter is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch data from the database based on the provided ID
    $query = "SELECT * FROM TractorUsage WHERE id = $id";
    $result = mysqli_query($con, $query);

    // Check if the record exists
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Initialize variables with fetched data
        $start_datetime = $row['start_datetime'];
        $end_datetime = $row['end_datetime'];
        $tractor_id = $row['tractor_id'];
        $task_id = $row['task_id'];
        $hours_used = $row['hours_used'];
        $area_covered = $row['area_covered'];
        $note = $row['note'];
    } else {
        echo "Record not found";
        exit; // Stop further execution if record not found
    }
} else {
    echo "ID parameter not provided";
    exit; // Stop further execution if ID parameter not provided
}

// Fetch tractor numbers from the database
$tractor_query = "SELECT TractorID, TractorNumber FROM tractors";
$tractor_result = mysqli_query($con, $tractor_query);

// Fetch tasks from the database
$task_query = "SELECT id, task_name FROM tasks";
$task_result = mysqli_query($con, $task_query);

// Handle form submission for updating the record
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $start_datetime = $_POST['start_datetime'];
    $end_datetime = $_POST['end_datetime'];
    $tractor_id = $_POST['tractor_id'];
    $task_id = $_POST['task_id'];
    $hours_used = $_POST['hours_used'];
    $area_covered = $_POST['area_covered'];
    $note = $_POST['note'];

    // Update the record in the database
    $update_query = "UPDATE TractorUsage SET start_datetime = '$start_datetime', end_datetime = '$end_datetime', tractor_id = '$tractor_id', task_id = '$task_id', hours_used = '$hours_used', area_covered = '$area_covered', note = '$note' WHERE id = $id";

    if (mysqli_query($con, $update_query)) {
        // Redirect to work-master.php after updating the record
        header("Location: work-master.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($con);
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

    <title>Admin Hub</title>
  </head>
  <body>
    <!-- SIDEBAR -->
  <section id="sidebar">
    <a href="#" class="brand">
        <i class="bx bxs-smile"></i>
        <span class="text">Admin Hub</span>
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
          <a href="task.php" <?php if (basename($_SERVER['PHP_SELF']) == 'task.php') echo 'class="active"'; ?>>
            <i class="bx bx-task"></i>
            <span class="text">Work Master</span>
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

      <div id="work" class="container">
        <div class="jumbotron text-center">
          <h1 class="display-4">TRACTOR MANAGEMENT SYSTEM</h1>
          <p class="lead">Efficiently manage your tractor fleet with ease.</p>
        </div>

        <!-- User Section -->
        <div>
          <div id="signUp">
            <div class="signup-container">
              <a href="work-master.php">
                <button class="mb-4 btn btn-secondary"><i class='bx bx-chevrons-left me-2'></i>
                Back
                </button>
              </a>
              <div class="title">EDIT WORK DETAILS</div>                         
                            <div class="content">
  <form method="post" action="">
    <div class="user-details">
        <div class="input-box">
            <span class="details">Start Date & Time:</span>
            <input type="datetime-local" name="start_datetime" value="<?php echo $start_datetime; ?>" required />
        </div>
        <div class="input-box">
            <span class="details">End Date & Time:</span>
            <input type="datetime-local" name="end_datetime" value="<?php echo $end_datetime; ?>" required />
        </div>
        <div class="input-box">
            <span class="details">Tractor Number:</span>
            <select name="tractor_id" required>
                <?php while ($tractor_row = mysqli_fetch_assoc($tractor_result)): ?>
                    <option value="<?php echo $tractor_row['TractorID']; ?>" <?php echo ($tractor_row['TractorID'] == $tractor_id) ? 'selected' : ''; ?>><?php echo $tractor_row['TractorNumber']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="input-box">
            <span class="details">Task:</span>
            <select name="task_id" required>
                <?php while ($task_row = mysqli_fetch_assoc($task_result)): ?>
                    <option value="<?php echo $task_row['id']; ?>" <?php echo ($task_row['id'] == $task_id) ? 'selected' : ''; ?>><?php echo $task_row['task_name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="input-box">
            <span class="details">Hours Used:</span>
            <input type="number" name="hours_used" value="<?php echo $hours_used; ?>" required />
        </div>
        <div class="input-box">
            <span class="details">Area Covered:</span>
            <input type="number" name="area_covered" value="<?php echo $area_covered; ?>" required />
        </div>
        <div class="input-box">
            <span class="details">Note:</span>
            <textarea name="note" cols="83" rows="4" placeholder="Enter message" class="p-2"><?php echo $note; ?></textarea>
        </div>
    </div>
    <div class="addNewButton mt-4">
        <button type="submit" class="btn btn-secondary rounded me-3 mb-2 px-4 py-2">Update</button>
    </div>
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
