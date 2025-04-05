<?php
include '../config.php'; // Database connection

// Fetch Case Resolution Data (Total Resolved & Pending Cases)
$query = "SELECT status, COUNT(*) as count FROM crime_reports GROUP BY status";
$result = $con->query($query);

// Prepare data for charts
$case_status = [];
$case_counts = [];
$table_data = [];

while ($row = $result->fetch_assoc()) {
    $case_status[] = ucfirst($row['status']);
    $case_counts[] = $row['count'];
    $table_data[] = [$row['status'], $row['count']];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Case Resolution Report</title>
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
        <h2>Case Resolution Report</h2>

        <!-- Pie Chart for Case Resolutions -->
        <div class="chart-container" id="chartContainer">
            <canvas id="caseResolutionPieChart"></canvas>
        </div>

        <!-- Table Container -->
        <div class="table-container" id="tableContainer">
            <h3>Case Resolution Data</h3>
            <table id="caseTable">
                <tr>
                    <th>Resolution Status</th>
                    <th>Number of Cases</th>
                </tr>
                <?php
                foreach ($case_status as $index => $status) {
                    echo "<tr>
                            <td>{$status}</td>
                            <td>{$case_counts[$index]}</td>
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
        const ctxPie = document.getElementById('caseResolutionPieChart').getContext('2d');
        const caseResolutionPieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($case_status); ?>,
                datasets: [{
                    data: <?php echo json_encode($case_counts); ?>,
                    backgroundColor: ['#FF5733', '#36A2EB', '#FFCE56', '#4CAF50', '#8E44AD'],
                    hoverOffset: 4
                }]
            }
        });

        // Download Chart as Image (PNG)
        async function downloadImage() {
            const chartElement = document.getElementById("caseResolutionPieChart");
            const chartCanvas = await html2canvas(chartElement, { scale: 3 });
            const chartImage = chartCanvas.toDataURL("image/png");

            const link = document.createElement("a");
            link.href = chartImage;
            link.download = "Case_Resolution_Chart.png";
            document.body.appendChild(link);
            link.click();
        }

        // Download Table Data as CSV
        function downloadCSV() {
            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += "Resolution Status,Number of Cases\n";

            <?php foreach ($table_data as $row) { ?>
                csvContent += "<?php echo $row[0]; ?>,<?php echo $row[1]; ?>\n";
            <?php } ?>

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "Case_Resolution_Report.csv");
            document.body.appendChild(link);
            link.click();
        }
    </script>

</body>
</html>
