<?php
include 'config.php';

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit;
}

// Check if the record ID is provided in the URL
if (isset($_GET['id'])) {
    // Retrieve the record ID from the URL
    $record_id = $_GET['id'];

    // Fetch the record details from the database based on the ID
    $query = "SELECT * FROM TractorUsage WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $record_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the record details
        $record = mysqli_fetch_assoc($result);

        // Populate the form fields with the record details
        $start_datetime = $record['start_datetime'];
        $end_datetime = $record['end_datetime'];
        $tractor_id = $record['tractor_id'];
        $task_id = $record['task_id'];
        $hours_used = $record['hours_used'];
        $area_covered = $record['area_covered'];
        $note = $record['note'];

        // Fetch available tractor numbers
        $query_tractors = "SELECT TractorID, TractorNumber FROM Tractors";
        $result_tractors = mysqli_query($con, $query_tractors);
        $tractors = mysqli_fetch_all($result_tractors, MYSQLI_ASSOC);

        // Fetch available tasks
        $query_tasks = "SELECT id, task_name FROM tasks";
        $result_tasks = mysqli_query($con, $query_tasks);
        $tasks = mysqli_fetch_all($result_tasks, MYSQLI_ASSOC);

        // Check if the form is submitted
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
            $query_update = "UPDATE TractorUsage SET start_datetime = ?, end_datetime = ?, tractor_id = ?, task_id = ?, hours_used = ?, area_covered = ?, note = ? WHERE id = ?";
            $stmt_update = mysqli_prepare($con, $query_update);
            mysqli_stmt_bind_param($stmt_update, "ssiiidsi", $start_datetime, $end_datetime, $tractor_id, $task_id, $hours_used, $area_covered, $note, $record_id);
            $result_update = mysqli_stmt_execute($stmt_update);

            if ($result_update) {
                // Record updated successfully
                echo "Record updated successfully.";
                header("Location: daily-work.php");

            } else {
                // Error updating record
                echo "Error updating record: " . mysqli_error($con);
            }
        }
    } else {
        // Record not found, handle the error (redirect, display message, etc.)
        echo "Record not found.";
        exit;
    }
} else {
    // Record ID is not provided in the URL, handle the error (redirect, display message, etc.)
    echo "Record ID is missing.";
    exit;
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
              <div class="title">UPDATE WORK DETAILS</div>
                            <p class="">
                              Fill in the details below to update daily work
                              activity.
                            </p>
                            <div class="content">

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $record_id; ?>">
                      <div class="user-details">
                          <div class="input-box">
                              <span class="details">Start Date & Time:</span>
                              <input type="datetime-local" id="start_datetime" name="start_datetime" value="<?php echo $start_datetime; ?>" required />
                          </div>
                          <div class="input-box">
                              <span class="details">End Date & Time:</span>
                              <input type="datetime-local" id="end_datetime" name="end_datetime" value="<?php echo $end_datetime; ?>" required />
                          </div>
                          <div class="input-box">
                              <span class="details">Tractor Number:</span>
                              <select id="tractor_id" name="tractor_id" required>
                                    <?php foreach ($tractors as $tractor): ?>
                                        <option value="<?php echo $tractor['TractorID']; ?>" <?php if ($tractor['TractorID'] == $tractor_id) echo "selected"; ?>>
                                            <?php echo $tractor['TractorNumber']; ?>
                                        </option>
                                    <?php endforeach; ?>
                              </select>
                          </div>
                          <div class="input-box">
                              <span class="details">Task:</span>
                              <select id="task_id" name="task_id" required>
                                  <?php foreach ($tasks as $task): ?>
                                      <option value="<?php echo $task['id']; ?>" <?php if ($task['id'] == $task_id) echo "selected"; ?>>
                                          <?php echo $task['task_name']; ?>
                                      </option>
                                  <?php endforeach; ?>
                              </select>
                          </div>
                          <div class="input-box">
                              <span class="details">Hours Used:</span>
                              <input type="number" id="hours_used" name="hours_used" value="<?php echo $hours_used; ?>" readonly />
                          </div>
                          <div class="input-box">
                              <span class="details">Area Covered (acres):</span>
                              <input type="number" name="area_covered" value="<?php echo $area_covered; ?>" required />
                          </div>
                          <div class="input-box">
                              <span class="details">Note:</span>
                              <textarea name="note" cols="83" rows="4" class="p-2"><?php echo $note; ?></textarea>
                          </div>
                      </div>
                      <div class="addNewButton mt-4">
                          <button type="submit" class="btn btn-secondary rounded me-3 mb-2 px-4 py-2">Save</button>
                      </div>
                </form>
                  </div>
              </div>
          </div>  
        </div>
      </div>
    </section>
    <!-- CONTENT -->

    <script>
        // Function to calculate the difference in hours between two date/time strings
        function calculateHoursDifference(startDateTime, endDateTime) {
            const start = new Date(startDateTime);
            const end = new Date(endDateTime);
            const differenceMilliseconds = Math.abs(end - start);
            const differenceHours = differenceMilliseconds / (1000 * 60 * 60);
            return differenceHours.toFixed(2); // Return difference rounded to 2 decimal places
        }

        // Function to update the hours used field when start or end datetime is changed
        function updateHoursUsed() {
            const startDateTime = document.getElementById('start_datetime').value;
            const endDateTime = document.getElementById('end_datetime').value;
            const hoursUsed = calculateHoursDifference(startDateTime, endDateTime);
            document.getElementById('hours_used').value = hoursUsed;
        }

        // Add event listeners to start and end datetime inputs
        document.getElementById('start_datetime').addEventListener('change', updateHoursUsed);
        document.getElementById('end_datetime').addEventListener('change', updateHoursUsed);

        // Initial update of hours used field
        updateHoursUsed();
    </script>

    <!-- Link to custom JS file -->
    <script src="assets/js/script.js"></script>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js
"></script>
  </body>
</html>
