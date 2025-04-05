<?php
session_start();
include '../config.php';

// Ensure user is logged in
if (!isset($_SESSION['police_station_id'])) {
    header("Location: ../police_login.php");
    exit();
}

$police_station_id = $_SESSION['police_station_id'];

// Function to get case count based on status
function getCrimeCount($con, $police_station_id, $status = null)
{
    if ($status) {
        $stmt = $con->prepare("SELECT COUNT(*) AS count FROM crime_reports WHERE police_station_id = ? AND status = ?");
        $stmt->bind_param("is", $police_station_id, $status);
    } else {
        $stmt = $con->prepare("SELECT COUNT(*) AS count FROM crime_reports WHERE police_station_id = ?");
        $stmt->bind_param("i", $police_station_id);
    }
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['count'] ?? 0;
}

// Fetch total cases
$total_cases = getCrimeCount($con, $police_station_id);

// Fetch case counts by status
$solved_cases = getCrimeCount($con, $police_station_id, 'Solved');
$unsolved_cases = getCrimeCount($con, $police_station_id, 'Unsolved');
$in_progress_cases = getCrimeCount($con, $police_station_id, 'In Progress');

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

// Fetch recent crime reports
$stmt = $con->prepare("SELECT name, mobile, crime_type, date_of_report FROM crime_reports WHERE police_station_id = ? ORDER BY date_of_report DESC LIMIT 5");
$stmt->bind_param("i", $police_station_id);
$stmt->execute();
$result = $stmt->get_result();
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

    <title>Nashik Road Police Station</title>
</head>

<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="../Images/cs.png">
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
            <h2>Nashik Road Police Station</h2>
            <a href="../police_login.php">
                <img src="../Images/logout.png" class="dpicn" alt="dp">
            </a>
        </div>

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Dashboard</span>
                </div>

                <div class="boxes">
                    <a href="cases.php" class="box box1">
                        <span class="text">Total Cases</span>
                        <span class="number"><?php echo number_format($total_cases); ?></span>
                    </a>
                    <a href="cases.php" class="box box2">
                        <span class="text">Solved</span>
                        <span class="number"><?php echo number_format($solved_cases); ?></span>
                    </a>
                    <a href="cases.php" class="box box3">
                        <span class="text">Unsolved</span>
                        <span class="number"><?php echo number_format($unsolved_cases); ?></span>
                    </a>
                    <a href="cases.php" class="box box4">
                        <span class="text">In Progress</span>
                        <span class="number"><?php echo number_format($in_progress_cases); ?></span>
                    </a>
                    <a href="fir.php" class="box box5">
                        <span class="text">Total FIR</span>
                        <span class="number"><?php echo number_format($total_fir); ?></span>
                    </a>
                    <a href="chargesheet.php" class="box box6">
                        <span class="text">Total Chargesheet</span>
                        <span class="number"><?php echo number_format($total_chargesheet); ?></span>
                    </a>
                </div>
            </div>

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

            <div class="activity">
                <div class="title">
                    <i class="uil uil-clock-three"></i>
                    <span class="text">Recent Crime Reports</span>
                </div>

                <table class="crime-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Crime Type</th>
                            <th>Date of Report</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                                <td><?php echo htmlspecialchars($row['crime_type']); ?></td>
                                <td><?php echo htmlspecialchars($row['date_of_report']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>


        </div>
        </div>
    </section>

    <script src="../script.js"></script>
</body>

</html>