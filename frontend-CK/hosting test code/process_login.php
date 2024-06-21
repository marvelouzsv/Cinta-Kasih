<?php
session_start();
include 'connection.php';

// Escape input to prevent SQL injection
$username = $conn->real_escape_string($_POST['username']);
$password = $conn->real_escape_string($_POST['password']);

// Check in administration table
$sql = "SELECT * FROM administration WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['user'] = $row['username'];
    $_SESSION['role'] = 'admin';
    header("Location: admin_menu.php");
    exit(); // Stop script execution after redirect
} else {
    // Check in patient table
    $sql = "SELECT * FROM patient WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user'] = $row['username'];
        $_SESSION['role'] = 'patient';
        header("Location: patient_menu.php");
        exit(); // Stop script execution after redirect
    } else {
        echo "Invalid username or password"; // Potensial penyebab "headers already sent"
    }
}
?>
