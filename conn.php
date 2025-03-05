<?php
// session_start(); // Always start the session at the very top


$servername = "localhost";
$username = "root"; // Change this based on your setup
$password = ""; // Change if you have a DB password
$dbname = "capstone";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
