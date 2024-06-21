<?php
$servername = "localhost";
$username = "your-username";
$password = "yourr-password";
$dbname = "your-db-name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
