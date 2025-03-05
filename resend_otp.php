<?php
session_start();
require 'conn.php'; // Include your database connection file
require 'vendor/autoload.php'; // Include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if OTP and email are set in the session
if (!isset($_SESSION['otp'], $_SESSION['register_data']['email'])) {
    echo json_encode(["status" => "error", "message" => "Session expired. Please restart the registration process."]);
    exit();
}

// Get email from session
$email = $_SESSION['register_data']['email'];

// Generate a new OTP
$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp;
$_SESSION['otp_expiry'] = time() + 300; // OTP expires in 5 minutes

try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'ginoongsanay1766@gmail.com'; // Your Gmail address
    $mail->Password = 'eoyvacauitvmxpzi'; // Your Gmail App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('ginoongsanay1766@gmail.com', 'Barangay Registration');
    $mail->addAddress($email);
    $mail->Subject = "New OTP for Account Registration";
    $mail->Body = "Your new OTP code is: $otp. It will expire in 5 minutes.";

    if ($mail->send()) {
        echo json_encode(["status" => "success", "message" => "OTP resent successfully. Check your email."]);
    } else {
        echo json_encode(["status" => "error", "message" => "OTP could not be sent. Please try again."]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Mailer Error: " . $mail->ErrorInfo]);
}
?>