<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    // Include database connection
    include '../config.php'; // your database connection file

    // Get the form data from the POST request
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $user_id = $_SESSION['user_id'];

    // Check if any of the fields are empty
    if (empty($old_password) || empty($new_password)) {
        echo "Please fill in all fields.";
        exit();
    }

    // Fetch the current password hash from the database
    $sql = "SELECT password FROM users WHERE user_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        $stmt->close();

        // Verify old password
        if (password_verify($old_password, $hashed_password)) {
            // Hash the new password
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password
            $update_sql = "UPDATE users SET password = ? WHERE user_id = ?";
            if ($update_stmt = $conn->prepare($update_sql)) {
                $update_stmt->bind_param("si", $new_hashed_password, $user_id);

                if ($update_stmt->execute()) {
                    header("Location: settings.php?status=success2");
                    exit();
                } else {
                    header("Location: settings.php?status=error2");
                    exit();
                }
                $update_stmt->close();
            } else {
                echo "Error preparing update statement: " . $conn->error;
            }
        } else {
            // Old password does not match
            header("Location: settings.php?status=incorrect_old_password");
            exit();
        }
    } else {
        echo "Error preparing select statement: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
