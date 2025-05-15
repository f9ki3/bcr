<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    include '../config.php'; // Database connection

    $user_id = $_SESSION['user_id'];
    $uploadDir = '../assets/uploads/';
    $minSize = 3 * 1024 * 1024; // 3MB
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

    // Check if file was uploaded
    if (!isset($_FILES['profile_pic']) || $_FILES['profile_pic']['error'] !== UPLOAD_ERR_OK) {
        header("Location: settings.php?status=error_upload");
        exit();
    }

    $file = $_FILES['profile_pic'];
    $fileTmpPath = $file['tmp_name'];
    $fileName = basename($file['name']);
    $fileSize = $file['size'];
    $fileType = mime_content_type($fileTmpPath);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Validate file type
    if (!in_array($fileType, $allowedTypes)) {
        header("Location: settings.php?status=invalid_type");
        exit();
    }
    
    // Create a unique filename
    $newFileName = uniqid('profile_', true) . '.' . $fileExt;
    $destination = $uploadDir . $newFileName;

    // Move the file
    if (move_uploaded_file($fileTmpPath, $destination)) {
        // Save to database
        $sql = "UPDATE users SET profile_image = ? WHERE user_id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("si", $newFileName, $user_id);
            if ($stmt->execute()) {
                header("Location: settings.php?status=upload_success");
                exit();
            } else {
                header("Location: settings.php?status=db_error");
                exit();
            }
            $stmt->close();
        } else {
            header("Location: settings.php?status=prepare_error");
            exit();
        }
    } else {
        header("Location: settings.php?status=move_failed");
        exit();
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
