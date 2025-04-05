<?php
include '../config.php'; // Database connection

// Step 1: Fetch all police station names
$police_stations = [];
$station_query = "SELECT id, station_name FROM police_stations";
$station_result = $con->query($station_query);
while ($row = $station_result->fetch_assoc()) {
    $police_stations[$row['id']] = ucfirst($row['station_name']); // Store ID => Name mapping
}

// Step 2: Fetch crime reports grouped by police_station_id
$query = "SELECT police_station_id, COUNT(*) as count FROM crime_reports GROUP BY police_station_id";
$result = $con->query($query);

// Prepare data for charts
$crime_locations = [];
$crime_counts = [];
$table_data = [];

while ($row = $result->fetch_assoc()) {
    $station_id = $row['police_station_id'];
    $station_name = isset($police_stations[$station_id]) ? $police_stations[$station_id] : "Unknown Station"; // Replace ID with Name
    
    $crime_locations[] = $station_name;
    $crime_counts[] = $row['count'];
    $table_data[] = [$station_name, $row['count']];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crime Hotspot Analysis</title>
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
        <h2>Crime Hotspot Analysis</h2>

        <!-- Pie Chart for Crime Hotspots -->
        <div class="chart-container" id="chartContainer">
            <canvas id="crimeHotspotPieChart"></canvas>
        </div>

        <!-- Table Container -->
        <div class="table-container" id="tableContainer">
            <h3>Crime Hotspot Data</h3>
            <table id="crimeTable">
                <tr>
                    <th>Location</th>
                    <th>Number of Crimes</th>
                </tr>
                <?php
                foreach ($crime_locations as $index => $location) {
                    echo "<tr>
                            <td>{$location}</td>
                            <td>{$crime_counts[$index]}</td>
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
        const ctxPie = document.getElementById('crimeHotspotPieChart').getContext('2d');
        const crimeHotspotPieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($crime_locations); ?>,
                datasets: [{
                    data: <?php echo json_encode($crime_counts); ?>,
                    backgroundColor: ['#FF5733', '#36A2EB', '#FFCE56', '#4CAF50', '#8E44AD'],
                    hoverOffset: 4
                }]
            }
        });

        // Download Chart as Image (PNG)
        async function downloadImage() {
            const chartElement = document.getElementById("crimeHotspotPieChart");
            const chartCanvas = await html2canvas(chartElement, { scale: 3 });
            const chartImage = chartCanvas.toDataURL("image/png");

            const link = document.createElement("a");
            link.href = chartImage;
            link.download = "Crime_Hotspot_Chart.png";
            document.body.appendChild(link);
            link.click();
        }

        // Download Table Data as CSV
        function downloadCSV() {
            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += "Location,Number of Crimes\n";

            <?php foreach ($table_data as $row) { ?>
                csvContent += "<?php echo $row[0]; ?>,<?php echo $row[1]; ?>\n";
            <?php } ?>

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "Crime_Hotspot_Report.csv");
            document.body.appendChild(link);
            link.click();
        }
    </script>

</body>
</html>
