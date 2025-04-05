<?php
include 'config.php'; // Database connection

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid station ID.");
}

$station_id = $_GET['id'];

// Fetch police station details
$station = $con->query("SELECT * FROM police_stations WHERE id = $station_id")->fetch_assoc();

// Count total officers
$staffCount = $con->query("SELECT COUNT(*) as total FROM police_officers WHERE station_id = $station_id")->fetch_assoc()['total'];

// Count total cases
$caseCount = $con->query("SELECT COUNT(*) as total FROM crime_reports WHERE police_station_id = $station_id")->fetch_assoc()['total'];

// Count solved, unsolved, in-progress cases
$solvedCount = $con->query("SELECT COUNT(*) as total FROM crime_reports WHERE police_station_id = $station_id AND status = 'Solved'")->fetch_assoc()['total'];
$unsolvedCount = $con->query("SELECT COUNT(*) as total FROM crime_reports WHERE police_station_id = $station_id AND status = 'Unsolved'")->fetch_assoc()['total'];
$inProgressCount = $con->query("SELECT COUNT(*) as total FROM crime_reports WHERE police_station_id = $station_id AND status = 'In Progress'")->fetch_assoc()['total'];

// Fetch officers in this station
$officers = $con->query("SELECT * FROM police_officers WHERE station_id = $station_id");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $station['station_name'] ?> - Details</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .stats {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 20px;
        }

        .card {
            flex: 1;
            padding: 15px;
            border-radius: 8px;
            color: white;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 80px;
            line-height: 1.4;
        }

        .card span {
            display: block;
            font-size: 24px;
            font-weight: bold;
            margin-top: 5px;
        }

        .card-title {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 16px;
            font-weight: bold;
            white-space: nowrap;
        }

        .card-title img,
        .card-title span {
            display: inline-block;
            vertical-align: middle;
        }

        .card-title img {
            width: 20px;
            height: 20px;
        }


        .card.staff {
            background: #007bff;
        }

        .card.cases {
            background: #17a2b8;
        }

        .card.solved {
            background: #28a745;
        }

        .card.unsolved {
            background: #dc3545;
        }

        .card.progress {
            background: #ffc107;
        }

        .table-container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background: white;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background: #cadcfc;
            color: black;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .btn-back {
            display: block;
            padding: 10px 15px;
            background: gray;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px auto;
            width: fit-content;
            text-align: center;
        }

        .btn-back:hover {
            background: darkgray;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2><?= $station['station_name'] ?> - Overview</h2>

        <!-- Card Style Stats -->
        <div class="stats">
            <div class="card staff">
                <div class="card-title">👮‍♂️ Total Staff:</div>
                <span><?= $staffCount ?></span>
            </div>
            <div class="card cases">
                <div class="card-title">📂 Total Cases:</div>
                <span><?= $caseCount ?></span>
            </div>
            <div class="card solved">
                <div class="card-title">✅ Solved:</div>
                <span><?= $solvedCount ?></span>
            </div>
            <div class="card unsolved">
                <div class="card-title">❌ Unsolved:</div>
                <span><?= $unsolvedCount ?></span>
            </div>
            <div class="card progress">
                <div class="card-title">🕵️‍♂️ In Progress:</div>
                <span><?= $inProgressCount ?></span>
            </div>
        </div>



        <!-- Officers Table -->
        <div class="table-container">
            <h2>Police Officers</h2>
            <table>
                <tr>
                    <th>Officer ID</th>
                    <th>Name</th>
                    <th>Rank</th>
                    <th>Badge Number</th>
                    <th>Phone</th>
                </tr>
                <?php while ($officer = $officers->fetch_assoc()): ?>
                    <tr>
                        <td><?= $officer['id'] ?></td>
                        <td><?= $officer['name'] ?></td>
                        <td><?= $officer['rank'] ?></td>
                        <td><?= $officer['badge_number'] ?></td>
                        <td><?= $officer['phone'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <a href="police_station.php" class="btn-back">⬅ Back to Police Stations</a>
    </div>

</body>

</html>