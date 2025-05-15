<?php
session_start();
include '../config.php';

if (!isset($_SESSION['User_ID'])) {
    header("Location: login.php");
    exit();
}

$certificate_id = $_GET['id'] ?? null;
$view = isset($_GET['view']);
$download = isset($_GET['download']);

if (!$certificate_id) {
    die("Missing certificate ID.");
}

// Fetch certificate details
$sql = "SELECT certificate_type, user_id, request_date FROM certificate_requests WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $certificate_id);
$stmt->execute();
$result = $stmt->get_result();
$certificate = $result->fetch_assoc();

if (!$certificate) {
    die("Certificate not found.");
}

$certificate_type = $certificate['certificate_type'];
$request_date = $certificate['request_date'];

// Files mapping
$files = [
    'Certificate of Residency' => 'certificate_residency.php',
    'Barangay Clearance' => 'barangay_clearance.php',
    'Certificate of Indigency' => 'certificate_indigency.php'
];

if ($view) {
    if (isset($files[$certificate_type]) && file_exists($files[$certificate_type])) {
        include $files[$certificate_type];
    } else {
        echo "View file not found for certificate type: " . htmlspecialchars($certificate_type);
    }
} elseif ($download) {
    // If your certificate files are PHP-generated content, 
    // you need to capture output and send as a downloadable PDF or similar.
    // Here's a simple example forcing download of a file (if exists).

    if (isset($files[$certificate_type]) && file_exists($files[$certificate_type])) {
        // You can capture output buffer from the included file
        ob_start();
        include $files[$certificate_type];
        $content = ob_get_clean();

        // Send headers to force download as HTML file (change as needed)
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . str_replace(' ', '_', strtolower($certificate_type)) . '.html"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($content));
        echo $content;
        exit();
    } else {
        echo "Download file not found for certificate type: " . htmlspecialchars($certificate_type);
    }
} else {
    echo "No action specified (view or download).";
}
?>
