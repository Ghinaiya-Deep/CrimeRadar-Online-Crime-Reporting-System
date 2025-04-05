<?php
session_start();
require 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}



// Function to get case count based on status
function getCrimeCount($con, $status = null)
{
    if ($status) {
        $stmt = $con->prepare("SELECT COUNT(*) AS count FROM crime_reports WHERE status = ?");
        $stmt->bind_param("s",  $status);
    } else {
        $stmt = $con->prepare("SELECT COUNT(*) AS count FROM crime_reports");
    }
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['count'] ?? 0;
}

// Fetch total cases
$total_cases = getCrimeCount($con);

// Fetch case counts by status
$solved_cases = getCrimeCount($con, 'Solved');
$unsolved_cases = getCrimeCount($con,  'Unsolved');
$in_progress_cases = getCrimeCount($con,  'In Progress');

// Fetch total FIRs
$stmt = $con->prepare("SELECT COUNT(*) AS count FROM fir WHERE police_station = ?");
$stmt->bind_param("i", $police_station_id);
$stmt->execute();
$total_fir = $stmt->get_result()->fetch_assoc()['count'] ?? 0;

// Fetch total charge sheets
$stmt = $con->prepare("SELECT COUNT(*) AS count FROM chargesheet WHERE police_station_id = ?");
$stmt->bind_param("i", $police_station_id);
$stmt->execute();
$total_chargesheet = $stmt->get_result()->fetch_assoc()['count'] ?? 0;

// Fetch police stations and store them in an associative array
$police_stations = [];
$stmt = $con->prepare("SELECT id, station_name FROM police_stations");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $police_stations[$row['id']] = $row['station_name'];
}

// Fetch recent crime reports
$stmt = $con->prepare("SELECT id, date_of_report, crime_type, status, police_station_id FROM crime_reports");
$stmt->execute();
$result = $stmt->get_result();
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"
        content="IE=edge">
    <meta name="viewport"
        content="width=device-width, 
                   initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet"
        href="style.css">
    <link rel="stylesheet"
        href="responsive.css">
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<style>
    .crime-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        text-align: center;
        border: 2;
    }

    .crime-table th,
    .crime-table td {
        border: 1px solid #ddd;
        padding: 10px;
        border-color: black;
    }

    .crime-table th {
        background-color: #cadcfc;
    }

    .crime-table tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>

<body>

    <!-- for header part -->
    <header>


        <div class="logo">E-Report Hub
            <img src="img/cs.png" alt="Logo" class="main-logo">
        </div>
        

        <div class="searchbar">
            <h2>Welcome to Admin Dashboard</h2>
        </div>


        <div class="message">
            <div class="dp">
                <a href="logout.php">
                    <img src="img/logout.png" class="dpicn" alt="dp">
                </a>
            </div>

    </header>

    <div class="main-container">
        <div class="navcontainer">
            <nav class="nav">
                <div class="nav-upper-options">
                    <div class="nav-option option1">
                        <img
                            src="https://media.geeksforgeeks.org/wp-content/uploads/20221210182148/Untitled-design-(29).png"
                            class="nav-img"
                            alt="dashboard">
                        <h3>Dashboard</h3>
                    </div>

                    <a href="cases.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/police-handcuffs.png" class="nav-img" alt="Crimes">
                            <h3>Crimes</h3>
                        </div>
                    </a>

                    <a href="fir.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/fir.png" class="nav-img" alt="FIR">
                            <h3>FIR</h3>
                        </div>
                    </a>
                    <a href="chargesheet.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/chargesheet.png" class="nav-img" alt="Chargesheet">
                            <h3>Chargesheet</h3>
                        </div>
                    </a>
                    <a href="report.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/report.png" class="nav-img" alt="Report">
                            <h3>Report</h3>
                        </div>
                    </a>

                    <a href="case_tracking.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/track.png" class="nav-img" alt="Case Tracking">
                            <h3>Case Tracking</h3>
                        </div>
                    </a>

                    <a href="police_station.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/police-station.png" class="nav-img" alt="Police Station">
                            <h3>Police Station</h3>
                        </div>
                    </a>

                    <a href="feedback.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/feedback.png" class="nav-img" alt="Feedback">
                            <h3>Feedback</h3>
                        </div>
                    </a>

                    <a href="user_details.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/group.png" class="nav-img" alt="Users">
                            <h3>Users</h3>
                        </div>
                    </a>

                    <a href="police_officer.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/avatar.png" class="nav-img" alt="Police Officer">
                            <h3>Police Officer</h3>
                        </div>
                    </a>
                </div>

            </nav>
        </div>


        <div class="main">
            <div class="box-container">
                <div class="box box1">
                    <div class="text">
                        <h2 class="topic-heading"><?php echo number_format($total_cases); ?></h2>
                        <h2 class="topic">Total Crime</h2>
                    </div>

                    <img src="img/crime-scene.png" alt="Views">
                </div>

                <div class="box box2">
                    <div class="text">
                        <h2 class="topic-heading"><?php echo number_format($solved_cases); ?></h2>
                        <h2 class="topic">Solved</h2>
                    </div>

                    <img src="img/solved.png"
                        alt="likes">
                </div>

                <div class="box box3">
                    <div class="text">
                        <h2 class="topic-heading"><?php echo number_format($unsolved_cases); ?></h2>
                        <h2 class="topic">Unsolved</h2>
                    </div>

                    <img src="img/cross.png"
                        alt="comments">
                </div>

                <div class="box box4">
                    <div class="text">
                        <h2 class="topic-heading"><?php echo number_format($in_progress_cases); ?></h2>
                        <h2 class="topic">In Progress</h2>
                    </div>
                    <img src="img/progress.png" alt="published">
                </div>
            </div>

            <!-- Recent Crimes -->
            <div class="report-container">
                <div class="report-header">
                    <h1 class="recent-Articles">Recent Crime</h1>
                    <a href="cases.php">
                        <button class="view">View All</button>
                    </a>
                </div>

                <div class="report-body">

                    <table class="crime-table">
                        <thead>
                            <tr></tr>
                            <th>Crime Id</th>
                            <th>Date of Crime</th>
                            <th>Crime Type</th>
                            <th>Status</th>
                            <th>Police Station Id and Name</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['date_of_report']); ?></td>
                                    <td><?php echo htmlspecialchars($row['crime_type']); ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                    <td><?php
                                        $station_id = $row['police_station_id'];
                                        echo htmlspecialchars($station_id . " - " . ($police_stations[$station_id] ?? "Unknown"));
                                        ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <script src="./index.js"></script>
</body>

</html>