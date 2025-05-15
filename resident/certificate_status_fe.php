<?php
// Barangay Certificate Request Page
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
        .table th, .table td {
            color: white !important;
        }
        .table a {
            color: white !important;
            text-decoration: none;
        }
        .table a:hover {
            text-decoration: underline;
        }
        /* Status colors */
        .status-to-release {
            border: 2px solid #28a745;  /* Bootstrap green */
            background-color: rgba(40, 167, 69, 0.15); /* green fill, light */
            color: #28a745;
            font-weight: 600;
            border-radius: 9999px; /* pill shape */
            padding: 0.25rem 0.75rem;
            display: inline-block;
            min-width: 80px;
            text-align: center;
        }

        .status-rejected {
            border: 2px solid #dc3545;  /* Bootstrap red */
            background-color: rgba(220, 53, 69, 0.15); /* red fill */
            color: #dc3545;
            font-weight: 600;
            border-radius: 9999px;
            padding: 0.25rem 0.75rem;
            display: inline-block;
            min-width: 80px;
            text-align: center;
        }

        .status-pending {
            border: 2px solid #fd7e14; /* Bootstrap orange */
            background-color: rgba(253, 126, 20, 0.15); /* orange fill */
            color: #fd7e14;
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

        <!-- Main Content -->
        <main class="container-fluid p-4">
            <div class="container bg-dark text-light p-5 rounded-4 shadow-sm">
                <h2 class="mb-4">Your Certificate Request Status</h2>

                <div class="table-responsive bg-dark">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Certificate Type</th>
                                <th>Request Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include '../config.php';
                            
                            $user_id = $_SESSION['user_id'];

                            $sql = "SELECT id, certificate_type, request_date, status 
                                    FROM certificate_requests 
                                    WHERE user_id = ? 
                                    ORDER BY request_date DESC";

                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $user_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0):
                                while ($row = $result->fetch_assoc()):
                                    // Assign class based on status (lowercase to avoid case mismatch)
                                    $statusClass = '';
                                    switch (strtolower($row['status'])) {
                                        case 'to release':
                                            $statusClass = 'status-to-release';
                                            break;
                                        case 'rejected':
                                            $statusClass = 'status-rejected';
                                            break;
                                        case 'pending':
                                            $statusClass = 'status-pending';
                                            break;
                                        default:
                                            $statusClass = '';
                                    }
                            ?>
                                <tr>
                                    <td class="pt-4 pb-3"><?= htmlspecialchars($row['certificate_type']); ?></td>
                                    <td class="pt-4 pb-3"><?= date('F j, Y', strtotime($row['request_date'])); ?></td>
                                    <td class="pt-4 pb-3">
                                        <span class="<?= $statusClass; ?>">
                                            <?= htmlspecialchars($row['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php
                                endwhile;
                            else:
                            ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No certificate requests found.</td>
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
