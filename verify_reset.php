<?php
session_start();
// header('Content-Type: application/json'); // Ensure response is JSON

// If no OTP is set, return error
if (!isset($_SESSION['reset_otp']) || !isset($_SESSION['reset_email'])) {
    echo json_encode(["status" => "error", "message" => "Session expired. Please restart password reset process."]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_otp = $_POST['otp'];

    if ($entered_otp == $_SESSION['reset_otp']) {
        unset($_SESSION['reset_otp']); // Remove OTP after successful verification
        echo json_encode(["status" => "success", "message" => "OTP verified. Redirecting..."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid OTP. Please try again."]);
    }
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Verify OTP</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css"> <!-- Add your CSS for styling -->
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

        /* Glassmorphism OTP Form */
        .otp-form {
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

        /* Input Field */
        .otp-input {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.9);
            color: black;
            text-align: center;
        }

        .otp-input::placeholder {
            color: rgba(0, 0, 0, 0.7);
        }

        .otp-input:focus {
            outline: none;
            border: 2px solid #67C6E3;
            box-shadow: 0 0 8px rgba(103, 198, 227, 0.5);
        }

        /* Verify Button */
        .btn-verify {
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

        .btn-verify:hover {
            background: #0D4715;
            transform: scale(1.05);
        }

        /* Timer */
        #timer {
            font-size: 18px;
            font-weight: bold;
            margin-top: 15px;
            color: black;
        }

        /* Resend OTP Button */
        #resendBtn {
            background: rgba(255, 255, 255, 0.2);
            color: black;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            width: 100%;
        }

        #resendBtn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        #resendBtn:hover:not(:disabled) {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .otp-form {
                width: 90%;
                padding: 30px;
            }

            h1 {
                font-size: 24px;
            }

            .btn-verify {
                font-size: 16px;
                padding: 12px;
            }
        }

    </style>
</head>
<body>
    <div class="otp-form">
        <h1>Verify OTP</h1>
        <?php if (isset($error_message)) : ?>
            <script>
                Swal.fire({
                    icon: "error",
                    title: "OTP Verification Failed",
                    text: "<?php echo $error_message; ?>",
                    confirmButtonColor: "#d33"
                });
            </script>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="otp" placeholder="Enter OTP" required class="otp-input">
            <button type="submit" class="btn-verify">Verify</button>
        </form>

        <p id="timer">OTP expires in 5:00</p>
        <button id="resendBtn" disabled>Resend OTP</button>
    </div>

    <script>
    let timeLeft = 300; // 5 minutes
    let timer = document.getElementById('timer');
    let resendBtn = document.getElementById('resendBtn');
    let countdown;

    // Function to update the timer
    function updateTimer() {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        timer.innerText = `OTP expires in ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

        if (timeLeft <= 0) {
            clearInterval(countdown);
            resendBtn.disabled = false; // Enable resend button only after timer expires
            timer.innerText = "OTP expired. Please request a new one.";
        } else {
            timeLeft--;
        }
    }

    // Start countdown when the page loads
    countdown = setInterval(updateTimer, 1000);

    // Handle Resend OTP button click
    resendBtn.addEventListener('click', async () => {
    resendBtn.disabled = true; // Disable resend button immediately
    try {
        const response = await fetch('resend_otp_reset.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'reset_password' }) // Specify the action
        });
        const result = await response.json();

        if (result.status === 'success') {
            Swal.fire({
                icon: "success",
                title: "OTP Resent",
                text: result.message
            });

            timeLeft = 300; // Reset timer ONLY when OTP is resent
            clearInterval(countdown);
            countdown = setInterval(updateTimer, 1000);
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: result.message
            });
            resendBtn.disabled = false; // Re-enable the button if there's an error
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "An error occurred. Please try again."
        });
        resendBtn.disabled = false; // Re-enable the button if there's an error
    }
});


document.querySelector("form").addEventListener("submit", async (e) => {
    e.preventDefault(); // Prevent default form submission
    let otpInput = document.querySelector("input[name='otp']").value;

    try {
        const response = await fetch('verify_reset.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `otp=${otpInput}`
        });

        const result = await response.json(); // Parse JSON response

        if (result.status === "error") {
            Swal.fire({
                icon: "error",
                title: "OTP Verification Failed",
                text: result.message,
                confirmButtonColor: "#d33"
            });
        } else if (result.status === "success") {
            Swal.fire({
                icon: "success",
                title: "OTP Verified",
                text: result.message,
                confirmButtonColor: "#3085d6"
            }).then(() => {
                window.location.href = "new_password.php"; // Redirect only if OTP is correct
            });
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Something went wrong. Please try again.",
            confirmButtonColor: "#d33"
        });
    }
});

</script>
</body>
</html>
