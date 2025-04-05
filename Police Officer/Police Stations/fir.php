<?php
session_start();
include '../config.php';

// Get police station ID
$police_station_id = isset($_GET['police_station_id']) ? intval($_GET['police_station_id']) : $_SESSION['police_station_id'];

// Fetch cases for the police station
$stmt = $con->prepare("SELECT * FROM crime_reports WHERE police_station_id = ? ORDER BY date_of_report DESC");
$stmt->bind_param("i", $police_station_id);
$stmt->execute();
$result = $stmt->get_result();

// Handle FIR creation
if (isset($_POST['make_fir'])) {
    $crime_id = intval($_POST['crime_id']);

    // Fetch crime details
    $crime_stmt = $con->prepare("SELECT * FROM crime_reports WHERE id = ?");
    $crime_stmt->bind_param("i", $crime_id);
    $crime_stmt->execute();
    $crime_data = $crime_stmt->get_result()->fetch_assoc();

    // Insert FIR record
    $insert_fir = $con->prepare("INSERT INTO fir (crime_id, police_station, complainant_name, complainant_address, complainant_contact, crime_type, incident_description, date_time_filing, status) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), 'Pending')");
    $insert_fir->bind_param(
        "iisssss",
        $crime_data['id'],
        $crime_data['police_station_id'],
        $crime_data['complainant_name'],
        $crime_data['complainant_address'],
        $crime_data['complainant_contact'],
        $crime_data['crime_type'],
        $crime_data['incident_description']
    );

    if ($insert_fir->execute()) {
        echo "<script>alert('FIR Created Successfully!'); window.location.href='cases.php?station_id=$police_station_id';</script>";
    } else {
        echo "<script>alert('Error Creating FIR');</script>";
    }
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

    <title>Total FIR</title>

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

        /* FIR Status Styling */
        .fir-status {
            font-weight: bold;
            padding: 10px 15px;
            /* Increased padding for a bigger box */
            border-radius: 8px;
            /* Rounded corners */
            display: inline-block;
            /* Ensures the box wraps around the text */
            text-align: center;
            min-width: 80px;
            /* Prevents text from shrinking the box */
        }

        /* No FIR (Red Box) */
        .fir-status-no {
            background-color: #dc3545;
            color: white;
            border: 2px solid #dc3545;
            /* Optional border */
        }

        /* FIR Created (Green Box) */
        .fir-status-yes {
            background-color: #28a745;
            color: white;
            border: 2px solid #28a745;
            /* Optional border */
        }


        /* Button Styling */
        .make-fir-btn {
            background-color: green;
            color: white;
            padding: 6px 12px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s;
        }

        .make-fir-btn:hover {
            background-color: #218838;
        }

        .view-fir-link {
            text-decoration: none;
            color: blue;
            font-weight: bold;
        }

        .view-fir-link:hover {
            text-decoration: underline;
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
            <h2>FIR In Police Station ID: <?php echo $police_station_id; ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Crime Type</th>
                        <th>Description</th>
                        <th>Date of Report</th>
                        <th>FIR Status</th>
                        <th>Make FIR</th>
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
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['date_of_report']); ?></td>
                            <td>
                                <?php
                                // Check if FIR exists
                                $fir_check = $con->prepare("SELECT id FROM fir WHERE crime_id = ?");
                                $fir_check->bind_param("i", $row['id']);
                                $fir_check->execute();
                                $fir_result = $fir_check->get_result();
                                $fir = $fir_result->fetch_assoc();

                                if ($fir) {
                                    echo "<span class='fir-status fir-status-yes'>FIR Created</span>";
                                } else {
                                    echo "<span class='fir-status fir-status-no'>No FIR</span>";
                                }
                                ?>
                            </td>

                            <td>
                                <!-- View FIR and Delete FIR Buttons -->
                                <a href="fir_details.php?crime_id=<?php echo $row['id']; ?>"
                                    style="display: inline-block; padding: 8px 12px; background-color: blue; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; text-align: center;">
                                    View FIR
                                </a>
                                <br><br>
                                <!-- Delete FIR Button (Redirects to delete_fir.php) -->
                                <a href="delete_fir.php?fir_id=<?php echo $fir['id']; ?>"
                                    onclick="return confirm('Are you sure you want to delete this FIR?');"
                                    style="display: inline-block; padding: 8px 12px; background-color: red; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; text-align: center; margin-left: 5px;">
                                    Delete FIR
                                </a>
                            <?php } ?>
                            </td>


                        </tr>

                </tbody>
            </table>

        </div>

    </section>

    <script src="../script.js"></script>
</body>

</html>