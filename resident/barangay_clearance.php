<?php
include '../config.php'; // Ensure this is present to connect to your database

$id = $_GET['id'] ?? 0;

$query = $conn->query("SELECT fullname, request_date FROM certificate_requests WHERE id = '$id'");
$certificate = $query->fetch_assoc();

$fullname = $certificate['fullname'] ?? 'Juan Dela Cruz';
$request_date = date('jS', strtotime($certificate['request_date'])) . ' day of ' . date('F, Y', strtotime($certificate['request_date']));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BARANGAY CLEARANCE</title>
    <style>
        @page { size: A4; margin: 0; }
        body {
            font-family: "Times New Roman", serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .certificate-container {
            width: 8.27in;
            height: 11.69in;
            background: #fff;
            padding: 1in;
            margin: auto;
            box-sizing: border-box;
            border: 2px solid #000;
            position: relative;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo-left, .logo-right {
            width: 80px;
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
            margin: 3px 0;
        }
        .divider {
            border-bottom: 2px solid #000;
            margin: 15px 0 30px;
        }
        .certificate-title {
            text-align: center;
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
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
            bottom: 80px;
            right: 80px;
            text-align: center;
            width: 240px;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 100%;
            margin: 10px 0 5px;
        }
        .signature p {
            margin: 0;
            line-height: 1.5;
        }
        .note {
            font-size: 13px;
            margin-top: 8px;
            text-align: center;
            color: #555;
        }
        @media print {
            body { background: none; }
            .certificate-container {
                margin: 0;
                border: none;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="header">
            <div class="logo-left">
                <img src="../assets/img/mylogo.png" alt="Barangay Logo">
            </div>
            <div class="header-text">
                <h3>Republic of the Philippines</h3>
                <h3>CITY OF CALOOCAN</h3>
                <h3><strong>BARANGAY 176-F ZONE 15 DISTRICT 1</strong></h3>
                <p>Bagong Silang, Caloocan City, Metro Manila</p>
                <p><em>Office of the Punong Barangay</em></p>
            </div>
            <div class="logo-right">
                <img src="../assets/img/Caloocan_logo.jpg" alt="Caloocan Logo">
            </div>
        </div>

        <div class="divider"></div>

        <div class="certificate-title">Barangay Clearance</div>

        <div class="content">
            <p>To Whom It May Concern,</p>

            <p>This is to certify that <strong><?= htmlspecialchars($fullname) ?></strong> has personally appeared before the undersigned and requested for a Barangay Clearance on the <strong><?= $request_date ?></strong>.</p>

            <p>Based on the records available, he/she has no derogatory record filed in this Barangay as of this date.</p>

            <p>This certificate is issued upon the request of the above-named person for whatever legal purpose it may serve.</p>

            <p>Issued this <strong><?= $request_date ?></strong> at Barangay 176, Bagong Silang, Caloocan City.</p>
        </div>

        <div class="signature">
            <div class="signature-line"></div>
            <p><strong>Hon. VIC MARC R. SIBAYAN</strong></p>
            <p>Punong Barangay</p>
            <p class="note">Not Valid Without Official Dry Seal</p>
        </div>
    </div>
</body>
</html>
