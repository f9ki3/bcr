<?php
// incident_reports.php
include '../config.php';
session_start();
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Barangay Online Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .table, .table-responsive, .table thead, .table tr, .table td, .table th {
            background-color: transparent !important;
        }
        .table th, .table td, .table a {
            color: white !important;
        }
        .table a {
            text-decoration: none;
        }
        .table a:hover {
            text-decoration: underline;
        }
        .status-to-release {
            border: 2px solid #28a745;
            background-color: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }
        .status-rejected {
            border: 2px solid #dc3545;
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }
        .status-pending {
            border: 2px solid #fd7e14;
            background-color: rgba(253, 126, 20, 0.15);
            color: #fd7e14;
        }
        .status-to-release,
        .status-rejected,
        .status-pending {
            font-weight: 600;
            border-radius: 9999px;
            padding: 0.25rem 0.75rem;
            display: inline-block;
            min-width: 80px;
            text-align: center;
        }
    </style>
</head>
<body class="bg-color1 d-flex flex-column min-vh-100">

    <?php include 'header.php'; ?>
    <?php include 'nav_top.php'; ?>

    <div class="d-flex flex-grow-1">
        <?php include 'navigation.php'; ?>

        <main class="container-fluid p-4">
            <div class="container bg-dark text-light p-5 rounded-4 shadow-sm">
                <h2 class="mb-4">Your Incident Reports</h2>

                <div class="table-responsive bg-dark">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Respondent</th>
                                <th>Incident Details</th>
                                <th>Incident Date</th>
                                <th>Date Filed</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT reported_person, incident_details, incident_date, created_at, status 
                                    FROM blotter_reports 
                                    WHERE user_id = ? 
                                    ORDER BY created_at DESC";

                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $user_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0):
                                while ($row = $result->fetch_assoc()):
                                    $statusClass = match (strtolower($row['status'])) {
                                        'to release' => 'status-to-release',
                                        'rejected' => 'status-rejected',
                                        'pending' => 'status-pending',
                                        default => ''
                                    };
                            ?>
                                <tr>
                                    <td class="pt-4 pb-3"><?= htmlspecialchars($row['reported_person']) ?></td>
                                    <td class="pt-4 pb-3"><?= htmlspecialchars($row['incident_details']) ?></td>
                                    <td class="pt-4 pb-3"><?= date('F j, Y', strtotime($row['incident_date'])) ?></td>
                                    <td class="pt-4 pb-3"><?= date('F j, Y', strtotime($row['created_at'])) ?></td>
                                    <td class="pt-4 pb-3">
                                        <span class="<?= $statusClass ?>"><?= htmlspecialchars($row['status']) ?></span>
                                    </td>
                                </tr>
                            <?php
                                endwhile;
                            else:
                            ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No incident reports found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
