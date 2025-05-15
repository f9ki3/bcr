<?php
include 'config.php'; // Ensure this connects to your DB

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load Composer's autoloader

if (isset($_GET['email'])) {
    $email = urldecode($_GET['email']);
    $otp = rand(100000, 999999); // Generate 6-digit OTP

    // Prepare update statement
    $stmt = $conn->prepare("UPDATE users SET otp = ?, updated_at = NOW() WHERE email = ?");
    $stmt->bind_param("is", $otp, $email);

    if ($stmt->execute()) {
        // Send email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'barangay.f176@gmail.com';
            $mail->Password = 'ihts gvjp vihz mkdw'; // Use App Password for Gmail
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('barangay.f176@gmail.com', 'Barangay 176-F');
            $mail->addAddress($email); // Send to actual user

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code for 2FA Verification';
            $mail->Body = "<p>Hello,</p>
                           <p>Your One-Time Password (OTP) for verification is:</p>
                           <h2>$otp</h2>
                           <p>This OTP is valid for a limited time. Do not share it with anyone.</p>
                           <br><p>— Barangay 176-F</p>";

            $mail->send();
            echo "OTP has been sent to <strong>" . htmlspecialchars($email) . "</strong>.";
            header("Location: otp.php?email=" . urlencode($email));
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error updating OTP: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No email provided.";
}
?>
