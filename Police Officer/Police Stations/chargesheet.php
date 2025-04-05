<?php
session_start();
include '../config.php';

// Get police station ID
$police_station_id = isset($_GET['police_station_id']) ? intval($_GET['police_station_id']) : $_SESSION['police_station_id'];

// Fetch FIRs for the police station
$stmt = $con->prepare("SELECT * FROM fir WHERE police_station = ? ORDER BY date_time_filing DESC");
$stmt->bind_param("i", $police_station_id);
$stmt->execute();
$result = $stmt->get_result();

// Police station mapping
$station_files = [
    1 => "Adgaon.php",
    2 => "Ambad.php",
    3 => "Bhadrakali.php",
    4 => "DeolaliCamp.php",
    5 => "Gangapur.php",
    6 => "Indiranagar.php",
    7 => "Mhasrul.php",
    8 => "MumbaiNaka.php",
    9 => "NashikRoad.php",
    10 => "Panchvati.php",
    11 => "Sarkarwada.php",
    12 => "Satpur.php",
    13 => "Upnagar.php"
];

// Get the current police station file based on the ID
$dashboard_file = isset($station_files[$police_station_id]) ? $station_files[$police_station_id] : "default_dashboard.php"; // Default if ID is missing
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../style1.css">

    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Chargesheet</title>
    <style>
        .container {
            margin: 20px auto;
            padding: 20px;
            width: 95%;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
            font-family: Arial, sans-serif;
        }

        thead {
            background-color: #004085;
            color: white;
        }

        th {
            background-color: #cadcfc;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ccc;
            color: black;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:nth-child(odd) {
            background-color: #ffffff;
        }

        tr:hover {
            background-color: #e9ecef;
            transition: 0.3s ease-in-out;
        }

        /* General Button Styling */
        .action-btn {
            display: inline-block;
            padding: 8px 12px;
            margin: 5px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: 0.3s ease-in-out;
        }

        /* Create Chargesheet (Green) */
        .create-btn {
            background-color: #28a745;
            color: white;
            border: 2px solid #28a745;
        }

        .create-btn:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        /* View Chargesheet (Blue) */
        .view-btn {
            background-color: #007bff;
            color: white;
            border: 2px solid #007bff;
        }

        .view-btn:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        /* Disabled Button Styling */
        .disabled {
            background-color: gray !important;
            cursor: not-allowed !important;
            opacity: 0.6;
        }

        /* Center Align Buttons in Table Cell */
        td {
            text-align: center;
            vertical-align: middle;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>


</head>

<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="../Images/cs.png" alt="">
            </div>

            <span class="logo_name">CrimeRadar</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="<?php echo $dashboard_file; ?>">
                        <i class="uil uil-estate"></i>
                        <span class="link-name">Dashboard</span>
                    </a></li>
                <li><a href="cases.php?station_id=<?php echo $police_station_id; ?>">
                        <i class="uil uil-files-landscapes"></i>
                        <span class="link-name">Total Cases</span>
                    </a></li>
                <li><a href="fir.php?station_id=<?php echo $police_station_id; ?>">
                        <i class="uil uil-document-info"></i>
                        <span class="link-name">FIR</span>
                    </a></li>
                <li><a href="chargesheet.php?station_id=<?php echo $police_station_id; ?>">
                        <i class="uil uil-file-check"></i>
                        <span class="link-name">Chargesheet</span>
                    </a></li>
                <li><a href="crime_analytics.php?station_id=<?php echo $police_station_id; ?>">
                        <i class="uil uil-chart-bar"></i>
                        <span class="link-name">Crime Analytics</span>
                    </a></li>
                <li><a href="criminal_list.php?station_id=<?php echo $police_station_id; ?>">
                        <i class="uil uil-user-exclamation"></i>
                        <span class="link-name">Criminal List</span>
                    </a></li>
                <li><a href="withdraw_complaint.php?station_id=<?php echo $police_station_id; ?>">
                        <i class="uil uil-times-circle"></i>
                        <span class="link-name">Withdraw Complaints</span>
                    </a></li>
                <li><a href="feedback.php?station_id=<?php echo $police_station_id; ?></a>">
                        <i class="uil uil-comment-alt-message"></i>
                        <span class="link-name">Feedback</span>
                    </a></li>
            </ul>
        </div>

    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <a href="../police_login.php">
                <img src="../Images/logout.png" class="dpicn" alt="dp">
            </a>
        </div>

        <br><br>
        <div class="container">
            <h2>Chargesheet In Police Station ID: <?php echo $police_station_id; ?></h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Mobile</th>
                        <th>Crime Type</th>
                        <th>Description</th>
                        <th>Date of FIR</th>
                        <th>IPC Sections</th>
                        <th>Investigating Officer</th>
                        <th>Criminal Name</th>
                        <th>Witnesses</th>
                        <th>Case Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['crime_id']; ?></td>
                            <td><?php echo htmlspecialchars($row['complainant_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['complainant_address']); ?></td>
                            <td><?php echo htmlspecialchars($row['complainant_contact']); ?></td>
                            <td><?php echo htmlspecialchars($row['crime_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['incident_description']); ?></td>
                            <td><?php echo htmlspecialchars($row['date_time_filing']); ?></td>
                            <td>
                                <?php
                                $chargesheet_check = $con->prepare("SELECT * FROM chargesheet WHERE crime_id = ?");
                                $chargesheet_check->bind_param("i", $row['crime_id']);
                                $chargesheet_check->execute();
                                $chargesheet_result = $chargesheet_check->get_result();
                                $chargesheet_row = $chargesheet_result->fetch_assoc();

                                echo $chargesheet_row ? htmlspecialchars($chargesheet_row['ipc_sections']) : "Not Filed";
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($chargesheet_row['investigating_officer'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($chargesheet_row['accused'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($chargesheet_row['witnesses'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($chargesheet_row['status'] ?? 'Pending'); ?></td>
                            <td>
                                <a href="create_chargesheet.php?crime_id=<?php echo $row['crime_id']; ?>" class="action-btn create-btn">Create Chargesheet</a>

                                <?php if ($chargesheet_row) { ?>
                                    <a href="view_chargesheet.php?crime_id=<?php echo $row['crime_id']; ?>" class="action-btn view-btn">View Chargesheet</a>
                                    <a href="delete_chargesheet.php?crime_id=<?php echo $row['crime_id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this chargesheet?');">Delete</a>
                                <?php } else { ?>
                                    <a href="#" onclick="showError();" class="action-btn view-btn disabled">View Chargesheet</a>
                                <?php } ?>
                            </td>


                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </section>

    <script src="../script.js"></script>
</body>

</html>