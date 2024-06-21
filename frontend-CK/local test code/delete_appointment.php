<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

include 'connection.php';

$id = $_GET['id'];

$sql = "DELETE FROM appointment WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "Appointment deleted successfully";
    header("Location: admin_menu.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
