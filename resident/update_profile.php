<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    // Include database connection
    include '../config.php'; // your database connection file

    // Get the form data from the POST request
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $address = $_POST['address'];
    $user_id = $_SESSION['user_id'];

    // Check if any of the fields are empty
    if (empty($fullname) || empty($username) || empty($address)) {
        echo "Please fill in all fields.";
    } else {
        // Insert data into the database (for example, updating user details)
        $sql = "UPDATE users SET fullname = ?, username = ?, address = ? WHERE user_id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssi", $fullname, $username, $address, $user_id);
            
            if ($stmt->execute()) {
                echo "Information updated successfully!";
                header("Location: settings.php?status=success"); // Redirect to the main page after successful update
                exit();
            } else {
                echo "Information updated successful!";
                header("Location: settings.php?status=error"); // Redirect to the main page after successful update
                exit();
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
