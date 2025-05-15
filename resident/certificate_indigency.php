<?php
include '../config.php';

if (!isset($_SESSION['User_ID'])) {
    die("Unauthorized access.");
}

$User_ID = $_SESSION['User_ID'];

if (!isset($_GET['id'])) {
    die("Certificate ID is required.");
}

$cert_id = intval($_GET['id']);

$stmt = $conn->prepare("
   SELECT * FROM certificate_requests 
   WHERE id = ? AND user_id = ? AND status = 'To Release'
");
$stmt->bind_param("ii", $cert_id, $User_ID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("No matching certificate found.");
}

$certificate = $result->fetch_assoc();

$fullname = strtoupper($certificate['fullname']);
$address = $certificate['address'];
$request_date = date("jS", strtotime($certificate["request_date"])) . ' day of ' . date("F, Y", strtotime($certificate["request_date"]));
$purpose = $certificate['purpose'];

// Ensure 'purpose' is properly sanitized and escaped
$purpose = htmlspecialchars($purpose, ENT_QUOTES, "UTF-8");

$certificate_html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CERTIFICATE OF INDIGENCY</title>
    <style>
        @page { size: A4; margin: 0; }
        body {
            font-family: "Times New Roman", serif;
            background: #f9f9f9;
            padding: 0;
            margin: 0;
        }
        .certificate-container {
            width: 8.27in;
            height: 11.69in;
            background: #fff;
            padding: 1in;
            margin: auto;
            box-sizing: border-box;
            border: 2px solid #222;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            position: relative;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .logo-left, .logo-right {
            width: 70px;
        }
        .logo-left img, .logo-right img {
            width: 100%;
            height: auto;
        }
        .header-text {
            text-align: center;
            flex: 1;
        }
        .header-text h3 {
            margin: 4px 0;
        }
        .divider {
            border-bottom: 2px solid #000;
            margin: 15px 0 40px;
        }
        .certificate-title {
            text-align: center;
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 30px;
            text-transform: uppercase;
        }
        .content {
            font-size: 18px;
            line-height: 1.8;
            text-align: justify;
        }
        .content strong {
            font-weight: bold;
        }
        .signature {
            position: absolute;
            bottom: 60px;
            right: 80px;
            text-align: center;
            width: 220px;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 100%;
            margin: 0 auto 5px;
        }
        .signature p {
            margin: 0;
            line-height: 1.5;
        }
        .note {
            font-size: 13px;
            margin-top: 8px;
            text-align: center;
            color: #444;
        }
        @media print {
            body { background: none; }
            .certificate-container {
                margin: 0;
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="header">
            <div class="logo-left">
                <img src="../assets/img/mylogo.png" alt="Logo Left">
            </div>
            <div class="header-text">
                <h3>Republic of the Philippines</h3>
                <h3>CITY OF CALOOCAN</h3>
                <h3><strong>BARANGAY 176-F ZONE 15 DISTRICT 1</strong></h3>
                <p>Bagong Silang, Caloocan City, Metro Manila<br>Office of the Punong Barangay</p>
            </div>
            <div class="logo-right">
                <img src="../assets/img/Caloocan_logo.jpg" alt="Logo Right">
            </div>
        </div>
        <div class="divider"></div>

        <div class="certificate-title">CERTIFICATE OF INDIGENCY</div>

        <div class="content">
            <p>To Whom It May Concern,</p>
            <p>This is to certify that <strong>' . htmlspecialchars($fullname, ENT_QUOTES, "UTF-8") . '</strong>, of legal age, a bona fide resident of this barangay with particular address at <strong>' . htmlspecialchars($address, ENT_QUOTES, "UTF-8") . '</strong>, belongs to the indigent sector of this barangay.</p>
            <p>This certificate is being issued upon the request of the above-mentioned person for <strong>' . $purpose . '</strong> and for whatever legal purpose or intent it may serve.</p>
            
            <p>Issued this <strong>' . $request_date . '</strong> at Bagong Silang, Caloocan City.</p>
        </div>

        <div class="signature">
            <div class="signature-line"></div>
            <p><strong>Hon. VIC MARC R. SIBAYAN</strong></p>
            <p>Punong Barangay</p>
            <p class="note">Not Valid Without Official Dry Seal</p>
        </div>
    </div>
</body>
</html>';
?>

<?php
// Handle view or download
if (isset($_GET['view'])) {
    echo $certificate_html;
    exit();
}

if (isset($_GET['download'])) {
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=certificate_indigency_{$cert_id}.html");
    echo $certificate_html;
    exit();
}
?>
