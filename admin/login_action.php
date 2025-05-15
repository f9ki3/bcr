<?php
session_start();
include '../config.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT * FROM admin1 WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = "admin";

            // Redirect to dashboard or homepage
            header("Location: dashboard.php");
            exit();
        }
    }

    // Login failed
    header("Location: incident_reports.php?message=error");
    exit();
} else {
    // Invalid access
    header("Location: incident_reports.php");
    exit();
}
