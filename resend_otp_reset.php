<?php
session_start();
require 'conn.php'; // Include your database connection file
require 'vendor/autoload.php'; // Include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if OTP and email are set in the session for password reset
if (!isset($_SESSION['reset_otp'], $_SESSION['reset_email'])) {
    echo json_encode(["status" => "error", "message" => "Session expired. Please restart the password reset process."]);
    exit();
}

// Get email from session
$email = $_SESSION['reset_email'];

// Check if the email exists in the database
$stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "Email not found in the database."]);
    exit();
}

// Generate a new OTP
$otp = rand(100000, 999999);
$_SESSION['reset_otp'] = $otp;
$_SESSION['reset_otp_expiry'] = time() + 300; // OTP expires in 5 minutes

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
    $mail->Subject = "New OTP for Password Reset";
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