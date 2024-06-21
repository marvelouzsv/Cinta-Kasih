<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

include 'connection.php';

$id = $_POST['id'];
$id_patient = $_POST['id_patient'];
$id_doctor = $_POST['id_doctor'];
$schedule = $_POST['schedule'];

$sql = "UPDATE appointment SET id_patient='$id_patient', id_doctor='$id_doctor', schedule='$schedule' WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "Appointment updated successfully";
    header("Location: admin_menu.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
