<?php
session_start();
require_once '../config.php'; // Database connection

if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}

// Check if ID is set
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Start Transaction
    $con->begin_transaction();

    try {
        // Delete from complaint_withdrawals table
        $query1 = "DELETE FROM complaint_withdrawals WHERE crime_id = ?";
        $stmt1 = $con->prepare($query1);
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $stmt1->close();

        // Delete from crime_reports table
        $query2 = "DELETE FROM crime_reports WHERE id = ?";
        $stmt2 = $con->prepare($query2);
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $stmt2->close();

        // Commit transaction
        $con->commit();

        $_SESSION['message'] = "Complaint and withdrawal request deleted successfully.";
    } catch (Exception $e) {
        // Rollback transaction in case of an error
        $con->rollback();
        $_SESSION['error'] = "Error deleting complaint. Please try again.";
    }

    $con->close();
} else {
    $_SESSION['error'] = "Invalid request.";
}

// Redirect back to the withdrawal list page
header("Location: withdraw_complaint.php");
exit();
?>
