<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $con->query("DELETE FROM police_officers WHERE id = $id");
}

header("Location: police_officer.php");
exit;
?>
