<?php
// Barangay Certificate Request Page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Online Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
                <h2 class="mb-4">Your Approved Certificates</h2>

                <div class="table-responsive bg-dark">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Certificate Type</th>
                                <th>Request Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include '../config.php';
                            $user_id = $_SESSION['user_id'];

                            // Include `id` in the SELECT fields
                            $sql = "SELECT id, certificate_type, request_date 
                                    FROM certificate_requests 
                                    WHERE user_id = ? AND status = 'To Release' 
                                    ORDER BY request_date DESC";

                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $user_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0):
                                while ($row = $result->fetch_assoc()):
                                    $id = $row['id'];
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['certificate_type']); ?></td>
                                    <td><?= date('F j, Y', strtotime($row['request_date'])); ?></td>
                                    <td>
                                        <a href="generate_certificate.php?id=<?= $id; ?>&view=1" 
                                           class="btn btn-sm btn-success me-1" 
                                           target="_blank">
                                           View
                                        </a>
                                        <a href="generate_certificate.php?id=<?= $id; ?>&download=true" 
                                        class="btn btn-sm btn-primary" 
                                        target="_blank">
                                        Download
                                        </a>
                                    </td>
                                </tr>
                            <?php
                                endwhile;
                            else:
                            ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No approved certificates found.</td>
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
