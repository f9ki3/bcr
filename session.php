<?php
session_start();  // Start the session

// Check if 'user_type' is set in the session
if (isset($_SESSION['user_type'])) {
    $user_type = $_SESSION['user_type'];

    // Redirect based on the user type
    if ($user_type === 'resident') {
        header("Location: ./resident");
        exit;
    } elseif ($user_type === 'admin') {
        header("Location: ./admin");
        exit;
    } else {
        echo 'Unknown user type.';
    }
} else {
    // // 'user_type' is not set, maybe the user is not logged in
    // echo 'You are logged out.';
    // // Optional: redirect to login page
    // // header("Location: login.php");
    // // exit;
}
?>
