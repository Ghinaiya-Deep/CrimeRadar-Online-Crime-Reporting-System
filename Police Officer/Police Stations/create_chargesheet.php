<?php
session_start();
include '../config.php';

if (!isset($_GET['crime_id'])) {
    die("Crime ID is required.");
}

$crime_id = intval($_GET['crime_id']);
$police_station_id = isset($_GET['police_station_id']) ? intval($_GET['police_station_id']) : $_SESSION['police_station_id'];

if (is_null($police_station_id)) {
    die("Error: Police Station ID is missing. Please check session or URL parameters.");
}

// Fetch FIR details
$fir_stmt = $con->prepare("SELECT crime_id, police_station, complainant_name, complainant_address, complainant_contact, crime_type, incident_description FROM fir WHERE crime_id = ?");
$fir_stmt->bind_param("i", $crime_id);
$fir_stmt->execute();
$fir_data = $fir_stmt->get_result()->fetch_assoc();

if (!$fir_data) {
    die("Invalid Crime ID.");
}

// Generate Unique Charge Sheet Number
$chargesheet_number = "CS-" . str_pad($crime_id, 5, "0", STR_PAD_LEFT);

// Handle Charge Sheet submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ipc_sections = mysqli_real_escape_string($con, $_POST['ipc_sections']);
    $investigating_officer = mysqli_real_escape_string($con, $_POST['investigating_officer']);
    $accused = mysqli_real_escape_string($con, $_POST['accused']);
    $witnesses = mysqli_real_escape_string($con, $_POST['witnesses']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

    // Prepare SQL Query with Correct Number of Columns
    $insert_chargesheet = $con->prepare("
        INSERT INTO chargesheet 
        (crime_id, police_station_id, chargesheet_id, name, email, mobile, crime_type,date_of_chargesheet, description, ipc_sections, investigating_officer, accused, witnesses, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    // Bind Correct Number of Parameters
    $insert_chargesheet->bind_param(
        "iissssssssssss",
        $fir_data['crime_id'],           // Integer
        $fir_data['police_station'],  // Integer (Fixed issue)
        $chargesheet_number,             // String (Unique Charge Sheet Number)
        $fir_data['complainant_name'],
        $fir_data['complainant_address'],
        $fir_data['complainant_contact'],
        $fir_data['crime_type'],
        $fir_data['date_time_incident'],
        $fir_data['incident_description'],
        $ipc_sections,
        $investigating_officer,
        $accused,
        $witnesses,
        $status
    );

    // Execute Query and Handle Response
    if ($insert_chargesheet->execute()) {
        echo "<script>alert('Charge Sheet Created Successfully!'); window.location.href='chargesheet.php';</script>";
    } else {
        echo "<script>alert('Error Creating Charge Sheet');</script>";
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

    <title>Create Chargesheet</title>
    <style>
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Form Container */
        form {
            max-width: 500px;
            margin: 30px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Label Styling */
        form label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }

        /* Input Fields */
        form input,
        form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Focus Effect */
        form input:focus,
        form select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
        }

        /* Submit Button */
        form button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background: #28a745;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        form button:hover {
            background: #218838;
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
            <form method="POST" enctype="multipart/form-data">
                <label>IPC Sections:</label>
                <input type="text" name="ipc_sections" required>

                <label>Investigating Officer:</label>
                <input type="text" name="investigating_officer" required>

                <label>Accused Details:</label>
                <input type="text" name="accused" required>

                <label>Witnesses:</label>
                <input type="text" name="witnesses" required>

                <label>Status:</label>
                <select name="status">
                    <option value="Pending">Pending</option>
                    <option value="Under Investigation">Under Investigation</option>
                    <option value="Solved">Solved</option>
                </select>



                <button type="submit">Submit Charge Sheet</button>
            </form>

        </div>

    </section>

    <script src="../script.js"></script>
</body>

</html>