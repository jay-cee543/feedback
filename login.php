<?php
session_start();
// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require 'conn.php'; // Make sure you have a file for database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;

    if (!empty($email) && !empty($password)) {
        // Prepare the SQL statement
        $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];

                // Redirect to dashboard
                header("Location: user_page.php");
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Invalid email or password.";
        }

        $stmt->close();
    } else {
        $error = "All fields are required.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="css/login.css" rel="stylesheet"> -->
     <style>
                /* Body Background with Gradient and Depth */
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

        /* Adding texture to the background using an overlay */
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

        /* Larger Glassmorphism Form */
        form {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px);
            border: 1.5px solid rgba(255, 255, 255, 0.6);
            padding: 2.5rem; /* Increased padding */
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            color: white;
            width: 100%;
            max-width: 450px; /* Increased width */
            height:auto;
            position: relative;
        }

        /* Back Icon - Positioned at the Top Left */
        .back-icon {
            position: absolute;
            top: 15px;
            left: 15px;
            font-size: 24px; /* Slightly bigger */
            color: black;
            text-decoration: none;
            transition: 0.5s;
        }

        .back-icon:hover {
            color:#E50046;
            transform: scale(1.1);
        }

        /* Title */
        h1 {
            color:black;
            margin-bottom: 1.5rem;
            font-size: 28px; /* Larger title */
        }

        /* Input Fields */
        .input-group {
            color:black;
            margin-bottom: 1.2rem;
        }

        .form-control {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: black;
            padding: 14px; /* Bigger padding */
            border-radius: 8px;
            font-size: 16px; /* Bigger text */
        }

        .form-control::placeholder {
            color: rgba(0, 9, 11, 0.7);
        }

        .form-control:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.8);
            background: rgba(255, 255, 255, 0.2);
        }

        /* Success Button with Glass Effect */
        .btn {
            background: rgba(40, 167, 69, 0.8); /* Success green with transparency */
            color: white;
            border: none;
            width: 80%;
            padding: 14px; /* Bigger button */
            border-radius: 8px;
            transition: 0.3s;
            font-size: 18px; /* Bigger text */
            font-weight: bold;
        }
        .btn:hover {
            background: #5DEBD7;
            transform: scale(1.05);
            color:black;
        }

        /* Links */
        a {
            color: black;
            font-size: 17px;
            display: block;
            margin-top: 12px;
            transition: 0.3s ease-in-out;
            position: relative;
            text-decoration: none;
        }

        /* New Hover Effect */
        a::after {
            content: "";
            display: block;
            width: 0;
            height: 2px;
            background:#79D7BE; /* Cyan underlining effect */
            transition: width 0.3s ease-in-out;
            position: absolute;
            bottom: -3px;
            left: 50%;
            transform: translateX(-50%);
            
        }

        /* On hover, expand the underline and change text color */
        a:hover {
            color: #000957; /* Bright cyan */
            font-weight:bold;
        }

        a:hover::after {
            width: 100%;
        }
     </style>

</head>
<body>
<form method="POST" action="login.php">
    <a href="index.php" class="back-icon">
        <i class="fa-solid fa-backward-fast"></i>
    </a>

    <h1>Login</h1>
    
    <div class="input-group">
        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
    </div>

    <div class="input-group">
        <span class="input-group-text"><i class="fas fa-lock"></i></span>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
    </div>

    <button type="submit" class="btn">Login</button>

    <a href="reset_password.php">Forgot Password</a>
    <a href="register.php">Don't have an account? Register</a>
</form>

</body>
</html>
