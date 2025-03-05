<?php
session_start();

if (!isset($_SESSION['otp'])) {
    header("Location: register.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_otp = $_POST['otp'];

    if ($entered_otp == $_SESSION['otp']) {
        require 'conn.php';

        // Retrieve session data
        $firstname = trim($_SESSION['register_data']['firstname']);
        $middlename = trim($_SESSION['register_data']['middlename']);
        $lastname = trim($_SESSION['register_data']['lastname']);
        $birthdate = $_SESSION['register_data']['year'] . '-' . $_SESSION['register_data']['month'] . '-' . $_SESSION['register_data']['day'];
        $age = (int) $_SESSION['register_data']['age'];
        $email = trim($_SESSION['register_data']['email']);
        $cellphone = trim($_SESSION['register_data']['cellphone']);
        $password = $_SESSION['register_data']['password'];
        $barangay = trim($_SESSION['register_data']['barangay']);
        $housenumber = trim($_SESSION['register_data']['housenumber']);
        $street = trim($_SESSION['register_data']['street']);

        // Validate constraints before inserting
        if ($age < 18) {
            die("Error: Age must be at least 18.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Error: Invalid email format.");
        }

        if (!preg_match('/^[0-9]+$/', $cellphone)) {
            die("Error: Cellphone must contain only numbers.");
        }

        if (!preg_match('/^[0-9]+$/', $housenumber)) {
            die("Error: House number must be a valid number.");
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Prepare and bind statement
        $stmt = $conn->prepare("INSERT INTO users 
    (firstname, middlename, lastname, birthdate, age, email, cellphone, password, barangay, housenumber, street) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssissssss", $firstname, $middlename, $lastname, $birthdate, $age, $email, $cellphone, $hashedPassword, $barangay, $housenumber, $street);


        if ($stmt->execute()) {
            unset($_SESSION['otp']);
            unset($_SESSION['register_data']);
            header("Location: login.php"); // Redirect to login after successful registration
            exit();
        } else {
            die("Error: " . $stmt->error);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        /* Glassmorphism OTP Form */
        .otp-form {
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            color: white;
            width: 100%;
            max-width: 450px;
            position: relative;
        }

        /* Title */
        h1 {
            color: black;
            margin-bottom: 1.5rem;
            font-size: 28px;
        }

        /* Input Fields */
        .input-group {
            color: black;
            margin-bottom: 1.2rem;
        }

        .otp-input {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: black;
            padding: 14px;
            border-radius: 8px;
            font-size: 16px;
            width: 100%;
            text-align: center;
        }

        .otp-input::placeholder {
            color: rgba(0, 9, 11, 0.7);
        }

        .otp-input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.8);
            background: rgba(255, 255, 255, 0.2);
        }

        /* Verify Button */
        .btn-verify {
            background: rgba(40, 167, 69, 0.8);
            color: white;
            border: none;
            width: 80%;
            padding: 14px;
            border-radius: 8px;
            transition: 0.3s;
            font-size: 18px;
            font-weight: bold;
        }

        .btn-verify:hover {
            background: #0D4715;
            transform: scale(1.05);
        }

        /* Timer */
        #timer {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
            color: black;
        }

        /* Resend OTP Button */
        #resendBtn {
            background: rgba(255, 255, 255, 0.2);
            color: black;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s ease-in-out;
        }

        #resendBtn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        #resendBtn:hover:not(:disabled) {
            background: rgba(255, 255, 255, 0.5);
        }

        .notification {
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 1000;
        }

        .notification.success {
            background: rgba(40, 167, 69, 0.9);
        }

        .notification.error {
            background: rgba(220, 53, 69, 0.9);
        }

    </style>
</head>
<body>
    <div class="otp-form">
        <h1>OTP Verification</h1>
        <form method="POST" action="otp_verify.php">
            <div class="input-group">
                <input type="text" name="otp" class="otp-input" placeholder="Enter OTP" required>
            </div>
            <button type="submit" class="btn-verify">Verify</button>
        </form>

        <p id="timer">OTP expires in 5:00</p>
        <button id="resendBtn" disabled>Resend OTP</button>
    </div>

    <!-- Notification Box -->
    <div id="notification" class="notification"></div>

    <script>
    let timeLeft = 300; // 5 minutes
    let timer = document.getElementById('timer');
    let resendBtn = document.getElementById('resendBtn');
    let notification = document.getElementById('notification');
    let countdown;

    // Function to update the timer
    function updateTimer() {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        timer.innerText = `OTP expires in ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

        if (timeLeft <= 0) {
            clearInterval(countdown);
            resendBtn.disabled = false; // Enable resend button only after timer ends
            timer.innerText = "OTP expired. Please request a new one.";
        } else {
            timeLeft--;
        }
    }

    // Start countdown when the page loads
    countdown = setInterval(updateTimer, 1000);

    // Show notification messages
    function showNotification(message, isSuccess) {
        notification.innerText = message;
        notification.className = `notification ${isSuccess ? 'success' : 'error'}`;
        notification.style.display = 'block';

        // Hide the notification after 3 seconds
        setTimeout(() => {
            notification.style.display = 'none';
        }, 3000);
    }

    // Handle Resend OTP button click
    resendBtn.addEventListener('click', async () => {
        resendBtn.disabled = true; // Disable resend button immediately
        try {
            const response = await fetch('resend_otp.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' }
            });
            const result = await response.json();

            if (result.status === 'success') {
                showNotification(result.message, true);
                timeLeft = 300; // Reset timer ONLY when OTP is successfully resent
                clearInterval(countdown);
                countdown = setInterval(updateTimer, 1000);
            } else {
                showNotification(result.message, false);
            }
        } catch (error) {
            showNotification("An error occurred. Please try again.", false);
        }
    });

    // Prevent the timer from resetting on invalid OTP entry
    document.querySelector("form").addEventListener("submit", async (e) => {
        e.preventDefault(); // Prevent default form submission
        let otpInput = document.querySelector("input[name='otp']").value;

        const response = await fetch('otp_verify.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `otp=${otpInput}`
        });

        const result = await response.text();

        if (result.includes("Invalid OTP")) {
            showNotification("Invalid OTP. Please try again.", false);
        } else {
            window.location.href = "login.php"; // Redirect on successful verification
        }
    });
</script>

</body>
</html>