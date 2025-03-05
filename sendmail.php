<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendOTP($email, $otp) {
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'ginoongsanay1766@gmail.com'; 
        $mail->Password = 'eoyvacauitvmxpzi'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('ginoongsanay1766@gmail.com', 'Barangay Registration');
        $mail->addAddress($email);
        $mail->Subject = "Your OTP Code";
        $mail->Body = "Your OTP code is: $otp. It will expire in 5 minutes.";

        return $mail->send(); // Returns true if sent, false otherwise
    } catch (Exception $e) {
        return false; 
    }
}
?>
