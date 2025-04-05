<?php
session_start();
include '../config.php';

// Get police station ID from URL or session (default to logged-in officer's station)
$police_station_id = isset($_GET['police_station_id']) ? intval($_GET['police_station_id']) : $_SESSION['police_station_id'];

// Pagination settings
$limit = 10; // Cases per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Fetch cases for the police station with pagination
$stmt = $con->prepare("SELECT * FROM crime_reports WHERE police_station_id = ? ORDER BY date_of_report DESC LIMIT ?, ?");
$stmt->bind_param("iii", $police_station_id, $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

// Get total case count
$total_cases_query = $con->prepare("SELECT COUNT(*) AS total FROM crime_reports WHERE police_station_id = ?");
$total_cases_query->bind_param("i", $police_station_id);
$total_cases_query->execute();
$total_cases_result = $total_cases_query->get_result();
$total_cases = $total_cases_result->fetch_assoc()['total'];
$total_pages = ceil($total_cases / $limit);

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

    <title>Total Cases</title>
    <style>
        .container {
            margin: 20px;
            padding: 20px;
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
            background-color: #f39c12;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .status-resolved {
            background-color: #27ae60;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .status-unsolved {
            background-color: #e74c3c;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .fir-status {
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 8px;
            /* Rounded corners */
            display: inline-block;
            /* Ensures the box wraps around the text */
            text-align: center;
            min-width: 80px;
            /* Prevents text from shrinking the box */
        }

        /* FIR Created (Green Box) */
        .fir-status-yes {
            background-color: #28a745;
            color: white;
            border: 2px solid #28a745;
            /* Optional border */
        }

        /* No FIR (Red Box) */
        .fir-status-no {
            background-color: #dc3545;
            color: white;
            border: 2px solid #dc3545;
            /* Optional border */
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
            <h2>Cases for Police Station ID: <?php echo $police_station_id; ?></h2>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Crime Type</th>
                        <th>Police Station</th>
                        <th>Description</th>
                        <th>Evidence</th>
                        <th>Date of Report</th>
                        <th>Status</th>
                        <th>Make FIR</th> <!-- ✅ New Column for FIR -->
                        <th>Action</th>
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
                                    <a href="../../User/uploads/<?php echo $row['evidence']; ?>" target="_blank">View</a>
                                <?php } else { ?>
                                    No Evidence
                                <?php } ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['date_of_report']); ?></td>
                            <td>
                                <form action="update_status.php" method="POST">
                                    <input type="hidden" name="crime_id" value="<?php echo $row['id']; ?>">
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="In Progress" <?php if ($row['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                                        <option value="Solved" <?php if ($row['status'] == 'Solved') echo 'selected'; ?>>Solved</option>
                                        <option value="Unsolved" <?php if ($row['status'] == 'Unsolved') echo 'selected'; ?>>Unsolved</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <?php
                                // Check if FIR exists for this crime report
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
                                <?php if (!$fir) { ?>
                                    <a href="create_fir.php?crime_id=<?php echo $row['id']; ?>"
                                        style="display: inline-block; padding: 8px 12px; background-color: green; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; text-align: center;">
                                        Make FIR
                                    </a>
                                <?php } else { ?>
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
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </section>

    <script src="../script.js"></script>
</body>

</html>