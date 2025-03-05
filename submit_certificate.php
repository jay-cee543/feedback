<?php
session_start();
require 'conn.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Common fields
    $user_id = $_SESSION['user_id'];
    $certificate_type = $_POST['certificate_type'];
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];

    // Optional fields (initialize as NULL)
    $civil_status = $_POST['civil_status'] ?? NULL;
    $purpose = $_POST['purpose'] ?? NULL;
    $duration = $_POST['duration'] ?? NULL;
    $family_members = $_POST['family_members'] ?? NULL;
    $income_source = $_POST['income_source'] ?? NULL;
    $business_name = $_POST['business_name'] ?? NULL;
    $business_address = $_POST['business_address'] ?? NULL;
    $business_type = $_POST['business_type'] ?? NULL;
    $registration_number = $_POST['registration_number'] ?? NULL;

    // Insert the request into the database
    $sql = "INSERT INTO certificates (
        user_id, certificate_type, fullname, address, email, birthdate, civil_status, purpose, 
        duration, family_members, income_source, business_name, business_address, business_type, registration_number
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "issssssssisssss",
        $user_id, $certificate_type, $fullname, $address, $email, $birthdate, $civil_status, $purpose,
        $duration, $family_members, $income_source, $business_name, $business_address, $business_type, $registration_number
    );

    if ($stmt->execute()) {
        echo "Certificate request submitted successfully!";
    } else {
        echo "Error submitting request: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>