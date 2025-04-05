<?php
// Start session
session_start();
include '../config.php';

// Get police station ID from URL or session (default to logged-in officer's station)
$police_station_id = isset($_GET['police_station_id']) ? intval($_GET['police_station_id']) : $_SESSION['police_station_id'];

$query = "SELECT crime_id, chargesheet_id, accused, ipc_sections, crime_type FROM chargesheet  WHERE police_station_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $police_station_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $chargesheet_data = $result;
} else {
    $chargesheet_data = [];
}

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Criminal List</title>
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


        .delete-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: red;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .delete-btn:hover {
            background-color: darkred;
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
            <h2>Criminal List for Police Station ID: <?php echo $police_station_id; ?></h2>
            <?php if (!empty($chargesheet_data)) : ?>
                <table border="1" cellspacing="0" cellpadding="10" style="width:100%; border-collapse: collapse;">
                    <tr>
                        <th>Crime ID</th>
                        <th>Chargsheet Number</th>
                        <th>Criminal Name</th>
                        <th>IPC Sections</th>
                        <th>Crime Type</th>
                        <th>Actions</th>
                    </tr>

                    <!-- Loop through the fetched results and display them in rows -->
                    <?php foreach ($chargesheet_data as $row) : ?>
                        <tr>
                            <td><?php echo $row['crime_id']; ?></td>
                            <td><?php echo $row['chargesheet_id']; ?></td>
                            <td><?php echo $row['accused']; ?></td>
                            <td><?php echo $row['ipc_sections']; ?></td>
                            <td><?php echo $row['crime_type']; ?></td>
                            <td>
                                <a href="delete_criminal.php?id=<?php echo $row['crime_id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this chargesheet?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else : ?>
                <p>No records found.</p>
            <?php endif; ?>
        </div>
    </section>




    </section>

    <script src="../script.js"></script>
</body>

</html>