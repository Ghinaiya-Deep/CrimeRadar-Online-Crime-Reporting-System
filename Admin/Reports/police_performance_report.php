<?php
include '../config.php'; // Database connection

// Fetch Cases Handled per Police Station & Resolution Time
$query = "SELECT ps.station_name, 
                 COUNT(cr.id) as total_cases, 
                 (SELECT COUNT(*) FROM police_officers po WHERE po.station_id = ps.id) as total_officers, 
                 AVG(DATEDIFF(ch.date_of_chargesheet, cr.date_of_report)) as avg_resolution_days
          FROM crime_reports cr
          JOIN chargesheet ch ON cr.id = ch.crime_id
          JOIN police_stations ps ON cr.police_station_id = ps.id
          WHERE ch.date_of_chargesheet IS NOT NULL
          GROUP BY ps.station_name";

$result = $con->query($query);

// Prepare data for charts
$station_names = [];
$case_counts = [];
$resolution_times = [];
$table_data = [];
$officers_per_station = 4; // Fixed count of officers per station

while ($row = $result->fetch_assoc()) {
    $station_name = ucfirst($row['station_name']);
    $total_cases = $row['total_cases'];
    $cases_per_officer = round($total_cases / $officers_per_station, 2);
    $avg_resolution_days = round($row['avg_resolution_days'], 2);

    $station_names[] = $station_name;
    $case_counts[] = $cases_per_officer;
    $resolution_times[] = $avg_resolution_days;
    $table_data[] = [$station_name, $total_cases, $officers_per_station, $cases_per_officer, $avg_resolution_days];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Police Performance Report</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
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
        .chart-container {
            width: 40%;
            margin: 20px auto;
        }
        .table-container {
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            text-align: center;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ccc;
        }
        th {
            background: #cadcfc;
            color: black;
        }
        tr:nth-child(even) {
            background: #f8f9fa;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            margin: 20px;
            cursor: pointer;
        }
        .btn-primary {
            background-color: yellow;
            color: black;
        }
        .btn-primary:hover {
            background-color: lightyellow;
        }
        .btn-success {
            background-color: #28a745;
            color: black;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .btn-reverse
        {
            background-color: blue;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Police Performance Report</h2>

        <!-- Pie Chart for Police Performance -->
        <div class="chart-container">
            <canvas id="policePerformancePieChart"></canvas>
        </div>

        <!-- Bar Chart for Case Resolution Time -->
        <div class="chart-container">
            <canvas id="caseResolutionBarChart"></canvas>
        </div>

        <!-- Table Container -->
        <div class="table-container">
            <h3>Police Performance Data</h3>
            <table>
                <tr>
                    <th>Police Station</th>
                    <th>Total Cases</th>
                    <th>Total Officers</th>
                    <th>Cases per Officer</th>
                    <th>Avg Resolution Time (Days)</th>
                </tr>
                <?php
                foreach ($table_data as $row) {
                    echo "<tr>
                            <td>{$row[0]}</td>
                            <td>{$row[1]}</td>
                            <td>{$row[2]}</td>
                            <td>{$row[3]}</td>
                            <td>{$row[4]}</td>
                          </tr>";
                }
                ?>
            </table>
        </div>

        <!-- Buttons -->
        <button class="btn btn-success" onclick="downloadImage()">Download as Image</button>
        <button class="btn btn-primary" onclick="downloadCSV()">Download as CSV</button>
        <button class="btn btn-reverse" onclick="window.location.href='../report.php'">Back to Reports</button>

    </div>

    <script>
        // Pie Chart: Cases per Officer
        const ctxPie = document.getElementById('policePerformancePieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($station_names); ?>,
                datasets: [{
                    data: <?php echo json_encode($case_counts); ?>,
                    backgroundColor: ['#FF5733', '#36A2EB', '#FFCE56', '#4CAF50', '#8E44AD'],
                    hoverOffset: 4
                }]
            }
        });

       
    </script>

</body>
</html>
