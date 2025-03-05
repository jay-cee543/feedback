<?php
session_start();
require 'conn.php';

// Prevent access if reset session is missing
if (!isset($_SESSION['reset_email'])) {
    header("Location: reset_password.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $email = $_SESSION['reset_email'];

    // Validate password fields
    if (empty($new_password) || empty($confirm_password)) {
        $error_message = "Both password fields are required.";
    } elseif ($new_password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } elseif (strlen($new_password) < 6) {
        $error_message = "Password must be at least 6 characters long.";
    } else {
        // Hash the password before saving
        $hashedPassword = password_hash($new_password, PASSWORD_BCRYPT);

        // Update password in the database
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashedPassword, $email);

        if ($stmt->execute()) {
            unset($_SESSION['reset_email']); // Clear reset session
            echo "<script>
                alert('Password reset successful! You can now login.');
                window.location.href = 'login.php';
                </script>";
            exit();
        } else {
            $error_message = "Error updating password. Please try again.";
        }

        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Set New Password</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

/* Glassmorphism Form */
.password-reset-form {
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
input {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    background: rgba(255, 255, 255, 0.9);
    color: black;
    text-align: center;
    margin-bottom: 15px;
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
.btn-reset {
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

.btn-reset:hover {
    background: #0D4715;
    transform: scale(1.05);
}

/* Responsive Design */
@media (max-width: 768px) {
    .password-reset-form {
        width: 90%;
        padding: 30px;
    }

    h1 {
        font-size: 24px;
    }

    .btn-reset {
        font-size: 16px;
        padding: 12px;
    }
}

    </style>
</head>
<body>
    <div class="password-reset-form">
        <h1>Set New Password</h1>

        <?php if (isset($error_message)) : ?>
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Password Reset Failed",
                    text: "<?php echo $error_message; ?>",
                    confirmButtonColor: "#d33"
                });
            </script>
        <?php endif; ?>

        <form method="POST">
            <label>New Password:</label>
            <input type="password" name="password" required>
            
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" required>
            
            <button type="submit" class="btn-reset">Reset Password</button>
        </form>
    </div>
</body>
</html>
