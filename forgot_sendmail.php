<?php

require 'config.php';                 // Database connection
require 'vendor/autoload.php';        // Load PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    if (!isset($_GET['email'])) {
        exit("Email not provided.");
    }

    $email = filter_var(trim($_GET['email']), FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit("Invalid email format.");
    }

    // Generate and hash a 6-digit temporary password
    $temp_password = rand(100000, 999999);
    $hashed_password = password_hash($temp_password, PASSWORD_DEFAULT);

    // Update the user's password in the database
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);

    if (!$stmt->execute()) {
        exit("Failed to update password.");
    }
    $stmt->close();

    // Prepare the email
    $subject = "Your Temporary Password";
    $body = "
        <p>Hello,</p>
        <p>Your temporary password is: <strong>$temp_password</strong></p>
        <p>Please log in using this password and change it immediately.</p>
        <br>
        <p>— Barangay 176-F</p>
    ";

    // Send email using PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'barangay.f176@gmail.com';
        $mail->Password   = 'ihts gvjp vihz mkdw'; // Use app-specific password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('barangay.f176@gmail.com', 'Barangay 176-F');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();

        // Redirect to login page with a success message
        header("Location: login.php?reset=success");
        exit;

    } catch (Exception $e) {
        exit("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }

} else {
    exit("Invalid request method.");
}
