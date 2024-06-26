<?php
// Include configuration file
require 'config.php';

// Start session
session_start();

// Check if the user is authenticated and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    // Redirect to the login page or an unauthorized access page
    header('Location: login.php'); // or header('Location: unauthorized.php');
    exit(); // Stop further execution
}

// User is authenticated and is an admin, continue to admin-dashboard page

// Function to fetch record by ID from the database
function fetchRecordByID($conn, $modelID) {
    $sql = "SELECT * FROM TractorModels WHERE ModelID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $modelID);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Check if the form is submitted for adding or editing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if adding a new record
    if (isset($_POST['add'])) {
        // Retrieve form data for adding a new record
        $modelName = $_POST['modelName'];
        $isActive = isset($_POST['isActive']) ? 1 : 0; // Convert checkbox value to boolean

        // Insert data into the database
        $sql = "INSERT INTO TractorModels (ModelName, Active) VALUES (?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $modelName, $isActive);

        if ($stmt->execute()) {
            echo "New record added successfully";
        } else {
            echo "Error adding new record: " . $stmt->error;
        }
    }
    // Check if editing an existing record
    elseif (isset($_POST['edit'])) {
        // Retrieve form data for editing an existing record
        $modelID = $_POST['model_id'];
        $updatedModelName = $_POST['modelName'];
        $updatedActive = isset($_POST['isActive']) ? 1 : 0; // Convert checkbox value to boolean

        // Update the record in the database
        $sql = "UPDATE TractorModels SET ModelName = ?, Active = ? WHERE ModelID = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sii", $updatedModelName, $updatedActive, $modelID);

        if ($stmt->execute()) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $stmt->error;
        }
    }
}

// Check if the form is submitted for viewing
if (isset($_POST['view'])) {
    // Get the ID of the record
    $modelID = $_POST['model_id'];

    // Fetch the record from the database based on the ID
    $record = fetchRecordByID($con, $modelID);

    if ($record) {
        // Populate the form fields with the fetched data
        $modelName = $record["ModelName"];
        $isActive = $record["Active"];
        // You can then use these variables to populate the input fields in your HTML form
    } else {
        echo "Record not found";
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
          <a href="work-master.php" <?php if (basename($_SERVER['PHP_SELF']) == 'work-master.php') echo 'class="active"'; ?>>
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
                  <h2>MODEL</h2>
                </div>

                <!-- MODEL DETAILS TABLE STARTS -->
                <section id="table" class="container">
                  <div class="row p-2 gap-5">
                    <table class="content-table col-lg-6">
                      <thead>
                        <tr>
                          <th>Sr. No</th>
                          <th>Tractor Model</th>
                          <th>Active</th>
                          <th>Edit</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      // Fetch records from the database
                      $sql = "SELECT * FROM TractorModels";
                      $result = $con->query($sql);

                      if ($result->num_rows > 0) {
                      $srNo = 1;
                      while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $srNo++ . "</td>";
                        echo "<td>" . $row["ModelName"] . "</td>";
                        echo "<td>" . ($row["Active"] ? "Yes" : "No") . "</td>";
                        echo "<td><form method='post'><input type='hidden' name='model_id' value='" . $row["ModelID"] . "'><button type='submit' name='view' class='btn btn-info btn-sm'>View</button></form></td>";
                        echo "</tr>";
                      }
                    } else {
                      echo "<tr><td colspan='4'>No records found</td></tr>";
                    }
                    ?>
                    </tbody>
              
                    </table>

                      <?php if(isset($modelName)): ?>
                          <!-- Form to edit record -->
                          <form class="col-lg-5" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                              <input type="hidden" name="model_id" value="<?php echo $modelID; ?>">
                            <div class="user-details">
                              <div class="input-box">
                                  <label class="mb-2" for="modelName">Model Name:</label>
                                  <input type="text" id="modelName" name="modelName" value="<?php echo $modelName; ?>">
                              </div>
                            </div>
                              <div class="mt-4 mb-4">
                                  <input type="checkbox" id="isActive" name="isActive" <?php echo $isActive ? 'checked' : ''; ?>>
                                  <label for="isActive">Active</label>
                              </div>
                              <button class="btn btn-primary" type="submit" name="edit">Save</button>
                              <button class="btn btn-secondary" type="button" onclick="clearForm()">Clear</button>
                          </form>
                        <?php else: ?>
                          <!-- Form to add new record -->
                          <form class="col-lg-5" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="user-details">
                              <div class="input-box">
                                  <label class="mb-2" for="modelName">Model Name:</label>
                                  <input type="text" id="modelName" name="modelName">
                              </div>
                            </div>
                              <div class="mt-4 mb-4">
                                  <input type="checkbox" id="isActive" name="isActive" checked>
                                  <label for="isActive">Active</label>
                              </div>
                              <button class="btn btn-primary" type="submit" name="add">Add New</button>
                              <button class="btn btn-secondary" type="button" onclick="clearForm()">Clear</button>
                          </form>
                      <?php endif; ?>

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
    <script src="assets/js/script.js"></script>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js
"></script>
  </body>
</html>
