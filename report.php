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

// Include the TCPDF library
require_once('tcpdf/tcpdf.php');

// Initialize variable to hold PDF content
$pdf_content = '';

// Check if the form is submitted for generating the report
if (isset($_POST['generate_report'])) {
    // Write SQL query to fetch tractor usage data
    $sql_tractors = "SELECT DISTINCT tractor_id, TractorNumber FROM TractorUsage JOIN tractors ON TractorUsage.tractor_id = tractors.TractorID";
    $result_tractors = mysqli_query($con, $sql_tractors);

    if ($result_tractors) {
        // Create new PDF document
        $pdf = new TCPDF();

        // Add a page
        $pdf->AddPage();

        // Set background color and text color for the title
        $pdf->SetFillColor(13, 34, 90); // Background color
        $pdf->SetTextColor(255, 255, 255); // Text color

        // Set font for the title
        $pdf->SetFont('helvetica', 'B', 16);

        // Title
        $pdf->Cell(0, 15, 'TRACTOR USAGE REPORT', 0, 1, 'C', true); // Title

        // Reset text color to black
        $pdf->SetTextColor(0, 0, 0); // Black color

        // Set font for the descriptive text
        $pdf->SetFont('helvetica', '', 12);

        // Descriptive Text
        $pdf->Cell(0, 13, 'This report contains information about the tractor usage in the management system.', 0, 1, 'C'); // Descriptive text
        $pdf->Ln(5); // Add space of 5 units    

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Fetch and output tractor usage summary
        while ($row_tractor = mysqli_fetch_assoc($result_tractors)) {
            // Write SQL query to fetch tractor usage details
            $sql_usage = "SELECT SUM(hours_used) AS total_hours, SUM(area_covered) AS total_area_covered FROM TractorUsage WHERE tractor_id = {$row_tractor['tractor_id']}";
            $result_usage = mysqli_query($con, $sql_usage);
            $row_usage = mysqli_fetch_assoc($result_usage);

            // Output tractor usage summary
            $usage_summary = "Tractor number {$row_tractor['TractorNumber']} has been used for a total of {$row_usage['total_hours']} hours and has covered an area of {$row_usage['total_area_covered']} square meters.";
            $pdf->MultiCell(0, 10, $usage_summary, 0, 'L');
            $pdf->Ln(3); // Add space of 3 units
        }

        // Set some content to print
        $html = <<<EOD
        <h2>Tabular report on <a href="http://www.tms.org" style="text-decoration:none;background-color: #2596be;color:black;">&nbsp;<span style="color:black;">TRACTOR</span><span style="color:white;"> USAGE</span>&nbsp;</a>!</h2>
        <p style="color:#CC0000;">TABLE STATISTICS</p>
        EOD;

        // Include HTML table structure with classes and styles
        $html .= '<section id="table" class="container">
            <div class="row">
                <table class="content-table" border="1" cellspacing="0" cellpadding="8">
                    <thead style="background-color: #f2f2f2;">
                        <tr style="background-color: #e6eaed;">
                            <th>Sr. No</th>
                            <th>Start Datetime</th>
                            <th>End Datetime</th>
                            <th>Task</th>
                            <th>Hours Used</th>
                            <th>Area Covered (m)</th>
                            <th>Tractor Number</th>
                        </tr>
                    </thead>
                    <tbody>';

        // Write SQL query to fetch tractor usage data
        $sql_usage_data = "SELECT tu.id, tu.start_datetime, tu.end_datetime, tu.hours_used, tu.area_covered, t.task_name, tr.TractorNumber 
            FROM TractorUsage tu
            INNER JOIN tasks t ON tu.task_id = t.id
            INNER JOIN tractors tr ON tu.tractor_id = tr.TractorID";
        $result_usage_data = mysqli_query($con, $sql_usage_data);

        // Fetch and output tractor usage data
        $counter = 1;
        while ($row = mysqli_fetch_assoc($result_usage_data)) {
            $html .= '<tr>';
            $html .= '<td style="padding: 8px;">' . $counter . '</td>';
            $html .= '<td style="padding: 8px;">' . $row['start_datetime'] . '</td>';
            $html .= '<td style="padding: 8px;">' . $row['end_datetime'] . '</td>';
            $html .= '<td style="padding: 8px;">' . $row['task_name'] . '</td>';
            $html .= '<td style="padding: 8px;">' . $row['hours_used'] . '</td>';
            $html .= '<td style="padding: 8px;">' . $row['area_covered'] . '</td>';
            $html .= '<td style="padding: 8px;">' . $row['TractorNumber'] . '</td>';
            $html .= '</tr>';
            $counter++;
        }

        $html .= '</tbody>
                </table>
            </div>
        </section>';


        // Write HTML content to PDF
        $pdf->writeHTML($html, true, false, false, false, '');

        // Get the PDF content
        $pdf_content = $pdf->Output('', 'S');
    } else {
        // Handle database query error
        echo "Error: " . mysqli_error($con);
    }

    // Close database connection
    mysqli_close($con);
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

      <div id="page1" class="container page">
        <div class="jumbotron text-center">
          <h1 class="display-4">TRACTOR MANAGEMENT SYSTEM</h1>
          <p class="lead">Efficiently manage your tractor fleet with ease.</p>
        </div>
      </div>

      <div class="container">
        <h4>REPORTS</h4>

        <div class="card mt-4">
        <div class="card-header">
          Featured Report
        </div>
        <div class="card-body">
          <h5 class="card-title">Tractor Management Report</h5>
          <p class="card-text">Click on the button below to generate report for tractor usage.</p>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                  <button type="submit" class="btn btn-info" name="generate_report">Generate PDF Report</button>
              </form>
        </div>
        </div>
     
        <!-- Preview the PDF within an iframe -->
        <?php if ($pdf_content): ?>
            <h2>Preview</h2>
            <iframe src="data:application/pdf;base64,<?php echo base64_encode($pdf_content); ?>"></iframe>
        <?php endif; ?>

      </div>



      
    </section>

    <!-- CONTENT -->

    <script src="assets/js/script.js"></script>

    <!-- Bootstrap js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js
"></script>
  </body>
</html>
