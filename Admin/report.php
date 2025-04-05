<?php
include 'config.php'; // Database connection

session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="responsive.css">

    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 80%;
        margin: 50px auto;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    h2 {
        color: #333;
        margin-bottom: 20px;
    }

    .report-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 50px;
        margin-top: 50px;
        justify-content: center;
        align-items: center;
    }

    .report-box {
        background: #cce5ff;
        /* Light Blue */
        color: #003366;
        /* Dark Navy Blue Text */
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100px;
        border: 1px solid #99c2ff;
    }

    .report-box:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        background: #b3d7ff;
        /* Slightly Darker Blue on Hover */
    }

    a {
        text-decoration: none;
        color: #003366;
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
                    <a href="admin_dashboard.php">
                        <div class="nav-option option1">
                            <img
                                src="https://media.geeksforgeeks.org/wp-content/uploads/20221210182148/Untitled-design-(29).png"
                                class="nav-img"
                                alt="dashboard">
                            <h3>Dashboard</h3>
                        </div>
                    </a>

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


        <br><br>
        <div class="container">
            <h2>Reports</h2>
            <div class="report-grid">
                <a href="Reports/crime_statistics_report.php">
                    <div class="report-box">Crime Statistics Report</div>
                </a>
                <a href="Reports/fir_status_report.php">
                    <div class="report-box">FIR Status Report</div>
                </a>
                <a href="Reports/chargesheet_report.php">
                    <div class="report-box">Chargesheet Submission Report</div>
                </a>
                <a href="Reports/case_resolution_report.php">
                    <div class="report-box">Case Resolution Report</div>
                </a>
                <a href="Reports/crime_hotspot_analysis.php">
                    <div class="report-box">Crime Hotspot Analysis</div>
                </a>
                <a href="Reports/police_performance_report.php">
                    <div class="report-box">Police Performance Report</div>
                </a>
            </div>

        </div>

        </section>

    </div>
    </div>

    <script src="./index.js"></script>
</body>

</html>