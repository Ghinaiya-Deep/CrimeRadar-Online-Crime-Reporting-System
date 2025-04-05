<?php
session_start();
include '../config.php';

// Check if FIR ID is provided
if (isset($_GET['fir_id'])) {
    $fir_id = intval($_GET['fir_id']);

    // Delete the FIR
    $delete_fir = $con->prepare("DELETE FROM fir WHERE id = ?");
    $delete_fir->bind_param("i", $fir_id);
    if ($delete_fir->execute()) {
        // Optionally, you can reset the status of the crime report
        // $update_crime_report = $con->prepare("UPDATE crime_reports SET status = 'No FIR' WHERE id = ?");
        // $update_crime_report->bind_param("i", $crime_id);
        // $update_crime_report->execute();
        
        echo "<script>alert('FIR Deleted Successfully!'); window.location.href='cases.php';</script>";
    } else {
        echo "<script>alert('Error Deleting FIR'); window.history.back();</script>";
    }
}
?>
