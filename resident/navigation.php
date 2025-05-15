<?php  include 'session.php'?>

<div class="bg-dark sticky-top text-light p-3 d-none d-md-flex flex-column" style="height: 100vh; width: 20%;">
    <div class="d-flex justify-content-center mb-3 flex-column align-items-center">
        <?php
                // Start session if not already started
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }

                // Get the user_id from session
                $user_id = $_SESSION['user_id'];

                // Database connection
                include '../config.php';

                // Query to get profile image and full name
                $query = "SELECT profile_image, fullname FROM users WHERE user_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 1) {
                    $row = $result->fetch_assoc();
                    $profileImage = $row['profile_image'];
                    $fullname = $row['fullname'];
                    ?>
                    
                    <!-- Displaying the profile image and name -->
                    <div style="height: 150px; width: 150px;">
                        <img src="../assets/uploads/<?php echo htmlspecialchars($profileImage); ?>" 
                            alt="Profile" 
                            class="img-fluid rounded-circle mb-3" 
                            style="height: 100%; width: 100%; object-fit: cover;">
                    </div>
                    <h3 class="text-light text-center mt-2" style="font-size: 1.5rem;"><?php echo htmlspecialchars($fullname); ?></h3>

                    <?php
                } else {
                    echo "<p class='text-danger'>User not found.</p>";
                }
                ?>

    </div>

    <hr class="border-light">

    <ul class="list-unstyled flex-grow-1">
        <li class="mb-2">
            <a href="index.php" class="btn w-100 text-start text-light">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>
        </li>
        <li class="mb-2">
            <a href="request_certificate.php" class="btn w-100 text-start text-light">
                <i class="bi bi-file-earmark-text me-2"></i>Request Certificate
            </a>
        </li>
        <li class="mb-2">
            <a href="certificate_status_fe.php" class="btn w-100 text-start text-light">
                <i class="bi bi-patch-check me-2"></i>Certificate Status
            </a>
        </li>
        <li class="mb-2">
            <a href="download_certificate.php" class="btn w-100 text-start text-light">
                <i class="bi bi-download me-2"></i>Download Certificate
            </a>
        </li>
        <li class="mb-2">
            <a href="report_incident.php" class="btn w-100 text-start text-light">
                <i class="bi bi-exclamation-triangle me-2"></i>Report Incident
            </a>
        </li>
        <li class="mb-2">
            <a href="blotter_status.php" class="btn w-100 text-start text-light">
                <i class="bi bi-clipboard2-data me-2"></i>Blotter Status
            </a>
        </li>
        <li class="mb-2">
            <a href="settings.php" class="btn w-100 text-start text-light">
                <i class="bi bi-gear me-2"></i>Settings
            </a>
        </li>
    </ul>

    <!-- Logout at the bottom -->
    <div class="mt-auto border-top pt-3">
        <a href="logout.php" class="btn text-start text-light w-100">
            <i class="bi bi-box-arrow-right me-2"></i>Logout
        </a>
    </div>
</div>




