<?php
include '../config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $crime_id = $_POST['crime_id'];
    $new_status = $_POST['status'];

    // Update the status in the database
    $query = "UPDATE crime_reports SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "si", $new_status, $crime_id);
    mysqli_stmt_execute($stmt);

    // Redirect back to the previous page
    header("Location: cases.php");
    exit();
}
?>
