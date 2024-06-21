<?php
session_start();
include 'connection.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Check in administration table
$sql = "SELECT * FROM administration WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['user'] = $row['username'];
    $_SESSION['role'] = 'admin';
    header("Location: admin_menu.php");
} else {
    // Check in patient table
    $sql = "SELECT * FROM patient WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user'] = $row['username'];
        $_SESSION['role'] = 'patient';
        header("Location: patient_menu.php");
    } else {
        echo "Invalid username or password";
    }
}
?>
