<?php
// Include the database connection
include 'config.php';
include 'session.php'; // Include session management
// Function to hash password
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $address = $_POST['address'];

    // Validate the password and confirm password
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit;
    }

    // Hash the password
    $hashed_password = hashPassword($password);

    // Handle file upload
    $profile_image = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $profile_picture_name = $_FILES['profile_picture']['name'];
        $profile_picture_tmp_name = $_FILES['profile_picture']['tmp_name'];
        $profile_picture_path = "assets/uploads/" . basename($profile_picture_name);

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($profile_picture_tmp_name, $profile_picture_path)) {
            $profile_image = $profile_picture_path;
        } else {
            echo "Error uploading the profile picture.";
            exit;
        }
    }

    // Set created_at and updated_at
    $created_at = date("Y-m-d H:i:s");
    $updated_at = $created_at;

    // Prepare SQL to insert data
    $stmt = $conn->prepare("INSERT INTO users (fullname, username, email, password, Address, Contact_num, profile_image, created_at, updated_at) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $fullname, $username, $email, $hashed_password, $address, $contact, $profile_image, $created_at, $updated_at);

    // Execute the query and check if successful
    if ($stmt->execute()) {
        header("Location: register_success.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
