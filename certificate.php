<?php
// Start the session
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Include database connection
require 'conn.php'; // Ensure this file contains the MySQLi connection logic

// Fetch user data from the database using prepared statements
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT firstname, middlename, lastname, birthdate, housenumber, street, barangay, email FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// If user not found, redirect to login
if (!$user) {
    header('Location: login.php');
    exit();
}

// Assign user data to variables
$fullname = htmlspecialchars($user['firstname'] . ' ' . $user['lastname']);
$address = htmlspecialchars($user['housenumber'] . ' ' . $user['street'] . ', ' . $user['barangay']);
$email = htmlspecialchars($user['email']);
$birthdate = htmlspecialchars($user['birthdate']);

// Close the statement
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
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
        

 /* Horizontal Scroll Container */
 .scroll-container {
        overflow-x: auto; /* Enable horizontal scrolling */
        white-space: nowrap; /* Prevent wrapping of cards */
        padding-bottom: 10px; /* Add space for scrollbar */
    }

    .scroll-wrapper {
        display: inline-flex; /* Display cards in a row */
        gap: 15px; /* Space between cards */
    }

    .scroll-card {
        display: inline-block; /* Ensure cards stay in a row */
        width: auto; /* Fixed width for cards */
        background: rgba(255, 255, 255, 0.5); /* Transparent white background */
        backdrop-filter: blur(10px); /* Frosted glass effect */
        border: 1px solid rgba(255, 255, 255, 0.5); /* Light border */
        border-radius: 10px; /* Rounded corners */
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; /* Smooth hover effect */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5); /* Subtle shadow */
    }

    .scroll-card:hover {
        transform: translateY(-5px); /* Lift card on hover */
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Stronger shadow on hover */
    }

    /* Custom Scrollbar */
    .scroll-container::-webkit-scrollbar {
        height: 8px; /* Scrollbar height */
    }

    .scroll-container::-webkit-scrollbar-track {
        background: rgba(241, 241, 241, 0.5); /* Transparent scrollbar track */
        border-radius: 10px; /* Rounded track */
    }

    .scroll-container::-webkit-scrollbar-thumb {
        background: rgba(136, 136, 136, 0.7); /* Semi-transparent scrollbar thumb */
        border-radius: 10px; /* Rounded thumb */
    }

    .scroll-container::-webkit-scrollbar-thumb:hover {
        background: rgba(85, 85, 85, 0.8); /* Darker thumb on hover */
    }

      /* Modern Table Styling */
      .card {
        background: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
        backdrop-filter: blur(10px); /* Frosted glass effect */
        border-radius: 10px; /* Rounded corners */
        border: 1px solid rgba(255, 255, 255, 0.3); /* Light border */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead th {
        background-color: #BDB395; /* Dark header background */
        color: black; /* White text */
        font-weight: 600; /* Bold text */
        padding: 12px 15px; /* Padding for header cells */
        border-bottom: 1px solid #495057; /* Dark border below header */
    }

    .table tbody td {
        padding: 12px 15px; /* Padding for table cells */
        border-bottom: 1px solid #e9ecef; /* Light border between rows */
    }

    .table tbody tr:last-child td {
        border-bottom: none; /* Remove border for the last row */
    }

    .table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05); /* Light blue hover effect */
    }

    .badge {
        font-size: 0.9rem; /* Adjust badge font size */
        padding: 6px 10px; /* Padding for badges */
        border-radius: 12px; /* Rounded badge corners */
    }

    .badge.bg-warning {
        background-color: #FFF100; /* Yellow for pending status */
        color: #343a40; /* Dark text for contrast */
    }

    .badge.bg-success {
        background-color: #28a745; /* Green for approved status */
        color: #343a40; /* White text for contrast */
    }

    .badge.bg-danger {
        background-color: #dc3545; /* Red for rejected status */
        color: #343a40; /* White text for contrast */
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
    <!-- Offered Services Section -->
    <div class="mb-5">
        <h3 class="mb-4">Offered Services</h3>
        <div class="scroll-container">
            <div class="scroll-wrapper">
                <!-- Certificate 1 -->
                <div class="card scroll-card">
                    <div class="card-body text-center">
                        <img src="image/approved.png" alt="File Icon" width="32" height="32" class="mb-3">
                        <h5 class="card-title">Barangay Certificate</h5>
                        <!-- Request Button with Modal Trigger -->
                        <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#requestModal1">
                            Request
                        </button>
                    </div>
                </div>
                <!-- Certificate 2 -->
                <div class="card scroll-card">
                    <div class="card-body text-center">
                        <img src="image/approved.png" alt="File Icon" width="32" height="32" class="mb-3">
                        <h5 class="card-title">Certificate of Residency</h5>
                        <!-- Request Button with Modal Trigger -->
                        <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#requestModal2">
                            Request
                        </button>
                    </div>
                </div>
                <!-- Certificate 3 -->
                <div class="card scroll-card">
                    <div class="card-body text-center">
                        <img src="image/approved.png" alt="File Icon" width="32" height="32" class="mb-3">
                        <h5 class="card-title">Certificate of Indigency</h5>
                        <!-- Request Button with Modal Trigger -->
                        <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#requestModal3">
                            Request
                        </button>
                    </div>
                </div>
                <!-- Certificate 4 -->
                <div class="card scroll-card">
                    <div class="card-body text-center">
                        <img src="image/approved.png" alt="File Icon" width="32" height="32" class="mb-3">
                        <h5 class="card-title">Business Clearance</h5>
                        <!-- Request Button with Modal Trigger -->
                        <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#requestModal4">
                            Request
                        </button>
                    </div>
                </div>
                <!-- Certificate 5 -->
                <div class="card scroll-card">
                    <div class="card-body text-center">
                        <img src="image/approved.png" alt="File Icon" width="32" height="32" class="mb-3">
                        <h5 class="card-title">Certificate for Travel</h5>
                        <!-- Request Button with Modal Trigger -->
                        <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#requestModal5">
                            Request
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Your Transactions Section -->
<div class="row">
    <div class="col-md-12">
        <h3 class="mb-4">Your Transactions</h3>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-borderless table-hover">
                        <thead class="bg-info">
                            <tr>
                                <th>#</th>
                                <th>Certificate</th>
                                <th>Date Requested</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $user_id = $_SESSION['user_id'];

                            // Fetch both types of requests
                            $sql = "(SELECT id, certificate_type, requested_at, status FROM certificates WHERE user_id = ?)
                                    UNION
                                    (SELECT id, 'Business Clearance' AS certificate_type, requested_at, 'Pending' AS status FROM business_certificates WHERE user_id = ?)
                                    ORDER BY requested_at DESC";

                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("ii", $user_id, $user_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                $counter = 1;
                                while ($row = $result->fetch_assoc()) {
                                    $certificate_type = htmlspecialchars($row['certificate_type']);
                                    $requested_at = htmlspecialchars($row['requested_at']);
                                    $status = htmlspecialchars($row['status']);

                                    $badge_class = $status === 'Approved' ? 'bg-success' : ($status === 'Rejected' ? 'bg-danger' : 'bg-warning');

                                    echo "<tr>
                                            <td>{$counter}</td>
                                            <td>{$certificate_type}</td>
                                            <td>{$requested_at}</td>
                                            <td><span class='badge {$badge_class}'>{$status}</span></td>
                                          </tr>";
                                    $counter++;
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center'>No certificate requests found.</td></tr>";
                            }

                            $stmt->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals for Each Certificate -->
<!-- Modal 1: Barangay Certificate -->
<div class="modal fade" id="requestModal1" tabindex="-1" aria-labelledby="requestModal1Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestModal1Label">Request Barangay Certificate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="barangayCertificateForm" action="submit_certificate.php" method="POST">
                    <input type="hidden" name="certificate_type" value="Barangay">
                    <!-- Name (Auto-filled from database) -->
                    <div class="mb-3">
                        <label for="name1" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name1" name="fullname" value="<?php echo $fullname; ?>" readonly>
                    </div>

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email1" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email1" name="email" value="<?php echo $email; ?>" readonly>
                    </div>

                    <!-- Address (Auto-filled from database) -->
                    <div class="mb-3">
                        <label for="address1" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address1" name="address" value="<?php echo $address; ?>" readonly>
                    </div>

                    <!-- Birthdate -->
                    <div class="mb-3">
                        <label for="birthdate1" class="form-label">Birthdate</label>
                        <input type="date" class="form-control" id="birthdate1" name="birthdate" value="<?php echo $birthdate; ?>" readonly>
                    </div>

                    <!-- Civil Status -->
                    <div class="mb-3">
                        <label for="civilStatus1" class="form-label">Civil Status</label>
                        <select class="form-select" id="civilStatus1" name="civil_status" required>
                            <option value="" disabled selected>Select Civil Status</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Widowed">Widowed</option>
                            <option value="Separated">Separated</option>
                        </select>
                    </div>

                    <!-- Purpose of Clearance -->
                    <div class="mb-3">
                        <label for="purpose1" class="form-label">Purpose of Clearance</label>
                        <select class="form-select" id="purpose1" name="purpose" required>
                            <option value="" disabled selected>Select Purpose</option>
                            <option value="Employment Requirement">Employment Requirement</option>
                            <option value="Business Permit Application">Business Permit Application</option>
                            <option value="Police Clearance">Police Clearance</option>
                            <option value="NBI Clearance">NBI Clearance</option>
                            <option value="Financial Assistance Application">Financial Assistance Application</option>
                            <option value="Court Purposes">Court Purposes</option>
                            <option value="Scholarship Application">Scholarship Application</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal 2: Certificate of Residency -->
<div class="modal fade" id="requestModal2" tabindex="-1" aria-labelledby="requestModal2Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestModal2Label">Request Certificate of Residency</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="residencyCertificateForm" action="submit_certificate.php" method="POST">
                    <input type="hidden" name="certificate_type" value="Residency">
                    <!-- Name (Auto-filled from database) -->
                    <div class="mb-3">
                        <label for="name2" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name2" name="fullname" value="<?php echo $fullname; ?>" readonly>
                    </div>

                    <!-- Address (Auto-filled from database) -->
                    <div class="mb-3">
                        <label for="address2" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address2" name="address" value="<?php echo $address; ?>" readonly>
                    </div>

                    <!-- Email Address (Auto-filled from database) -->
                    <div class="mb-3">
                        <label for="email2" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email2" name="email" value="<?php echo $email; ?>" readonly>
                    </div>

                    <!-- Duration of Residency -->
                    <div class="mb-3">
                        <label for="duration2" class="form-label">Duration of Residency</label>
                        <input type="text" class="form-control" id="duration2" name="duration" placeholder="e.g., 5 years" required>
                    </div>

                    <!-- Birthdate (Auto-filled from database) -->
                    <div class="mb-3">
                        <label for="birthdate2" class="form-label">Birthdate</label>
                        <input type="date" class="form-control" id="birthdate2" name="birthdate" value="<?php echo $birthdate; ?>" readonly>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal 3: Certificate of Indigency -->
<div class="modal fade" id="requestModal3" tabindex="-1" aria-labelledby="requestModal3Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestModal3Label">Request Certificate of Indigency</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="indigencyCertificateForm" action="submit_certificate.php" method="POST">
                    <input type="hidden" name="certificate_type" value="Indigency">
                    <!-- Name (Auto-filled from database) -->
                    <div class="mb-3">
                        <label for="name3" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name3" name="fullname" value="<?php echo $fullname; ?>" readonly>
                    </div>

                    <!-- Address (Auto-filled from database) -->
                    <div class="mb-3">
                        <label for="address3" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address3" name="address" value="<?php echo $address; ?>" readonly>
                    </div>

                    <!-- Email Address (Auto-filled from database) -->
                    <div class="mb-3">
                        <label for="email3" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email3" name="email" value="<?php echo $email; ?>" readonly>
                    </div>

                    <!-- Birthdate (Auto-filled from database) -->
                    <div class="mb-3">
                        <label for="birthdate3" class="form-label">Birthdate</label>
                        <input type="date" class="form-control" id="birthdate3" name="birthdate" value="<?php echo $birthdate; ?>" readonly>
                    </div>

                    <!-- Civil Status -->
                    <div class="mb-3">
                        <label for="civilStatus3" class="form-label">Civil Status</label>
                        <select class="form-select" id="civilStatus3" name="civil_status" required>
                            <option value="" disabled selected>Select Civil Status</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Widowed">Widowed</option>
                            <option value="Separated">Separated</option>
                        </select>
                    </div>

                    <!-- Number of Family Members -->
                    <div class="mb-3">
                        <label for="familyMembers3" class="form-label">Number of Family Members</label>
                        <input type="number" class="form-control" id="familyMembers3" name="family_members" min="1" required>
                    </div>

                    <!-- Source of Income -->
                    <div class="mb-3">
                        <label for="incomeSource3" class="form-label">Source of Income</label>
                        <input type="text" class="form-control" id="incomeSource3" name="income_source" placeholder="e.g., Farming, Labor, etc." required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal 4: Business Clearance -->
<div class="modal fade" id="requestModal4" tabindex="-1" aria-labelledby="requestModal4Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestModal4Label">Request Business Clearance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="businessClearanceForm" action="submit_business.php" method="POST">
                    <input type="hidden" name="certificate_type" value="Business">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                    <!-- Business Name -->
                    <div class="mb-3">
                        <label for="businessName4" class="form-label">Business Name</label>
                        <input type="text" class="form-control" id="businessName4" name="business_name" required>
                    </div>

                    <!-- Owner's Name (Auto-filled from session) -->
                    <div class="mb-3">
                        <label for="ownerName4" class="form-label">Owner's Name</label>
                        <input type="text" class="form-control" id="ownerName4" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" readonly>
                    </div>

                    <!-- Business Address -->
                    <div class="mb-3">
                        <label for="businessAddress4" class="form-label">Business Address</label>
                        <input type="text" class="form-control" id="businessAddress4" name="business_address" required>
                    </div>

                    <!-- Business Type -->
                    <div class="mb-3">
                        <label for="businessType4" class="form-label">Business Type</label>
                        <select class="form-select" id="businessType4" name="business_type" required>
                            <option value="" disabled selected>Select Business Type</option>
                            <option value="Retail">Retail</option>
                            <option value="Food and Beverage">Food and Beverage</option>
                            <option value="Services">Services</option>
                            <option value="Manufacturing">Manufacturing</option>
                            <option value="Agriculture">Agriculture</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Business Registration Number -->
                    <div class="mb-3">
                        <label for="registrationNumber4" class="form-label">Business Registration Number</label>
                        <input type="text" class="form-control" id="registrationNumber4" name="registration_number" required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal 5: Certificate for Travel -->
<div class="modal fade" id="requestModal5" tabindex="-1" aria-labelledby="requestModal5Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestModal5Label">Request Certificate for Travel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="travelCertificateForm" action="submit_certificate.php" method="POST">
                    <input type="hidden" name="certificate_type" value="Travel">
                    <!-- Name (Auto-filled from database) -->
                    <div class="mb-3">
                        <label for="name5" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name5" name="fullname" value="<?php echo $fullname; ?>" readonly>
                    </div>

                    <!-- Address (Auto-filled from database) -->
                    <div class="mb-3">
                        <label for="address5" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address5" name="address" value="<?php echo $address; ?>" readonly>
                    </div>

                    <!-- Email Address (Auto-filled from database) -->
                    <div class="mb-3">
                        <label for="email5" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email5" name="email" value="<?php echo $email; ?>" readonly>
                    </div>

                    <!-- Birthdate (Auto-filled from database) -->
                    <div class="mb-3">
                        <label for="birthdate5" class="form-label">Birthdate</label>
                        <input type="date" class="form-control" id="birthdate5" name="birthdate" value="<?php echo $birthdate; ?>" readonly>
                    </div>

                    <!-- Civil Status -->
                    <div class="mb-3">
                        <label for="civilStatus5" class="form-label">Civil Status</label>
                        <select class="form-select" id="civilStatus5" name="civil_status" required>
                            <option value="" disabled selected>Select Civil Status</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Widowed">Widowed</option>
                            <option value="Separated">Separated</option>
                        </select>
                    </div>

                    <!-- Purpose of Travel -->
                    <div class="mb-3">
                        <label for="purpose5" class="form-label">Purpose of Travel</label>
                        <select class="form-select" id="purpose5" name="purpose" required>
                            <option value="" disabled selected>Select Purpose</option>
                            <option value="Leisure">Leisure</option>
                            <option value="Business">Business</option>
                            <option value="Medical">Medical</option>
                            <option value="Education">Education</option>
                            <option value="Family Visit">Family Visit</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/certificate.js"></script>
</body>
</html>
