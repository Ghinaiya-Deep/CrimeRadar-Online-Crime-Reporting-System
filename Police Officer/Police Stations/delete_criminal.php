<?php
session_start();
include '../config.php';

// Check if the ID parameter is set in the URL
if (isset($_GET['id'])) {
    $crime_id = intval($_GET['id']);

    // Prepare the DELETE query to remove the chargesheet from the database
    $query = "DELETE FROM chargesheet WHERE crime_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $crime_id);

    if ($stmt->execute()) {
        // Redirect back to the criminal list page after deletion
        header("Location: criminal_list.php");
        exit();
    } else {
        // Show an error if the deletion fails
        echo "Error deleting record: " . $con->error;
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo "No crime ID provided.";
}

$con->close();
?>
