<?php
include '../config.php';
session_start();

$user_id = $_SESSION['user_id'];

// Handle status update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'], $_POST['new_status'])) {
    $request_id = $_POST['request_id'];
    $new_status = $_POST['new_status'];

    // Validate new status value
    $allowed_statuses = ['pending', 'to release', 'rejected'];
    if (!in_array(strtolower($new_status), $allowed_statuses)) {
        die('Invalid status selected.');
    }

    // Update status only if the report belongs to the logged-in user
    $update_sql = "UPDATE blotter_reports SET status = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sii", $new_status, $request_id, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Redirect to avoid form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "<script>alert('Failed to update status.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Barangay Online Application - Manage Blotter</title>
    <style>
        .table, .table-responsive, .table thead, .table tr, .table td, .table th {
            background-color: transparent !important;
        }
        .table th, .table td {
            color: white !important;
            vertical-align: middle;
        }
        .table a, button {
            color: white !important;
            text-decoration: none;
            background: none;
            border: none;
            cursor: pointer;
        }
        .table a:hover, button:hover {
            text-decoration: underline;
        }
        .btn-action {
            margin-right: 0.5rem;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.9rem;
            border: 1.5px solid white;
            color: white;
            background-color: transparent;
            transition: background-color 0.2s ease;
        }
        .btn-action:hover {
            background-color: rgba(255,255,255,0.2);
        }
        /* Status colors */
        .status-to-release {
            border: 2px solid #28a745;
            background-color: rgba(40, 167, 69, 0.15);
            color: #28a745;
            font-weight: 600;
            border-radius: 9999px;
            padding: 0.25rem 0.75rem;
            display: inline-block;
            min-width: 80px;
            text-align: center;
        }
        .status-rejected {
            border: 2px solid #dc3545;
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
            font-weight: 600;
            border-radius: 9999px;
            padding: 0.25rem 0.75rem;
            display: inline-block;
            min-width: 80px;
            text-align: center;
        }
        .status-pending {
            border: 2px solid #fd7e14;
            background-color: rgba(253, 126, 20, 0.15);
            color: #fd7e14;
            font-weight: 600;
            border-radius: 9999px;
            padding: 0.25rem 0.75rem;
            display: inline-block;
            min-width: 80px;
            text-align: center;
        }
        /* Style select and button inside form */
        form select {
            background-color: transparent;
            color: white;
            border: 1.5px solid white;
            border-radius: 4px;
            padding: 0.2rem 0.5rem;
            font-size: 0.9rem;
            cursor: pointer;
            margin-right: 0.5rem;
        }
        form select option {
            background-color: #222;
            color: white;
        }
        form button {
            font-size: 0.9rem;
            padding: 0.25rem 0.6rem;
            border-radius: 4px;
            border: 1.5px solid white;
            background-color: transparent;
            color: white;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        form button:hover {
            background-color: rgba(255,255,255,0.2);
        }
    </style>
</head>
<body class="bg-color1 d-flex flex-column min-vh-100">

    <?php include 'header.php'; ?>

    <div class="d-flex flex-grow-1">
        <?php include 'navigation.php'; ?>

        <!-- Main Content -->
        <main class="container-fluid p-4">
            <div class="container bg-dark text-light p-5 rounded-4 shadow-sm">
                <h2 class="mb-4">Manage Blotter Reports</h2>
                <input type="text" placeholder="Search by reporter, reported person, location..." class="form-control mb-4" id="searchInput" onkeyup="filterTable()" /> 
                
                <div class="table-responsive bg-dark">
                    <table class="table align-middle" style="font-size: 0.7rem;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Reporter</th>
                                <th>Contact</th>
                                <th>Reported Person</th>
                                <th>Incident Date</th>
                                <th>Location</th>
                                <th>Details</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Update Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT id, reporter_name, contact_num, reported_person, incident_date, location, incident_details, image_path, status 
                                    FROM blotter_reports 
                                    WHERE user_id = ? 
                                    ORDER BY created_at DESC";

                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $user_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0):
                                while ($row = $result->fetch_assoc()):
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
                                    <td><?= htmlspecialchars($row['id']); ?></td>
                                    <td><?= htmlspecialchars($row['reporter_name']); ?></td>
                                    <td><?= htmlspecialchars($row['contact_num']); ?></td>
                                    <td><?= htmlspecialchars($row['reported_person']); ?></td>
                                    <td><?= htmlspecialchars($row['incident_date']); ?></td>
                                    <td><?= htmlspecialchars($row['location']); ?></td>
                                    <td><?= htmlspecialchars($row['incident_details']); ?></td>
                                    <td>
                                        <?php if (!empty($row['image_path'])): ?>
                                            <a href="<?= htmlspecialchars($row['image_path']); ?>" target="_blank" class="btn-action">View Image</a>
                                        <?php else: ?>
                                            No Image
                                        <?php endif; ?>
                                    </td>
                                    <td><span class="<?= $statusClass; ?>"><?= htmlspecialchars($row['status']); ?></span></td>
                                    <td>
                                        <form method="POST" action="">
                                            <input type="hidden" name="request_id" value="<?= $row['id']; ?>">
                                            <select name="new_status" required onchange="this.form.submit()">
                                                <option value="" disabled>Update Status</option>
                                                <option value="pending" <?= strtolower($row['status']) === 'pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="to release" <?= strtolower($row['status']) === 'to release' ? 'selected' : '' ?>>To Release</option>
                                                <option value="rejected" <?= strtolower($row['status']) === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                            </select>

                                        </form>
                                    </td>
                                </tr>
                            <?php
                                endwhile;
                            else:
                            ?>
                                <tr>
                                    <td colspan="10" class="text-center text-muted">No blotter reports found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        function filterTable() {
            const input = document.getElementById('searchInput').value.toLowerCase().trim();
            const rows = document.querySelectorAll('table tbody tr');

            rows.forEach(row => {
                const rowText = row.innerText.toLowerCase();
                row.style.display = rowText.includes(input) ? '' : 'none';
            });
        }
    </script>
</body>
</html>
