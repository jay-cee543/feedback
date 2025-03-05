<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home - Ginoong Sanay</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Add your CSS styles or link to a stylesheet here -->
    <link href="css/home.css" rel="stylesheet">
    <link href="css/user.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <style>
                /* Body Background with Gradient and Depth */
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #0AD1C8, #12D4A6);
            background-attachment: fixed; /* Keeps background fixed while scrolling */
            height: 100%;
            margin: 0;
            padding: 0;
            color: black; /* Text color to contrast with the background */
        }

        /* Adding texture to the background using a pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('http://localhost/capstone/user/view/image/bg.jpg') no-repeat center center; /* No repeat and centered */
            background-size: cover; /* Ensures the background image covers the entire area */
            opacity: 0.5; /* Make the texture very subtle */
            z-index: -1;
            pointer-events: none; /* Prevent interaction with the overlay */
        }

        /* Hero Section Styles */
        .hero {
            padding: 100px 0; /* Padding for top and bottom */
            text-align: left; /* Align text to the left */
            color: black; /* Dark text color for readability */
            position: relative; /* Positioning context for potential overlays */
        }

        .hero-text {
            z-index: 1; /* Ensure text is above any other elements */
        }

        .hero h1 {
            font-size: 3rem; /* Large font size for the heading */
            font-weight: 700; /* Bold heading */
            margin-bottom: 20px; /* Spacing below the heading */
            text-transform: uppercase; /* Uppercase for emphasis */
        }

        .hero p {
            font-size: 1.25rem; /* Slightly larger font for the paragraph */
            margin-bottom: 30px; /* Spacing below the paragraph */
        }

        .hero .btn {
            padding: 10px 20px; /* Button padding */
            font-size: 1.1rem; /* Button font size */
            border-radius: 50px; /* Rounded button edges */
            transition: background-color 0.3s ease; /* Smooth transition for hover effect */
        }

        .hero .btn:hover {
            background-color: #28a745; /* Darker green on hover */
        }

        /* Image Styles */
        .hero-image img {
            max-width: 100%; /* Responsive image */
            border-radius: 15px; /* Rounded corners */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Subtle shadow for depth */
        }

        /* Center text on mobile and align image on the right */
        .hero-image {
            text-align: right; /* Align image to the right */
        }

        /* Navbar Styles */
        nav {
            background-color: #45DFB1;
        }

        nav ul li {
            margin: 0 15px;
        }

        /* Navbar Links */
        .navbar-nav .nav-link {
            color: black; /* black text for contrast */
            margin-left: 20px; /* Space between links */
            font-weight: 600; /* Bold text */
            transition: color 0.3s; /* Smooth color transition */
        }

        .navbar-nav .nav-link:hover {
            color: aqua; /* Change color on hover */
        }

        /* Active Link Styles */
        .navbar-nav .nav-link.active {
            color: aqua; /* Highlight active link */
            font-weight: bold; /* Bold active link */
            border-bottom: 2px solid black; /* Underline for active link */
        }

        /* Footer Styles */
        footer {
            background-color: #45DFB1;
            padding: 20px;
            text-align: center;
            color: black;
        }

        /* Dark Theme Sticky Navbar Styles */
        .sticky-navbar {
            background-color: #45DFB1; /* Dark background with slight transparency */
            position: sticky; /* Keeps navbar at the top */
            top: 0; /* Positions at the top */
            z-index: 1000; /* Stays above other content */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5); /* Soft shadow for depth */
            transition: background-color 0.3s ease, box-shadow 0.3s ease; /* Smooth transitions */
        }

        /* Change background color on scroll */
        .sticky-navbar.scrolled {
            background-color: rgba(34, 34, 34, 1); /* Fully opaque background when scrolled */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.7); /* Darker shadow effect */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero {
                text-align: center; /* Center text on smaller screens */
            }

            .hero h1 {
                font-size: 2.5rem; /* Adjust heading size for mobile */
            }

            .hero p {
                font-size: 1rem; /* Adjust paragraph size for mobile */
            }

            .hero-image {
                text-align: start; /* Center the image on mobile */
            }

            .navbar-nav .nav-link {
                margin-left: 0;
                padding: 10px;
                font-size: 1.2rem;
            }

            footer {
                padding: 10px;
                font-size: 0.9rem;
            }
        }

    </style> -->
</head>
<body>
    <!-- navbar pages -->
    <nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="admin.login">
            <img src="image/1.jpg" alt="" width="50" height="50" class="d-inline-block align-text-center"> GINOONG SANAY
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="news.php">News Release</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="aboutus.php">About us</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary ms-2" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="hero container">
    <div class="row align-items-center">
        <!-- Hero Text -->
        <div class="hero-text col-md-6">
            <h1>Ginoong Sanay</h1>
            <p>
                Thank you for visiting our barangay’s website. This is your one-stop platform for updates, announcements, and services.
                We aim to keep our community informed and connected. Feel free to explore and learn about our programs, events, and initiatives.
            </p>
            <a href="aboutus.php" class="btn btn-success btn-lg">Learn More</a>
        </div>

        <!-- Hero Image -->
        <div class="col-md-6 text-center">
        <img src="image/1.jpg" alt="Barangay Community" class="img-fluid rounded w-80 ms-5">
        </div>
    </div>
</div>



     <!-- Bootstrap JS -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <!-- <script src="js/login.js"></script> -->
</body>
</html>
