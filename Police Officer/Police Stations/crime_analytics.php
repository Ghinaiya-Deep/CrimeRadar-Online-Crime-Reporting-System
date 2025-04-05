<?php
session_start();
include '../config.php';

// Get police station ID from URL or session (default to logged-in officer's station)
$police_station_id = isset($_GET['police_station_id']) ? intval($_GET['police_station_id']) : $_SESSION['police_station_id'];

// Fetch crime count grouped by type for this police station
$query = "SELECT crime_type, COUNT(*) as count FROM crime_reports 
          WHERE police_station_id = ? 
          GROUP BY crime_type";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $police_station_id);
$stmt->execute();
$result = $stmt->get_result();

$crime_data = [];
while ($row = $result->fetch_assoc()) {
    $crime_data[$row['crime_type']] = $row['count'];
}

// Convert PHP array to JSON for JavaScript
$crime_types = json_encode(array_keys($crime_data));
$crime_counts = json_encode(array_values($crime_data));

$stmt->close();
$con->close();


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

    <title>Crime Analytics</title>
    <style>
        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #333;
            font-size: 22px;
        }

        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        canvas {
            max-width: 70% !important;
            height: auto !important;
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
            <h2>Crime Analytics for Police Station ID: <?php echo $police_station_id; ?></h2>
            <div class="chart-container">
                <canvas id="crimeChart"></canvas>
            </div>
    </section>


    <script>
        // Get data from PHP
        let crimeTypes = <?php echo $crime_types; ?>;
        let crimeCounts = <?php echo $crime_counts; ?>;

        // Create Pie Chart
        let ctx = document.getElementById('crimeChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: crimeTypes,
                datasets: [{
                    data: crimeCounts,
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#ff9f40']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

    </section>

    <script src="../script.js"></script>
</body>

</html>