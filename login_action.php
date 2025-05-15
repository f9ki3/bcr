<?php
include 'config.php'; // Include DB connection
include 'session.php'; // Include session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Fetch user by username and get both password and email
    $stmt = $conn->prepare("SELECT password, email FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Check password
        if (password_verify($password, $user['password'])) {
            // Sanitize email for use in URL
            $email = urlencode($user['email']);
            header("Location: sendmail.php?email=$email");
            exit();
        } else {
            header("Location: login.php?message=error");
            exit();
        }
    } else {
        header("Location: login.php?message=error");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
