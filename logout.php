<?php
session_start();
// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// If logout is confirmed via JavaScript
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out...</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        Swal.fire({
            title: "Are you sure?",
            text: "Do you really want to log out?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#16C47F",
            cancelButtonColor: "#E50046",
            confirmButtonText: "Yes",
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with logout
                fetch("logout.php?logout=true").then(() => {
                    Swal.fire({
                        icon: "success",
                        title: "Logged Out Successfully",
                        text: "Redirecting to Barangay page...",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "index.php"; // Redirect to login
                    });
                });
            } else {
                // Cancel logout, redirect back
                window.location.href = "user_page.php"; // Change this to your home/dashboard page
            }
        });
    </script>

</body>
</html>
