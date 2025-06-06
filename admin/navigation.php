<?php include 'session.php'; ?>

<div class="bg-dark sticky-top text-light p-3 d-none d-md-flex flex-column" style="height: 100vh; width: 20%;">
    <div class="d-flex justify-content-center mb-3 flex-column align-items-center">
        <?php
        include '../config.php';

        // Check if session user_id is set
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            // Query to get profile image and full name
            $query = "SELECT * FROM admin1 WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $profileImage = $row['profile_pic'];
                $fullname = $row['name'];
                $role = $row['role'];
                $email = $row['email'];
                ?>
                <!-- Display profile picture and full name -->
                <div style="height: 150px; width: 150px;">
                    <img src="../assets/img/mylogo.png" 
                         alt="Profile" 
                         class="img-fluid rounded-circle mb-3" 
                         style="height: 100%; width: 100%; object-fit: cover;">
                </div>
                <h3 class="text-light text-center mt-2" style="font-size: 1.5rem;">
                    <?php echo htmlspecialchars($fullname); ?>
                </h3>
                <p><?php echo htmlspecialchars($email); ?></p>

                <p><?php echo htmlspecialchars($role); ?></p>
                <?php
            } else {
                echo "<p class='text-danger'>User not found.</p>";
            }
        } else {
            echo "<p class='text-danger'>Session not found.</p>";
        }
        ?>
    </div>

    <hr class="border-light">

    <ul class="list-unstyled flex-grow-1">
        <li class="mb-2">
            <a href="index.php" class="btn w-100 text-start text-light">
                <i class="bi bi-speedometer2 me-2"></i>Manage Certificates
            </a>
        </li>
        <li class="mb-2">
            <a href="blotter.php" class="btn w-100 text-start text-light">
                <i class="bi bi-file-earmark-text me-2"></i>Manage Blotter
            </a>
        </li>
        <li class="mb-2">
            <a href="resident.php" class="btn w-100 text-start text-light">
                <i class="bi bi-patch-check me-2"></i>Userrs Information
            </a>
        </li>
        <li class="mb-2">
            <a href="settings.php" class="btn w-100 text-start text-light">
                <i class="bi bi-gear me-2"></i>Settings
            </a>
        </li>
    </ul>

    <div class="mt-auto border-top pt-3">
        <a href="logout.php" class="btn text-start text-light w-100">
            <i class="bi bi-box-arrow-right me-2"></i>Logout
        </a>
    </div>
</div>
