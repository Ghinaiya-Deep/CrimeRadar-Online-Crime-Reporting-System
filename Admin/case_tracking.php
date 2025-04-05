<?php
include 'config.php'; // Database connection

// Fetch Total Cases by Status
$query = "SELECT c.status, 
                 COUNT(c.id) AS total_cases, 
                 COUNT(CASE WHEN ch.status = 'Solved' THEN ch.chargesheet_id END) AS total_chargesheets
          FROM crime_reports c
          LEFT JOIN chargesheet ch ON c.id = ch.crime_id
          GROUP BY c.status";



$result = $con->query($query);

// Prepare Data for Chart
$status_labels = [];
$status_counts = [];

// Status Mapping for Line Chart (Up-Down Effect)
$status_order = ["In Progress", "Solved", "Unsolved"];
$status_values = [
    "In Progress" => 1,
    "Solved" => 2,
    "Unsolved" => 3
];

while ($row = $result->fetch_assoc()) {
    $status_labels[] = $row['status'];
    $status_counts[] = $row['total_cases'];
}

// Sort Data to Follow Correct Status Flow
$sorted_labels = [];
$sorted_counts = [];

foreach ($status_order as $status) {
    $index = array_search($status, $status_labels);
    if ($index !== false) {
        $sorted_labels[] = $status;
        $sorted_counts[] = $status_counts[$index];
    } else {
        $sorted_labels[] = $status;
        $sorted_counts[] = 0;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Case Tracking Summary</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .summary-box {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .summary-card {
            padding: 20px;
            background: #007bff;
            color: white;
            border-radius: 10px;
            width: 20%;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        .chart-container {
            width: 70%;
            margin: 20px auto;
        }

        .back-button {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Case Tracking Summary</h2>

        <!-- Case Summary Boxes -->
        <div class="summary-box">
            <div class="summary-card" style="background: #ff5733;">In Progress: <?= $sorted_counts[0]; ?></div>
            <div class="summary-card" style="background: #f39c12;">Solved: <?= $sorted_counts[1]; ?></div>
            <div class="summary-card" style="background: #2ecc71;">Unsolved: <?= $sorted_counts[2]; ?></div>
        </div>

        <!-- Case Tracking Line Chart -->
        <div class="chart-container">
            <canvas id="caseTrackingLineChart"></canvas>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <a href="admin_dashboard.php" class="back-button">⬅ Back to Dashboard</a>
        </div>

    </div>



    <script>
        // Line Chart for Case Tracking (Up-Down Flow)
        const ctxLine = document.getElementById('caseTrackingLineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($sorted_labels); ?>,
                datasets: [{
                    label: 'Total Cases',
                    data: <?php echo json_encode($sorted_counts); ?>,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                    fill: true,
                    tension: 0.3 // Creates smooth up/down movement
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>

</html>