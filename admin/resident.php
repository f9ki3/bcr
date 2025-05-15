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
                <h2 class="mb-4">List of Registered Users</h2>
                <input type="text" placeholder="Search by reporter, reported person, location..." class="form-control mb-4" id="searchInput" onkeyup="filterTable()" /> 
                
                <div class="table-responsive bg-dark">
                     <?php
                        $sql = "SELECT user_id, fullname, username, email, address, contact_num, profile_image, created_at, updated_at
                                FROM users
                                ORDER BY created_at DESC";

                        $result = $conn->query($sql);
                        ?>

                        <table class="table align-middle" style="font-size: 0.7rem;">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Full Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Contact No.</th>
                                    <th>Profile Image</th>
                                    <th>Date Registered</th>
                                    <th>Last Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result && $result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['user_id']); ?></td>
                                            <td><?= htmlspecialchars($row['fullname']); ?></td>
                                            <td><?= htmlspecialchars($row['username']); ?></td>
                                            <td><?= htmlspecialchars($row['email']); ?></td>
                                            <td><?= htmlspecialchars($row['address']); ?></td>
                                            <td><?= htmlspecialchars($row['contact_num']); ?></td>
                                            <td>
                                                <?php if (!empty($row['profile_image'])): ?>
                                                    <img src="../assets/uploads/<?= htmlspecialchars($row['profile_image']); ?>" alt="Profile Image" style="width:50px; height:50px; object-fit:cover; border-radius:50%;">
                                                <?php else: ?>
                                                    No Image
                                                <?php endif; ?>
                                            </td>
                                            <td><?= date('M d, Y', strtotime($row['created_at'])); ?></td>
                                            <td><?= $row['updated_at'] ? date('M d, Y', strtotime($row['updated_at'])) : 'N/A'; ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">No registered users found.</td>
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
