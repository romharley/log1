<?php
$host = "localhost";
$user = "root"; // Change if your MySQL username is different
$pass = "";     // Change if you have a password
$db   = "logistics_db"; // Change to your actual database name

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: uncomment for debug
// echo "Connected successfully";
?>
