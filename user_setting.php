<?php
// Start the session
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
require 'conn.php';

// Fetch user data (including theme) from the database using prepared statements
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// If user not found, redirect to login
if (!$user) {
    header('Location: login.php');
    exit();
}

// Get theme from fetched user data
$theme = isset($user['theme']) ? $user['theme'] : 'light'; // Default is light mode

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: rgba(13, 198, 105, 0.63);
            font-family: Arial, sans-serif;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar .profile-pic {
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar .profile-pic img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid #fff;
        }
        .sidebar .nav-link {
            color: #fff;
            padding: 10px 20px;
            margin: 5px 0;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
        }
        .navbar {
            margin-left: 250px; /* Move navbar to the right */
            width: calc(100% - 250px); /* Adjust width to fit screen */
        }
        .text-white {
            transition: color 0.3s ease-in-out;
            font-weight:bold;
        }

        .text-white:hover {
            color: #A1E3F9 !important; /* Change to gold on hover */
            cursor: pointer; /* Optional: Show pointer cursor */
        }

        @media (max-width: 768px) {
            .navbar {
                margin-left: 0;
                width: 100%;
            }
        }

        .card {
    background: rgba(255, 255, 255, 0.5); /* Transparent glass effect */
    backdrop-filter: blur(10px); /* Blur effect */
    -webkit-backdrop-filter: blur(10px); /* Safari support */
    border: 1px solid rgba(255, 255, 255, 0.5); /* Subtle border */
    border-radius: 12px; /* Smooth rounded corners */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.7); /* Soft shadow */
    padding: 20px;
    color: black; /* Ensuring text visibility */
}

.card-title {
    font-weight: bold;
}

.card .form-label {
    color: black; /* black labels for contrast */
}

.form-control {
    background: rgba(255, 255, 255, 0.2); /* Semi-transparent input fields */
    color: black; /* White text */
    border: 1px solid #80CBC4; /* Black border for input fields */
    border-radius: 8px;
}

.form-control::placeholder {
    color: rgba(255, 255, 255, 0.6); /* Light placeholder text */
}

.btn-primary {
    background: rgba(0, 123, 255, 0.8); /* Soft blue button */
    border: none;
    transition: 0.3s ease;
}

.btn-primary:hover {
    background: rgba(0, 123, 255, 1);
}

    </style>

<style>
        body {
            background-color: <?php echo ($theme == 'dark') ? '#121212' : 'rgba(13, 198, 105, 0.63)'; ?>;
            color: <?php echo ($theme == 'dark') ? '#ffffff' : '#000000'; ?>;
            font-family: Arial, sans-serif;
        }
        .card {
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid black;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body >
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Left Side: Logo + Barangay Name -->
        <div class="d-flex align-items-center">
            <img src="image/1.jpg" alt="Logo" width="40" height="40" class="me-2 rounded-circle">
            <span class="text-white">
                 Barangay <?php echo htmlspecialchars($user['barangay']); ?>
            </span>
        </div>

        <!-- Right Side: Live Date and Time -->
        <span id="liveDateTime" class="text-white"></span>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Profile Picture -->
    <div class="profile-pic">
        <img src="image/profile.png" alt="Profile Picture">
        <h5 class="text-white mt-2"><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></h5>
    </div>

    <!-- Navigation Links -->
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="complaint_form.php">
                <img src="image/complaint.png" alt="Complaint" width="30"> Complaint Form
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="certificate.php">
                <img src="image/approved.png" alt="Barangay Certificate Icon" width="30"> Certificate
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="user_setting.php">
                <img src="image/user.png" alt="user setting" width="30"> Settings
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">
                <img src="image/logout.png" alt="log out" width="30"> Logout
            </a>
        </li>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content">
    <h1>User Settings</h1>

    <!-- Account Management Section -->
    <div class="settings-section">
        <h2>Account Management</h2>

        <!-- Edit Profile -->
        <div class="card mb-3">
    <div class="card-body">
        <h3 class="card-title">Edit Profile</h3>
        <form action="update_profile.php" method="POST">
            <div class="mb-3">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="cellphone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="cellphone" name="cellphone" value="<?php echo htmlspecialchars($user['cellphone']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="housenumber" class="form-label">House Number</label>
                <input type="text" class="form-control" id="housenumber" name="housenumber" value="<?php echo htmlspecialchars($user['housenumber']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="street" class="form-label">Street</label>
                <input type="text" class="form-control" id="street" name="street" value="<?php echo htmlspecialchars($user['street']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="barangay" class="form-label">Barangay</label>
                <input type="text" class="form-control" id="barangay" name="barangay" value="<?php echo htmlspecialchars($user['barangay']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</div>


        <!-- Change Password -->
        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title">Change Password</h3>
                <form action="change_password.php" method="POST">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </form>
            </div>
        </div>

        <!-- Profile Picture Upload -->
        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title">Profile Picture</h3>
                <img src="profile_picture.jpg" alt="Profile Picture" class="profile-picture mb-3">
                <form action="upload_profile_picture.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Upload New Picture</label>
                        <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>

        <!-- Delete Account -->
        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title">Delete Account</h3>
                <p class="text-danger">Warning: This action cannot be undone.</p>
                <form action="delete_account.php" method="POST" onsubmit="return confirm('Are you sure you want to delete your account?');">
                    <div class="mb-3">
                        <label for="password" class="form-label">Enter Password to Confirm</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Display & Accessibility Section -->
    <div class="settings-section">
        <h2>Display & Accessibility</h2>

        <!-- Dark Mode / Light Mode -->
        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title">Theme</h3>
                <form action="update_theme.php" method="POST">
                    <div class="mb-3">
                        <label for="theme" class="form-label">Select Theme</label>
                        <select class="form-select" id="theme" name="theme">
                            <option value="light">Light Mode</option>
                            <option value="dark">Dark Mode</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Theme</button>
                </form>
            </div>
        </div>

        <!-- Font Size & Language Settings -->
        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title">Font Size & Language</h3>
                <form action="update_font_language.php" method="POST">
                    <div class="mb-3">
                        <label for="font_size" class="form-label">Font Size</label>
                        <select class="form-select" id="font_size" name="font_size">
                            <option value="small">Small</option>
                            <option value="medium">Medium</option>
                            <option value="large">Large</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="language" class="form-label">Language</label>
                        <select class="form-select" id="language" name="language">
                            <option value="en">English</option>
                            <option value="es">Filipino</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function updateDateTime() {
        const now = new Date();
        const options = { 
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', 
            hour: '2-digit', minute: '2-digit', second: '2-digit' 
        };
        const formattedDateTime = now.toLocaleDateString('en-US', options);
        document.getElementById('liveDateTime').textContent = formattedDateTime;
    }

    // Update the date and time every second
    setInterval(updateDateTime, 1000);

    // Initialize the date and time immediately
    updateDateTime();

    // Prevent back button
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.pushState(null, null, location.href);
    };
</script>
</body>
</html>