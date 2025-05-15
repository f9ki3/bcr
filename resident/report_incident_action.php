<?php
session_start();
include '../config.php';

// Helper function to sanitize inputs
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Check if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize form inputs
    $reporter_name = sanitize($_POST['complainant'] ?? '');
    $reported_person = sanitize($_POST['respondent'] ?? '');
    $incident_details = sanitize($_POST['incident_details'] ?? '');
    $incident_date = $_POST['incident_date'] ?? '';
    $contact_num = sanitize($_POST['contact_num'] ?? '');
    $location = sanitize($_POST['location'] ?? '');
    $user_id = $_SESSION['user_id'] ?? null;

    // Basic validation
    if (empty($reporter_name) || empty($reported_person) || empty($incident_details) || empty($incident_date)) {
        die('Please fill in all required fields.');
    }

    // Initialize image path
    $image_path = '';

    // Handle optional image upload
    if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image_path']['tmp_name'];
        $fileName = $_FILES['image_path']['name'];
        $fileSize = $_FILES['image_path']['size'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($fileExtension, $allowedfileExtensions)) {
            die('Upload failed. Allowed file types: ' . implode(', ', $allowedfileExtensions));
        }

        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        $uploadFileDir = '../assets/uploads/';
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }

        $dest_path = $uploadFileDir . $newFileName;

        if (!move_uploaded_file($fileTmpPath, $dest_path)) {
            die('Error moving the uploaded file.');
        }

        $image_path = $newFileName;
    }

    // Prepare SQL insert
    $stmt = $conn->prepare("INSERT INTO blotter_reports 
        (reporter_name, contact_num, reported_person, incident_date, incident_details, location, image_path, status, created_at, user_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW(), ?)");

    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param("sssssssi", 
        $reporter_name, 
        $contact_num, 
        $reported_person, 
        $incident_date, 
        $incident_details, 
        $location, 
        $image_path, 
        $user_id
    );

    if ($stmt->execute()) {
        // Redirect with success
        header("Location: report_incident.php?status=success");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    die("Invalid request method.");
}
?>
