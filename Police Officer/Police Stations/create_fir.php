<?php
session_start();
include '../config.php';

// Get Crime ID from URL
if (!isset($_GET['crime_id'])) {
    die("Crime ID is missing.");
}
$crime_id = intval($_GET['crime_id']);
$police_station_id = isset($_GET['police_station_id']) ? intval($_GET['police_station_id']) : $_SESSION['police_station_id'];
// Fetch crime details
$stmt = $con->prepare("SELECT * FROM crime_reports WHERE id = ?");
$stmt->bind_param("i", $crime_id);
$stmt->execute();
$crime = $stmt->get_result()->fetch_assoc();
if (!$crime) {
    die("Invalid Crime ID.");
}

// Generate FIR Number (Example: 2025/001)
$year = date("Y");
$fir_count_query = $con->query("SELECT COUNT(*) AS count FROM fir WHERE YEAR(date_time_filing) = $year");
$fir_count = $fir_count_query->fetch_assoc()['count'] + 1;
$fir_no = "$year/" . str_pad($fir_count, 3, '0', STR_PAD_LEFT);

// Handle FIR Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complainant_name = $_POST['complainant_name'] ?? "";
    $complainant_address = $_POST['complainant_address'] ?? "";
    $complainant_contact = $_POST['complainant_contact'] ?? "";
    $complainant_id_proof = $_POST['complainant_id_proof'] ?? "";
    $date_time_incident = $_POST['date_time_incident'] ?? "";
    $place_incident = $_POST['place_incident'] ?? "";
    $crime_type = $_POST['crime_type'] ?? "";
    $accused_persons = $_POST['accused_persons'] ?? "";
    $witnesses = $_POST['witnesses'] ?? "";
    $incident_description = $_POST['incident_description'] ?? "";
    $evidence = $_POST['evidence'] ?? "";
    $police_station = $_POST['police_station'] ?? "";
    $officer_name = $_POST['officer_name'] ?? "";

    // Insert FIR into database
    $insert_stmt = $con->prepare("INSERT INTO fir 
        (fir_no, crime_id, date_time_filing, complainant_name, complainant_address, 
        complainant_contact, complainant_id_proof, date_time_incident, place_incident, 
        crime_type, accused_persons, witnesses, incident_description, evidence, 
        police_station, officer_name) 
        VALUES (?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $insert_stmt->bind_param(
        "sisssssssssssss",
        $fir_no,
        $crime_id,
        $complainant_name,
        $complainant_address,
        $complainant_contact,
        $complainant_id_proof,
        $date_time_incident,
        $place_incident,
        $crime_type,
        $accused_persons,
        $witnesses,
        $incident_description,
        $evidence,
        $police_station,
        $officer_name
    );

    if ($insert_stmt->execute()) {
        echo "<script>alert('FIR successfully registered!'); window.location.href='fir.php';</script>";
    } else {
        echo "<script>alert('Error in FIR submission! Please check your input.');</script>";
    }
}

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

    <title>Create FIR</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            font-weight: bold;
        }

        input,
        textarea {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        .btn {
            background-color: green;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: darkgreen;
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
            <form method="POST">
                <label>FIR No.</label>
                <input type="text" value="<?php echo $fir_no; ?>" disabled>

                <label>Complainant Name</label>
                <input type="text" name="complainant_name" value="<?php echo htmlspecialchars($crime['name']); ?>" required>

                <label>Complainant Address</label>
                <textarea name="complainant_address" required><?php echo htmlspecialchars($crime['address']); ?></textarea>

                <label>Complainant Contact</label>
                <input type="text" name="complainant_contact" value="<?php echo htmlspecialchars($crime['mobile']); ?>" required>

                <label>Complainant ID Proof</label>
                <input type="text" name="complainant_id_proof" placeholder="e.g., Aadhar, Passport" required>

                <label>Date & Time of Incident</label>
                <input type="datetime-local" name="date_time_incident" required>

                <label>Place of Incident</label>
                <input type="text" name="place_incident" required>

                <label>Type of Crime</label>
                <input type="text" name="crime_type" value="<?php echo htmlspecialchars($crime['crime_type']); ?>" required>

                <label>Accused Person(s) (if known)</label>
                <input type="text" name="accused_persons">

                <label>Witnesses (if any)</label>
                <input type="text" name="witnesses">

                <label>Description of Incident</label>
                <textarea name="incident_description" required></textarea>

                <label>Evidence (if any)</label>
                <input type="text" name="evidence" placeholder="Describe or attach evidence">

                <label>Police Station Name</label>
                <input type="text" name="police_station" value="<?php echo htmlspecialchars($crime['police_station_id']); ?>" required>

                <label>Officer Name</label>
                <input type="text" name="officer_name" placeholder="Enter Officer's Name" required>



                <button type="submit" class="btn">Submit FIR</button>
            </form>
        </div>

    </section>

    <script src="../script.js"></script>
</body>

</html>