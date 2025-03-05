<?php
session_start();
require 'conn.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['theme'])) {
    $theme = $_POST['theme'];
    $userId = $_SESSION['user_id'];

    // Update theme in the database
    $stmt = $conn->prepare("UPDATE users SET theme = ? WHERE id = ?");
    $stmt->bind_param("si", $theme, $userId);

    if ($stmt->execute()) {
        $_SESSION['theme'] = $theme; // Store theme in session
        header("Location: user_setting.php");
        exit();
    } else {
        header("Location: user_setting.php?error=Failed to update theme");
        exit();
    }

    $stmt->close();
}
?>
