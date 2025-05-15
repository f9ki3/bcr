<?php
$servername = "localhost";
$username = "root";  // Default username sa XAMPP
$password = "123";      // Walang password sa XAMPP
$database = "bcr"; // Siguraduhin tama ito!

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
