<?php
session_start();

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require 'conn.php';
require 'sendmail.php'; // Include email sending function

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Validate input
    if (empty($email)) {
        die("Email is required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Check if email exists in the database
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        // Generate 6-digit OTP
        $otp = rand(100000, 999999);
        $_SESSION['reset_otp'] = $otp;
        $_SESSION['reset_email'] = $email;

        // Send OTP using PHPMailer
        if (sendOTP($email, $otp)) {
            echo "<script>
                alert('OTP sent! Please check your email.');
                window.location.href = 'verify_reset.php';
                </script>";
        } else {
            die("Error: Unable to send OTP. Please try again.");
        }
    } else {
        die("Email not found.");
    }

    $stmt->close();
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
    <style>
 /* General Styles */
body {
    font-family: Arial, Helvetica, sans-serif;
    background: linear-gradient(135deg, #0AD1C8, #12D4A6);
    background-attachment: fixed;
    margin: 0;
    padding: 0;
    color: black;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

/* Background Overlay */
body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('image/bg.jpg') no-repeat center center;
    background-size: cover;
    opacity: 0.4;
    z-index: -1;
    pointer-events: none;
}

/* Glassmorphism Container */
.container {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(15px);
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    border: 1.5px solid rgba(255, 255, 255, 0.3);
    text-align: center;
    width: 100%;
    max-width: 450px;
}

/* Title */
h1 {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 20px;
    color: black;
}

/* Input Fields */
.input-group {
    margin-bottom: 15px;
}

input {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    background: rgba(255, 255, 255, 0.9);
    color: black;
    text-align: center;
}

input::placeholder {
    color: rgba(0, 0, 0, 0.7);
}

input:focus {
    outline: none;
    border: 2px solid #67C6E3;
    box-shadow: 0 0 8px rgba(103, 198, 227, 0.5);
}

/* Buttons */
.btn {
    background: rgba(40, 167, 69, 0.8);
    color: white;
    padding: 14px;
    border: none;
    border-radius: 8px;
    font-size: 18px;
    cursor: pointer;
    transition: 0.3s;
    width: 100%;
    font-weight: bold;
}

.btn:hover {
    background: #0D4715;
    transform: scale(1.05);
}

/* Links */
a {
    display: inline-block;
    margin-top: 15px;
    font-size: 16px;
    color: #79D7BE;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
    color: #000957;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        width: 90%;
        padding: 30px;
    }

    h1 {
        font-size: 24px;
    }

    .btn {
        font-size: 16px;
        padding: 12px;
    }
}

    </style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
<div class="container">
        <h1>Reset Password</h1>
        <form method="POST" action="reset_password.php">
            <div class="input-group">
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <button type="submit" class="btn">Send OTP</button>
        </form>
        <a href="login.php">Back to Login</a>
    </div>
</body>
</html>