<?php
session_start();  // Start the session to store user data

include 'config.php'; // Include the database connection

// Check if the form is submitted using the POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Retrieve email and OTP values from POST data
    $email = $_POST['email'] ?? '';  // Use null coalescing operator to check if email is set
    $otp = isset($_POST['otp']) ? implode('', $_POST['otp']) : '';  // Combine OTP array into a single string

    // Sanitize inputs to prevent XSS attacks
    $email = htmlspecialchars($email);
    $otp = htmlspecialchars($otp);

    // Output email and OTP (for testing purposes)
    echo "Email: " . $email . "<br>";
    echo "OTP: " . $otp . "<br>";

    // Prepare SQL statement to fetch OTP and user ID from the database based on the email
    $stmt = $conn->prepare("SELECT otp, User_ID FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);  // Bind the email parameter to the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user with the given email exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();  // Fetch the user data
        
        // Verify if the provided OTP matches the stored OTP
        if ((int)$user['otp'] === (int)$otp) {
            // OTP is valid, store user ID in the session
            $_SESSION['user_id'] = $user['User_ID'];  // Save the user's ID in the session
            $_SESSION['user_type'] = 'resident';  // Save the user's type in the session

            echo "OTP Verified Successfully!";
            header("Location: resident/index.php");  // Redirect to the main page after successful verification
        } else {
            header("Location: otp.php?email=" . urlencode($email) . "&status=incorrect_otp");
            exit(); // Always good to follow header() with exit
            // Redirect to OTP page with error status
        }

    } else {
        echo "No user found with this email.";
    }

    // Close the statement
    $stmt->close();
    // Close the database connection
    $conn->close();

} else {
    // Display an error message if the request method is not POST
    echo "Invalid request method.";
}
?>
