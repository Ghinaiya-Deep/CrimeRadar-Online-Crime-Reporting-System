<?php
session_start();
include '../config.php';

if (!isset($_GET['crime_id'])) {
    die("Error: Crime ID is missing.");
}

$crime_id = intval($_GET['crime_id']);

// Fetch charge sheet details
$stmt = $con->prepare("SELECT * FROM chargesheet WHERE crime_id = ?");
$stmt->bind_param("i", $crime_id);
$stmt->execute();
$result = $stmt->get_result();
$chargesheet = $result->fetch_assoc();

if (!$chargesheet) {
    die("No charge sheet found for this Crime ID.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View ChargeSheet Details</title>
    <link rel="stylesheet" href="../style1.css">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            color: #333;
        }

        .chargesheet-container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f9f9f9;
        }

        table th,
        table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background-color: #dfe6e9;
            color: #2c3e50;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .download-btn {
            display: block;
            width: 200px;
            text-align: center;
            margin: 20px auto;
            padding: 10px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .download-btn:hover {
            background-color: #2980b9;
        }

        @media print {
            .download-btn {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="chargesheet-container">
        <h2>Charge Sheet - Crime ID: <?php echo $crime_id; ?></h2>
        <div style="text-align: right;">
            <img src="../Images/court.png" alt="Police Logo" width="100" height="100"
                style="border-radius: 8px;">
        </div>
        <br>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>Crime ID</th>
                <td><?php echo $chargesheet['crime_id']; ?></td>
            </tr>
            <tr>
                <th>Chargesheet Number</th>
                <td><?php echo $chargesheet['chargesheet_id']; ?></td>
            </tr>
            <tr>
                <th>Date of Chargesheet</th>
                <td><?php echo $chargesheet['date_of_chargesheet']; ?></td>
            </tr>
            <tr>
                <th>Court Name</th>
                <td><?php echo $chargesheet['court_name']; ?></td>
            </tr>
            <tr>
                <th>Crime Type</th>
                <td><?php echo $chargesheet['crime_type']; ?></td>
            </tr>
            <tr>
                <th>IPC Sections</th>
                <td><?php echo $chargesheet['ipc_sections']; ?></td>
            </tr>
            <tr>
                <th>Investigating Officer</th>
                <td><?php echo $chargesheet['investigating_officer']; ?></td>
            </tr>
            <tr>
                <th>Criminal Name</th>
                <td><?php echo $chargesheet['accused']; ?></td>
            </tr>
            <tr>
                <th>Witnesses</th>
                <td><?php echo $chargesheet['witnesses']; ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?php echo $chargesheet['status']; ?></td>
            </tr>

        </table>


        <!-- Download Button -->
        <button class="download-btn" onclick="window.print();">Download</button>
    </div>

</body>

</html>