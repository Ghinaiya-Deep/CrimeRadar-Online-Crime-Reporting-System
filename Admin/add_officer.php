<?php
include 'config.php';
session_start();


// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

// Fetch police stations
$stations = $con->query("SELECT * FROM police_stations");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $rank = $_POST['rank'];
    $badge_number = $_POST['badge_number'];
    $phone = $_POST['phone'];
    $station_id = $_POST['station_id'];

    // Validate phone number (10 digits)
    if (!preg_match('/^\d{10}$/', $phone)) {
        echo "<script>alert('Phone number must be exactly 10 digits!');</script>";
    }
    // Validate badge number (1 letter + 5 digits, e.g., B12345)
    elseif (!preg_match('/^[A-Z]{1}\d{5}$/', $badge_number)) {
        echo "<script>alert('Badge number must start with 1 letter followed by 5 digits (e.g., B12345)!');</script>";
    }
    // Validate rank (only letters, no numbers)
    elseif (!preg_match('/^[A-Za-z\s-]+$/', $rank)) {
        echo "<script>alert('Rank must contain only letters, spaces, or hyphens (e.g., Inspector, Assistant-Inspector, Sub-Inspector)!');</script>";    
    } else {
        // Check if the station already has 4 officers
        $countQuery = $con->query("SELECT COUNT(*) as total FROM police_officers WHERE station_id = $station_id");
        $countResult = $countQuery->fetch_assoc();

        if ($countResult['total'] < 4) {
            $stmt = $con->prepare("INSERT INTO police_officers (name, rank, badge_number, phone, station_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $name, $rank, $badge_number, $phone, $station_id);
            if ($stmt->execute()) {
                echo "<script>alert('Officer added successfully!'); window.location.href='police_officer.php';</script>";
            } else {
                echo "<script>alert('Error adding officer. Please try again!');</script>";
            }
        } else {
            echo "<script>alert('Each station can have only 4 officers!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Police Officer</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to the external CSS -->
</head>
<style>
    /* General Styling */
    body {
        font-family: Arial, sans-serif;
        background: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    /* Container */
    .container {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        max-width: 400px;
        width: 100%;
        text-align: center;
    }

    /* Heading */
    h2 {
        color: #333;
        margin-bottom: 20px;
    }

    /* Input Fields */
    input,
    select {
        width: calc(100% - 20px);
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    /* Button */
    button {
        background: #28a745;
        /* Green color */
        color: white;
        border: none;
        padding: 10px;
        width: 100%;
        border-radius: 5px;
        font-size: 18px;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        background: #218838;
    }

    /* Back Link */
    .back-link {
        display: block;
        margin-top: 15px;
        color: #007bff;
        text-decoration: none;
    }

    .back-link:hover {
        text-decoration: underline;
    }
</style>

<body>
    <div class="container">
        <h2>Add Police Officer</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="text" name="rank" placeholder="Rank" required>
            <input type="text" name="badge_number" placeholder="Badge Number" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <select name="station_id" required>
                <option value="">Select Police Station</option>
                <?php while ($row = $stations->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>"><?= $row['station_name'] ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit">Save Officer</button>
        </form>
        <a href="police_officer.php" class="back-link">← Back to Officers List</a>
    </div>
</body>

</html>