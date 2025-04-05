<?php
include 'config.php'; // Include database connection

session_start();
// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}
// Fetch all cases with police station details
$query = "
    SELECT c.id, c.name, c.email, c.mobile, c.crime_type, c.description, c.evidence, 
           c.date_of_report, c.status, c.police_station_id, p.station_name,
           (SELECT id FROM fir WHERE crime_id = c.id) AS fir_id
    FROM crime_reports c
    LEFT JOIN police_stations p ON c.police_station_id = p.id
    ORDER BY c.date_of_report DESC
";

$result = $con->query($query);
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
    <title>Total Cases</title>
    <link rel="stylesheet"
        href="style.css">
    <link rel="stylesheet"
        href="responsive.css">
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<style>
    .container {
        margin: 10px;
        padding: 8px;
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

    th,
    td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ccc;
        /* Added border for separation */
    }

    th {
        background-color: #cadcfc;
        color: black;
        border: 1px solid #ccc;
        /* Ensure headers have a border */
    }

    tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    tr:nth-child(odd) {
        background-color: #ffffff;
    }

    tr:hover {
        background-color: #e9ecef;
    }

    .status-pending {
        background-color: #e74c3c;
        /* Red */
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
    }

    .status-inprogress {
        background-color: #f39c12;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
        white-space: nowrap;
    }

    .status-solved {
        background-color: #27ae60;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
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
            <h2>Total Cases of Nashik City</h2>

            <table>
                <thead>
                    <tr>
                        <th>Crime ID</th>
                        <th>Reporter Name</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Crime Type</th>
                        <th>Police Station</th>
                        <th>Description</th>
                        <th>Evidence</th>
                        <th>Date of Report</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                            <td><?php echo htmlspecialchars($row['crime_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['police_station_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td>
                                <?php if (!empty($row['evidence'])) { ?>
                                    <a href="../User/uploads/<?php echo $row['evidence']; ?>" target="_blank">View</a>
                                <?php } else { ?>
                                    No Evidence
                                <?php } ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['date_of_report']); ?></td>
                            <td>
                                <span class="
                                            <?php
                                            if ($row['status'] == 'Unsolved') echo 'status-pending';
                                            elseif ($row['status'] == 'In Progress') echo 'status-inprogress';
                                            elseif ($row['status'] == 'Solved') echo 'status-solved';
                                            ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </span>
                            </td>

                        <?php } ?>
                        </td>

                        </tr>

                </tbody>
            </table>
        </div>

        </section>

    </div>
    </div>

    <script src="./index.js"></script>
</body>

</html>