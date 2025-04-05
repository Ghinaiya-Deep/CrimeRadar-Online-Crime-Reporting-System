<?php
include 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

// Fetch FIR details 
$stmt = $con->prepare("SELECT * FROM chargesheet ");
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("No FIR found for this Crime ID.");
}


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
    <title>Total Chargesheet</title>
    <link rel="stylesheet"
        href="style.css">
    <link rel="stylesheet"
        href="responsive.css">
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>

<style>
    

    .container {
        max-width: 83%;
        margin: 20px auto;
        padding: 10px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        overflow-x: auto;
        border: 1px solid #ccc;
    }

    th {
        background-color: #cadcfc;
        color: black;
        border: 1px solid #ccc;
    }

    td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ccc;
    }

    th,
    td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ccc;
    }

    tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    tr:nth-child(odd) {
        background-color: #ffffff;
    }

    tr:hover {
        background-color: #e9ecef;
        transition: background 0.3s ease-in-out;
    }

    .view-btn {
        background-color: #007bff;
        color: white;
        padding: 8px 12px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        display: inline-block;
        transition: 0.3s ease-in-out;
        border: none;
    }

    .view-btn:hover {
        background-color: #0056b3;
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
            <h2>Total Chargesheets</h2>
            <table>
                <thead>
                    <tr>
                        <th>Chargesheet ID</th>
                        <th>Crime ID</th>
                        <th>Date of Chargesheet</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Crime Type</th>
                        <th>Description Type</th>
                        <th>IPC Sections</th>
                        <th>Investigating Officer</th>
                        <th>Accused</th>
                        <th>Court Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                        <td>" . htmlspecialchars($row['chargesheet_id']) . "</td>
                        <td>" . htmlspecialchars($row['crime_id']) . "</td>
                        <td>" . htmlspecialchars($row['date_of_chargesheet']) . "</td>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['mobile']) . "</td>
                        <td>" . htmlspecialchars($row['crime_type']) . "</td>
                        <td>" . htmlspecialchars($row['description']) . "</td>
                        <td>" . htmlspecialchars($row['ipc_sections']) . "</td>
                        <td>" . htmlspecialchars($row['investigating_officer']) . "</td>
                        <td>" . htmlspecialchars($row['accused']) . "</td>
                        <td>" . htmlspecialchars($row['court_name']) . "</td>
                        <td>
                    <a href='" . htmlspecialchars("../Police Officer/Police Stations/view_chargesheet.php?crime_id=" . urlencode($row['crime_id']) . "&role=admin") . "' class='view-btn'>
                        View Chargesheet
                    </a>
                </td>
                    </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' style='text-align: center;'>No FIR records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>


        </div>

        </section>

    </div>
    </div>

    <script src="./index.js"></script>
</body>

</html>