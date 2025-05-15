<?php
// Include database connection
session_start();
include '../config.php';

// Helper function to sanitize inputs
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Check if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize form inputs
    $fullname = sanitize($_POST['fullname'] ?? '');
    $address = sanitize($_POST['address'] ?? '');
    $contact = sanitize($_POST['contact'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $birthdate = $_POST['birthdate'] ?? '';
    $birthplace = sanitize($_POST['birthplace'] ?? '');
    $age = (int)($_POST['age'] ?? 0);
    $gender = sanitize($_POST['gender'] ?? '');
    $civil_status = sanitize($_POST['civil_status'] ?? '');
    $religion = sanitize($_POST['religion'] ?? '');
    
    $purpose = sanitize($_POST['purpose'] ?? '');
    $other_purpose = sanitize($_POST['other_purpose'] ?? '');
    $certificateType = sanitize($_POST['certificateType'] ?? '');
     $user_id = $_SESSION['user_id'];

    // If purpose is Other, use the other_purpose input
    if ($purpose === 'Other' && !empty($other_purpose)) {
        $purpose = $other_purpose;
    }

    // Validate required fields (simplified here)
    if (empty($fullname) || empty($address) || empty($contact) || empty($email) || empty($birthdate) ||
        empty($birthplace) || $age <= 0 || empty($gender) || empty($civil_status) || empty($religion) ||
        empty($purpose) || empty($certificateType)) {
        die('Please fill in all required fields.');
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Invalid email address.');
    }

    // Handle file upload for proof_of_identity
    if (isset($_FILES['proof_of_identity']) && $_FILES['proof_of_identity']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['proof_of_identity']['tmp_name'];
        $fileName = $_FILES['proof_of_identity']['name'];
        $fileSize = $_FILES['proof_of_identity']['size'];
        $fileType = $_FILES['proof_of_identity']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'pdf'];

        if (!in_array($fileExtension, $allowedfileExtensions)) {
            die('Upload failed. Allowed file types: ' . implode(', ', $allowedfileExtensions));
        }

        // Sanitize file name and create a unique name to avoid overwriting
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // Directory where files will be stored
        $uploadFileDir = '../assets/proof_of_identity/';
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }

        $dest_path = $uploadFileDir . $newFileName;

        if (!move_uploaded_file($fileTmpPath, $dest_path)) {
            die('Error moving the uploaded file.');
        }
    } else {
        die('Please upload your proof of identity.');
    }

    // Prepare and execute the database insert
    $stmt = $conn->prepare("INSERT INTO certificate_requests 
        (fullname, address, contact, email, birthdate, birthplace, age, gender, civil_status, religion, purpose, certificate_type, proof_of_identity, request_date, user_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");


    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param("ssssssissssssi",
        $fullname,
        $address,
        $contact,
        $email,
        $birthdate,
        $birthplace,
        $age,
        $gender,
        $civil_status,
        $religion,
        $purpose,
        $certificateType,
        $newFileName,
        $user_id
    );


    if ($stmt->execute()) {
        echo "Request submitted successfully!";
        // Optionally, redirect to a thank you page:
        header("Location: request_certificate.php?status=success");
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
