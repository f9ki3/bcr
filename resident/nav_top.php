<div class="d-flex sticky-top align-items-center justify-content-between p-2 bg-dark d-block d-md-none">
  <img src="../assets/img/mylogo.png" alt="Logo" style="height: 40px; width: auto;">
  <p class="text-white mb-0 fw-bold flex-grow-1 text-center">Barangay 176-F</p>
  <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
    <i class="bi bi-list" style="font-size: 1.5rem;"></i>
  </button>
</div>

<div class="offcanvas offcanvas-start bg-dark" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title text-light" id="offcanvasWithBothOptionsLabel">Menu</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <?php  include 'session.php'?>
        <div class="bg-dark text-light p-3 flex-column" style="height: 100vh;">
            <div class="d-flex justify-content-center mb-3 flex-column align-items-center">
                <?php
                    include '../config.php';
                    include 'session.php';  // this already calls session_start()

                    function displayUserProfile($user_id, $conn) {
                        $query = "SELECT profile_image, fullname FROM users WHERE user_id = ?";
                        $stmt = $conn->prepare($query);
                        if (!$stmt) {
                            echo "<p class='text-danger'>Database error: ".$conn->error."</p>";
                            return;
                        }
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows === 1) {
                            $row = $result->fetch_assoc();
                            $profileImage = $row['profile_image'];
                            $fullname = $row['fullname'];
                            ?>
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
                        $stmt->close();
                    }

                    if (isset($_SESSION['user_id'])) {
                        displayUserProfile($_SESSION['user_id'], $conn);
                    } else {
                        echo "<p class='text-warning'>No user logged in.</p>";
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
                    <a href="" class="btn w-100 text-start text-light">
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





  </div>
</div>