<?php
include '../config.php'; // Database connection

// Fetch Chargesheet data grouped by crime type
$query = "SELECT crime_type, COUNT(*) as count FROM chargesheet GROUP BY crime_type";
$result = $con->query($query);

// Prepare data for charts
$chargesheet_types = [];
$chargesheet_counts = [];
$table_data = [];

while ($row = $result->fetch_assoc()) {
    $chargesheet_types[] = ucfirst($row['crime_type']);
    $chargesheet_counts[] = $row['count'];
    $table_data[] = [$row['crime_type'], $row['count']];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chargesheet Report</title>
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

        .btn-reverse {
            background-color: blue;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Chargesheet Report</h2>

        <!-- Pie Chart for Chargesheet Crime Type -->
        <div class="chart-container" id="chartContainer">
            <canvas id="chargesheetPieChart"></canvas>
        </div>

        <!-- Table Container -->
        <div class="table-container" id="tableContainer">
            <h3>Chargesheet Data Table</h3>
            <table id="chargesheetTable">
                <tr>
                    <th>Crime Type</th>
                    <th>Number of Chargesheets</th>
                </tr>
                <?php
                foreach ($chargesheet_types as $index => $type) {
                    echo "<tr>
                            <td>{$type}</td>
                            <td>{$chargesheet_counts[$index]}</td>
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
        // Initialize Pie Chart
        const ctxPie = document.getElementById('chargesheetPieChart').getContext('2d');
        const chargesheetPieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($chargesheet_types); ?>,
                datasets: [{
                    data: <?php echo json_encode($chargesheet_counts); ?>,
                    backgroundColor: ['#FF5733', '#36A2EB', '#FFCE56', '#4CAF50', '#8E44AD'],
                    hoverOffset: 4
                }]
            }
        });

        // Download Chart as Image (PNG)
        async function downloadImage() {
            const chartElement = document.getElementById("chargesheetPieChart");
            const chartCanvas = await html2canvas(chartElement, {
                scale: 3
            });
            const chartImage = chartCanvas.toDataURL("image/png");

            const link = document.createElement("a");
            link.href = chartImage;
            link.download = "Chargesheet_Chart.png";
            document.body.appendChild(link);
            link.click();
        }

        // Download Table Data as CSV
        function downloadCSV() {
            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += "Crime Type,Number of Chargesheets\n";

            <?php foreach ($table_data as $row) { ?>
                csvContent += "<?php echo $row[0]; ?>,<?php echo $row[1]; ?>\n";
            <?php } ?>

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "Chargesheet_Report.csv");
            document.body.appendChild(link);
            link.click();
        }
    </script>

</body>

</html>