<?php
session_start();
include '../config.php';

if (!isset($_SESSION['User_ID'])) {
    header("Location: userlogin.php");
    exit();
}

$User_ID = $_SESSION['User_ID'];

// Corrected query to fetch the current user's certificate requests
$query = $conn->prepare("SELECT certificate_type, request_date, status FROM certificate_requests WHERE user_id = ? ORDER BY request_date DESC");
$query->bind_param("i", $User_ID);
$query->execute();
$result = $query->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate Status</title>
    <style>
        body {
            background: url('background.jpg') no-repeat center center/cover;
            font-family: 'Poppins', sans-serif;
            color: white;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 60px auto;
            background: rgba(0, 0, 0, 0.8);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.6);
        }

        h2 {
            text-align: center;
            color: #FFA500;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            color: white;
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        th {
            background-color: rgba(255, 165, 0, 0.2);
            color: #FFA500;
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .status-pending {
            color: orange;
        }

        .status-approved {
            color: lightgreen;
        }

        .status-rejected {
            color: red;
        }

        a.back {
            display: inline-block;
            margin-top: 30px;
            color: #FFA500;
            text-decoration: none;
            border: 1px solid #FFA500;
            padding: 10px 20px;
            border-radius: 8px;
            transition: 0.3s;
        }

        a.back:hover {
            background-color: #FFA500;
            color: black;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📜 Your Certificate Requests Status</h2>
        <table>
            <tr>
                <th>Certificate Type</th>
                <th>Date Requested</th>
                <th>Status</th>
            </tr>

            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['certificate_type']); ?></td>
                    <td><?php echo date("F j, Y", strtotime($row['request_date'])); ?></td>
                    <td class="status-<?php echo strtolower($row['status']); ?>">
                        <?php echo $row['status']; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <div style="text-align:center;">
            <a href="userdashboard.php" class="back">← Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
