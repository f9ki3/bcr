<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load Composer's autoloader

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';         // Replace with your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'barangay.f176@gmail.com';  // Your email
    $mail->Password = 'ihts gvjp vihz mkdw';   // Your email password or App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('barangay.f176@gmail.com', 'Barangay 176-F');
    $mail->addAddress('floterina@gmail.com', 'Fyke');

    // Content
    $mail->isHTML(true);
    $mail->Subject = '2FA OTP Verification';
    $mail->Body    = 'This is a test email sent using <b>PHPMailer</b>.';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Error: {$mail->ErrorInfo}";
}
