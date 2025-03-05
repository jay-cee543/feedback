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

// Fetch user data from the database using prepared statements
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

$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account - Ginoong Sanay</title>
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

        
    </style>
</head>
<body>
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
        <h1>Welcome, <?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?>!</h1>
        <p>This is your user account page. You can manage your settings, submit complaints, and access certificates from the sidebar.</p>
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

        // para sa history
        history.pushState(null, null, location.href);
            window.onpopstate = function () {
                history.pushState(null, null, location.href);
            };


    </script>
</body>
</html>
