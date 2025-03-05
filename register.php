<?php
// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

session_start();
require 'conn.php';
require 'sendmail.php'; // Include the mail function

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname']);
    $middlename = trim($_POST['middlename']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $cellphone = trim($_POST['cellphone']);
    $password = trim($_POST['password']);
    $barangay = trim($_POST['barangay']);
    $housenumber = trim($_POST['housenumber']);
    $street = trim($_POST['street']);

    $birthdate = $_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['day'];
    $age = date_diff(date_create($birthdate), date_create('today'))->y;

    // Prevent users 18 years old and below
    if ($age <= 18) {
        die("You must be above 18 years old to register.");
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        die("Email already exists.");
    }
    $stmt->close();

    $otp = rand(100000, 999999); // Generate 6-digit OTP
    $_SESSION['otp'] = $otp;
    $_SESSION['register_data'] = $_POST;

    // Call the function from sendmail.php
    if (sendOTP($email, $otp)) {
        header("Location: otp_verify.php");
        exit();
    } else {
        die("OTP could not be sent. Please try again.");
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
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

            .container {
                width: 100%;
                max-width: 800px;
                padding: 25px;
            }

            .register-form {
                background: rgba(255, 255, 255, 0.2);
                padding: 40px;
                border-radius: 16px;
                backdrop-filter: blur(10px);
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
                border: 1.5px solid rgba(255, 255, 255, 0.3);
            }

            .form-title {
                text-align: center;
                margin-bottom: 25px;
                font-size: 30px;
                text-transform: uppercase;
                color: black;
                font-weight:bold;
            }

            /* Form Grid */
            .form-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 20px;
                width: 100%;
            }

            .input-group {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .input-group label {
                font-size: 14px;
                color: black;
                opacity: 0.9;
            }

            input, select {
                padding: 12px;
                border: none;
                border-radius: 8px;
                font-size: 16px;
                background: rgba(255, 255, 255, 0.9);
                color: black;
                transition: border 0.3s ease;
            }

            input::placeholder, select::placeholder {
                color: black;
            }

            input:focus, select:focus {
                outline: none;
                border: 2px solid #67C6E3;
                box-shadow: 0 0 8px rgba(103, 198, 227, 0.5);
            }

            /* Birthday Fields */
            .birthday-fields {
                display: flex;
                gap: 10px;
            }

            .birthday-fields select, .birthday-fields input {
                flex: 1;
            }

            /* Buttons */
            .btn-submit {
                background: rgba(40, 167, 69, 0.8); /* Success green with transparency */
                color: white;
                padding: 14px 24px;
                border: none;
                border-radius: 10px;
                font-size: 18px;
                cursor: pointer;
                transition: background 0.3s, transform 0.2s;
                margin-top: 20px;
                width: 100%;
                max-width: 300px;
            }
                        

            .btn-submit:hover {
                background: #5DEBD7;
                transform: scale(1.05);
                color:black;
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

            a {
                position: relative;
                font-size:18px;
            }

            a::before {
                content: "";
                position: absolute;
                width: 100%;
                height: 2px;
                bottom: 0;
                left: 0;
                background:#79D7BE;
                transform: scaleX(0);
                transform-origin: right;
                transition: transform 0.3s ease-in-out;
            }

            a:hover::before {
                transform: scaleX(1);
                transform-origin: left;
            }



            .terms {
                display: flex;
                justify-content: center; /* Center horizontally */
                text-align: center;
                margin-top: 10px;
                white-space: nowrap; /* Prevents text from wrapping */
            }

            .terms label {
                display: flex;
                align-items: center;
                gap: 5px; /* Adds spacing between checkbox and text */
                font-size: 17px;
                color: black;
                opacity: 0.9;
            }

            .terms input[type="checkbox"] {
                transform: scale(1.1);
                cursor: pointer;
            }

            .terms a {
                color: #79D7BE;
                text-decoration: none;
            }

            .terms a:hover {
                text-decoration: underline;
                color:  #000957;
            }


            /* Login Link */
            .login-link {
                text-align: center;
                margin-top: 20px;
                color: black;
                opacity: 0.9;
                font-size:17px;
            }

            .login-link a {
                color: #79D7BE;
                text-decoration: none;
            }

            .login-link a:hover {
                text-decoration: underline;
                color:  #000957;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .form-grid {
                    grid-template-columns: 1fr;
                }

                .form-title {
                    font-size: 24px;
                }

                .btn-submit {
                    font-size: 16px;
                    padding: 12px 20px;
                }
            }
    </style>
</head>
    <div class="container">
        <form method="POST" action="register.php" class="register-form">
            <!-- Back Icon -->
            <a href="index.php" class="back-icon"><i class="fa-solid fa-backward-fast"></i></a>

            <h1 class="form-title">Register</h1>

            <!-- Form Grid Container -->
            <div class="form-grid">
                <!-- Name Fields -->
                <div class="input-group">
                    <input type="text" id="firstname" name="firstname" class="form-control" placeholder="First Name" required>
                </div>

                <div class="input-group">
                    <input type="text" id="middlename" name="middlename" class="form-control" placeholder="Middle Name">
                </div>

                <div class="input-group">
                    <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Last Name" required>
                </div>

                <!-- Birthday Fields -->
                <div class="input-group">
                    <div class="birthday-fields">
                        <select id="month" name="month" class="form-control" required>
                            <option value="">Month</option>
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        <input type="number" id="day" name="day" class="form-control" placeholder="Day" min="1" max="31" required>
                        <input type="number" id="year" name="year" class="form-control" placeholder="Year" min="1900" max="2023" required>
                    </div>
                </div>

                <!-- Age Field -->
                <div class="input-group">
                    <input type="number" id="age" name="age" class="form-control" placeholder="Age" required>
                </div>

                <!-- Address Fields -->
                <div class="input-group">
                    <input type="text" id="housenumber" name="housenumber" class="form-control" placeholder="House Number" required>
                </div>

                <div class="input-group">
                    <input type="text" id="street" name="street" class="form-control" placeholder="Street" required>
                </div>

                <!-- Barangay Selection -->
                <div class="input-group">
                    <select id="barangay" name="barangay" class="form-control" required>
                        <option value="">Select Barangay</option>
                        <option value="Kalawaan">Kalawaan</option>
                        <option value="Pantok">Pantok</option>
                        <option value="Calumpang">Calumpang</option>
                        <option value="Libis">Libis</option>
                        <option value="Pag-asa">Pag-asa</option>
                    </select>
                </div>

                <!-- Email Field -->
                <div class="input-group">
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email Address" required>
                </div>

                <!-- Cellphone Number Field -->
                <div class="input-group">
                    <input type="tel" id="cellphone" name="cellphone" class="form-control" placeholder="Cellphone Number (e.g., 09123456789)" required>
                </div>

                <!-- Password Fields -->
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <div class="input-group">
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                </div>

                <!-- Terms and Conditions -->
                    <div class="input-group terms">
                        <label>
                            <input type="checkbox" id="agree" name="agree" required>
                            I agree to the 
                            <a href="term.php" target="_blank">Terms and Conditions</a> and 
                            <a href="privacy.php" target="_blank">Privacy Policy</a>.
                        </label>
                    </div>

            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">Register</button>

            <!-- Login Link -->
            <p class="login-link">Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/register.js"></script>
    
</body>
</html>