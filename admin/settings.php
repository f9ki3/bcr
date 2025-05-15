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
</head>
<body class="bg-color1 d-flex flex-column min-vh-100">

    <?php include 'header.php'; ?>

    <div class="d-flex flex-grow-1">
        <?php include 'navigation.php'; ?>

        <!-- Main Content -->
        <main class="container-fluid p-4">
    <div class="container bg-dark text-light p-5 rounded-4 shadow-sm">
        <h2 class="mb-4">Settings</h2>
        <?php
            require_once '../config.php';

            // Kunin ang admin ID mula sa session (o default sa 1 para sa testing)
            $admin_id = $_SESSION['user_id'] ?? 1;

            // Kunin info ng admin
            $stmt = $conn->prepare("SELECT * FROM admin1 WHERE id = ?");
            $stmt->bind_param("i", $admin_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $admin = $result->fetch_assoc();

            // I-handle ang form submit
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = $_POST['username'];
                $email    = $_POST['email'];
                $name     = $_POST['name'];
                $role     = $_POST['role'];

                // Upload image if available
                if (!empty($_FILES['profile_pic']['name'])) {
                    $target_dir = "../uploads/";
                    $file_name = time() . "_" . basename($_FILES["profile_pic"]["name"]);
                    $target_file = $target_dir . $file_name;
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    if (in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                        if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
                            $profile_pic = "uploads/" . $file_name;
                        } else {
                            $profile_pic = $admin['profile_pic'];
                        }
                    } else {
                        $profile_pic = $admin['profile_pic'];
                    }
                } else {
                    $profile_pic = $admin['profile_pic'];
                }

                // Update data
                $stmt = $conn->prepare("UPDATE admin1 SET username=?, email=?, name=?, role=?, profile_pic=? WHERE id=?");
                $stmt->bind_param("sssssi", $username, $email, $name, $role, $profile_pic, $admin_id);
                $stmt->execute();

                // I-update rin ang session kung ginagamit sa ibang bahagi
                $_SESSION['admin_username'] = $username;

                // Refresh to see changes
                header("Location: settings.php?update=success");
                exit;
            }
        ?>

        <!-- <h2>Profile</h2> -->
        <!-- <img src="../<?= htmlspecialchars($admin['profile_pic'] ?? 'uploads/default.png') ?>" alt="Admin Profile" class="img-thumbnail mb-4" style="max-width: 150px;"> -->

        <form method="POST" enctype="multipart/form-data" class="text-light">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" 
                       name="username" 
                       value="<?= htmlspecialchars($admin['username']) ?>" 
                       id="username" 
                       class="form-control" 
                       required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" 
                       name="email" 
                       value="<?= htmlspecialchars($admin['email']) ?>" 
                       id="email" 
                       class="form-control" 
                       required>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" 
                       name="name" 
                       value="<?= htmlspecialchars($admin['name']) ?>" 
                       id="name" 
                       class="form-control" 
                       required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <input type="text" 
                       name="role" 
                       value="<?= htmlspecialchars($admin['role']) ?>" 
                       id="role" 
                       class="form-control" 
                       required>
            </div>

            <div class="mb-3">
                <label for="profile_pic" class="form-label">Upload New Profile Picture</label>
                <input type="file" 
                       name="profile_pic" 
                       id="profile_pic" 
                       class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>

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
