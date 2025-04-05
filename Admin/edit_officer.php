<?php
include 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $officer_id = $_GET['id'];

    // Fetch officer details
    $query = $con->prepare("SELECT * FROM police_officers WHERE id = ?");
    $query->bind_param("i", $officer_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $officer = $result->fetch_assoc();
    } else {
        echo "<script>alert('Invalid Officer ID'); window.location.href='police_officer.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('No Officer ID provided'); window.location.href='police_officer.php';</script>";
    exit;
}

// Fetch police stations for dropdown
$stations = $con->query("SELECT * FROM police_stations");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $rank = $_POST['rank'];
    $badge_number = $_POST['badge_number'];
    $phone = $_POST['phone'];
    $station_id = $_POST['station_id'];

    // Update officer details
    $stmt = $con->prepare("UPDATE police_officers SET name=?, rank=?, badge_number=?, phone=?, station_id=? WHERE id=?");
    $stmt->bind_param("ssssii", $name, $rank, $badge_number, $phone, $station_id, $officer_id);
    if ($stmt->execute()) {
        echo "<script>alert('Officer updated successfully!'); window.location.href='police_officer.php';</script>";
    } else {
        echo "<script>alert('Error updating officer. Please try again!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Police Officer</title>
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
        background: #007bff;
        /* Blue color for edit */
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
        background: #0056b3;
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
        <h2>Edit Police Officer</h2>
        <form method="POST">
            <input type="text" name="name" value="<?= $officer['name'] ?>" placeholder="Full Name" required>
            <input type="text" name="rank" value="<?= $officer['rank'] ?>" placeholder="Rank" required>
            <input type="text" name="badge_number" value="<?= $officer['badge_number'] ?>" placeholder="Badge Number" required>
            <input type="text" name="phone" value="<?= $officer['phone'] ?>" placeholder="Phone Number" required>
            <select name="station_id" required>
                <option value="">Select Police Station</option>
                <?php while ($row = $stations->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>" <?= ($row['id'] == $officer['station_id']) ? 'selected' : '' ?>>
                        <?= $row['station_name'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit">Update Officer</button>
        </form>
        <a href="police_officer.php" class="back-link">← Back to Officers List</a>
    </div>
</body>

</html>