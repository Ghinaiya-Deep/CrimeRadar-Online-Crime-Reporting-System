<?php
session_start();
include '../config.php';

// Check if crime_id is provided
if (!isset($_GET['crime_id'])) {
    die("Crime ID is missing.");
}

$crime_id = intval($_GET['crime_id']);

// Fetch FIR details for the given crime_id
$stmt = $con->prepare("SELECT * FROM fir WHERE crime_id = ?");
$stmt->bind_param("i", $crime_id);
$stmt->execute();
$fir = $stmt->get_result()->fetch_assoc();

if (!$fir) {
    die("No FIR found for this Crime ID.");
}

$role = isset($_GET['role']) ? $_GET['role'] : 'police'; // Default to police
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FIR Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .btn {
            display: grid;
            background-color: #007bff;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s ease-in-out;
            border: none;
            text-align: center;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>FIR Details</h2>
        <table border="2">
            <tr>
                <th>FIR No.:</th>
                <td><?php echo htmlspecialchars($fir['fir_no']); ?></td>
            </tr>
            <tr>
                <th>Date & Time of FIR:</th>
                <td><?php echo htmlspecialchars($fir['date_time_filing']); ?></td>
            </tr>
            <tr>
                <th>Complainant's Name:</th>
                <td><?php echo htmlspecialchars($fir['complainant_name']); ?></td>
            </tr>
            <tr>
                <th>Complainant's Address:</th>
                <td><?php echo htmlspecialchars($fir['complainant_address']); ?></td>
            </tr>
            <tr>
                <th>Mobile:</th>
                <td><?php echo htmlspecialchars($fir['complainant_contact']); ?></td>
            </tr>
            <tr>
                <th>Crime Type:</th>
                <td><?php echo htmlspecialchars($fir['crime_type']); ?></td>
            </tr>
            <tr>
                <th>Description:</th>
                <td><?php echo htmlspecialchars($fir['incident_description']); ?></td>
            </tr>
            <tr>
                <th>Police Station ID:</th>
                <td><?php echo htmlspecialchars($fir['police_station']); ?></td>
            </tr>
            <tr>
                <th>Officer Name:</th>
                <td><?php echo htmlspecialchars($fir['officer_name']); ?></td>
            </tr>
        </table>
<Br>
        <!-- <a href="fir.php?station_id=<?php echo $fir['police_station']; ?>" class="btn">Back to Cases</a> -->
        <a href="<?php echo ($role == 'admin') ? '../../Admin/fir.php' : 'fir.php'; ?>" class="btn">Back</a>
    </div>

</body>

</html>