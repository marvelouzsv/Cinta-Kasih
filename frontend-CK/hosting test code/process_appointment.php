<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'patient') {
    header("Location: login.php");
    exit;
}

include 'connection.php';

$patient_username = $_SESSION['user']; // Assume the username is stored in the session
$doctor_id = $_POST['doctor_id'];
$schedule = $_POST['schedule'];

// Query to get patient ID based on username
$sql_patient = "SELECT id FROM patient WHERE username = '$patient_username'";
$result_patient = $conn->query($sql_patient);

if ($result_patient->num_rows > 0) {
    $row_patient = $result_patient->fetch_assoc();
    $patient_id = $row_patient['id'];

    // Insert appointment using patient_id retrieved
    $sql = "INSERT INTO appointment (id_patient, id_doctor, schedule) VALUES ('$patient_id', '$doctor_id', '$schedule')";
    if ($conn->query($sql) === TRUE) {
        // Success notification using session variable
        $_SESSION['appointment_success'] = true;
        header("Location: patient_menu.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Error: Patient ID not found for username '$patient_username'";
}
?>
