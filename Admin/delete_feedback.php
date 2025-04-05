<?php
include 'config.php'; // Include database connection


if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Get the user ID and sanitize it

    // SQL to delete the user
    $sql = "DELETE FROM feedback WHERE feedback_id = $id";

    if (mysqli_query($con, $sql)) {
        echo "<script>
                alert('User deleted successfully');
                window.location.href = 'feedback.php';
              </script>";
    } else {
        echo "<script>
                alert('Error deleting user');
                window.location.href = 'feedback.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Invalid request');
            window.location.href = 'feedback.php';
          </script>";
}

mysqli_close($con); // Close database connection
?>
