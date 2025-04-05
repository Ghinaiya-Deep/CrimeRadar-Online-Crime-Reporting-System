<?php
session_start();
include '../config.php';

if (!isset($_GET['crime_id'])) {
    die("Crime ID is required.");
}

$crime_id = intval($_GET['crime_id']);

// Check if chargesheet exists
$check_stmt = $con->prepare("SELECT * FROM chargesheet WHERE crime_id = ?");
$check_stmt->bind_param("i", $crime_id);
$check_stmt->execute();
$chargesheet_data = $check_stmt->get_result()->fetch_assoc();

if (!$chargesheet_data) {
    echo "<script>alert('Chargesheet not found!'); window.location.href='chargesheet.php';</script>";
    exit;
}

// Delete the associated image if exists
if (!empty($chargesheet_data['criminal_image']) && file_exists($chargesheet_data['criminal_image'])) {
    unlink($chargesheet_data['criminal_image']);
}

// Delete chargesheet from database
$delete_stmt = $con->prepare("DELETE FROM chargesheet WHERE crime_id = ?");
$delete_stmt->bind_param("i", $crime_id);

if ($delete_stmt->execute()) {
    echo "<script>alert('Chargesheet deleted successfully!'); window.location.href='chargesheet.php';</script>";
} else {
    echo "<script>alert('Error deleting chargesheet!');</script>";
}
?>
