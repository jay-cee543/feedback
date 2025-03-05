<?php
session_start();
require 'conn.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        die("Error: User not logged in.");
    }

    // Retrieve user session data
    $user_id = $_SESSION['user_id'];
    $fullname = $_SESSION['fullname'] ?? '';

    // Get form data
    $business_name = $_POST['business_name'] ?? null;
    $business_address = $_POST['business_address'] ?? null;
    $business_type = $_POST['business_type'] ?? null;
    $registration_number = $_POST['registration_number'] ?? null;

    // Validate required fields
    if (empty($business_name) || empty($business_address) || empty($business_type) || empty($registration_number)) {
        die("Error: All fields are required.");
    }

    // Insert into database
    $sql = "INSERT INTO business_certificates (user_id, fullname, business_name, business_address, business_type, registration_number)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $user_id, $fullname, $business_name, $business_address, $business_type, $registration_number);

    if ($stmt->execute()) {
        echo "Business Clearance request submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>
