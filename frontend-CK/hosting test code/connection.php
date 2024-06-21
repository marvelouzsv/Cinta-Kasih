<?php
$servername = "localhost";
$username = "id22347123_hospital";
$password = "@Hospital1";
$dbname = "id22347123_hospital";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
