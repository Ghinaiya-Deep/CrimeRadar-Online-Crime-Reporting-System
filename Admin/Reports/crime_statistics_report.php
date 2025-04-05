<?php
include '../config.php'; // Database connection

session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

// Fetch crime data from database
$query = "SELECT crime_type, COUNT(*) as count FROM crime_reports GROUP BY crime_type";
$result = $con->query($query);

// Prepare data for chart
$crime_types = [];
$crime_counts = [];
$table_data = [];

while ($row = $result->fetch_assoc()) {
    $crime_types[] = $row['crime_type'];
    $crime_counts[] = $row['count'];
    $table_data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Statistics Report</title>
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

        th,
        td {
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
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            color: white;
        }

        .btn-success {
            background-color: #28a745;
            color: black;
        }

        .btn-success:hover {
            background-color: #1e7e34;
        }

        .btn-primary {
            background-color: blue;
            color: black;
        }

        .btn-primary:hover {
            background-color: blue;
            color: black;
        }

        .btn-warning {
            background-color: #ffc107;
            color: black;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Crime Statistics Report</h2>

        <!-- Pie Chart for Crime Distribution -->
        <div class="chart-container">
            <canvas id="crimePieChart"></canvas>
        </div>

        <br>
        <!-- Table Container -->
        <div class="table-container">
            <h3>Crime Data Table</h3>
            <table id="crimeTable">
                <tr>
                    <th>Crime Type</th>
                    <th>Number of Cases</th>
                </tr>
                <?php
                foreach ($crime_types as $index => $type) {
                    echo "<tr>
                            <td>{$type}</td>
                            <td>{$crime_counts[$index]}</td>
                          </tr>";
                }
                ?>
            </table>
        </div>

        <!-- Buttons -->
        <button class="btn btn-success" onclick="downloadCSV()">Download CSV Report</button>
        <button class="btn btn-warning" onclick="downloadChart()">Download Chart as Image</button>
        <button class="btn btn-primary" onclick="window.location.href='../report.php'">Back to Reports</button>
    </div>

    <script>
        // Crime Pie Chart
        const ctxPie = document.getElementById('crimePieChart').getContext('2d');
        const crimeChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($crime_types); ?>,
                datasets: [{
                    data: <?php echo json_encode($crime_counts); ?>,
                    backgroundColor: ['#FF5733', '#36A2EB', '#FFCE56', '#4CAF50', '#8E44AD'],
                    hoverOffset: 4
                }]
            }
        });

        // Download CSV Report
        function downloadCSV() {
            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += "Crime Type,Number of Cases\n";

            <?php foreach ($table_data as $row) { ?>
                csvContent += "<?php echo $row['crime_type']; ?>,<?php echo $row['count']; ?>\n";
            <?php } ?>

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "crime_report.csv");
            document.body.appendChild(link);
            link.click();
        }

        // Download Chart as Image
        function downloadChart() {
            const link = document.createElement("a");
            link.href = document.getElementById("crimePieChart").toDataURL("image/png");
            link.download = "crime_chart.png";
            document.body.appendChild(link);
            link.click();
        }
    </script>

</body>

</html>