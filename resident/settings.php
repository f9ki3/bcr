<?php 
// ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Online Application</title>
</head>
<body class="bg-color1 d-flex flex-column min-vh-100">

    <?php include 'header.php'; ?>
    <?php include 'nav_top.php'; ?>
    
    <div class="d-flex flex-grow-1">
        <!-- Sidebar -->
        <?php include 'navigation.php'; ?>

        <!-- Main Content -->
        <div class="container-fluid p-4">
            <div class="container">
                <h1 class="mb-4 text-light">Settings</h1>

                <div class="row">
                        <div class="col-12 col-md-8">

                       <?php

                        // Get the user_id from session
                        $user_id = $_SESSION['user_id'];

                        // Database connection
                        include '../config.php'; // your database connection file

                        // Query to fetch user data based on the user_id
                        $sql = "SELECT User_ID, fullname, username, email, contact_num, address FROM users WHERE User_ID = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $user_id); // "i" for integer, assuming user_id is an integer

                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($fetched_user_id, $fetched_fullname, $fetched_username, $fetched_email, $fetched_contact_num, $fetched_address);

                        if ($stmt->fetch()) {
                            // Data found, populate form with existing user data
                            $fullname = $fetched_fullname;
                            $username = $fetched_username;
                            $email = $fetched_email;
                            $contact_num = $fetched_contact_num;
                            $address = $fetched_address;
                        } else {
                            // Handle case when no data is found, e.g., user not found
                            echo "User not found.";
                        }

                        $stmt->close();
                        $conn->close();
                        ?>


                        <?php
                            if (isset($_GET['status']) && ($_GET['status'] == "success" || $_GET['status'] == "error")) {
                                // Get the status value from the URL query parameter
                                $status = $_GET['status'];
                                
                                // Set the appropriate message, alert class, and icon based on the status
                                if ($status == "success") {
                                    $alertClass = "alert-success";
                                    $message = "Information updated successfully";
                                    $icon = "bi-check-circle";  // Success icon
                                } else if ($status == "error") {
                                    $alertClass = "alert-danger";
                                    $message = "Information update unsuccessful";
                                    $icon = "bi-x-circle";  // Error icon
                                }
                            ?>
                                <!-- HTML and Bootstrap Alert with Icons -->
                                <div class="mt-3">
                                    <div class="alert <?php echo $alertClass; ?> alert-dismissible fade show rounded rounded-4" role="alert">
                                        <i class="bi <?php echo $icon; ?> me-2"></i>
                                        <?php echo $message; ?>
                                        <!-- Dismiss Button -->
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                            <?php
                            if (isset($_GET['status']) && ($_GET['status'] == "upload_success" || $_GET['status'] == "dberror")) {
                                // Get the status value from the URL query parameter
                                $status = $_GET['status'];
                                
                                // Set the appropriate message, alert class, and icon based on the status
                                if ($status == "upload_success") {
                                    $alertClass = "alert-success";
                                    $message = "Uploaded successfully";
                                    $icon = "bi-check-circle";  // Success icon
                                } else if ($status == "dberror") {
                                    $alertClass = "alert-danger";
                                    $message = "Upload unsuccessful";
                                    $icon = "bi-x-circle";  // Error icon
                                }
                            ?>
                                <!-- HTML and Bootstrap Alert with Icons -->
                                <div class="mt-3">
                                    <div class="alert <?php echo $alertClass; ?> alert-dismissible fade show rounded rounded-4" role="alert">
                                        <i class="bi <?php echo $icon; ?> me-2"></i>
                                        <?php echo $message; ?>
                                        <!-- Dismiss Button -->
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                         <!-- Profile Section -->
                        <form action="update_profilepic.php" method="post" class="bg-dark rounded-4 p-4 mb-4" enctype="multipart/form-data" onsubmit="return validateForm()">
                            <h4 class="text-light">Profile Picture</h4>

                            <div class="mb-3">
                                <label for="profile_pic" class="form-label text-light">
                                    Change Photo <span class="text-warning">(Only JPG, JPEG, PNG. Min size: 3MB)</span>
                                </label>
                                <input type="file" id="profile_pic" name="profile_pic" class="form-control" accept=".jpg,.jpeg,.png" required>
                                <div class="invalid-feedback" id="file-error"></div>
                            </div>

                            <button type="submit" class="btn btn-outline-warning w-25 mt-3">Save</button>
                        </form>

                        <!-- JavaScript validation -->
                        <script>
                            function validateForm() {
                                const fileInput = document.getElementById('profile_pic');
                                const fileError = document.getElementById('file-error');
                                const file = fileInput.files[0];

                                fileInput.classList.remove("is-invalid");
                                fileError.textContent = "";

                                if (!file) {
                                    fileInput.classList.add("is-invalid");
                                    fileError.textContent = "Please select a file.";
                                    return false;
                                }

                                const allowedTypes = ['image/jpeg', 'image/png'];

                                if (!allowedTypes.includes(file.type)) {
                                    fileInput.classList.add("is-invalid");
                                    fileError.textContent = "Only JPG, JPEG, and PNG files are allowed.";
                                    return false;
                                }


                                return true;
                            }
                        </script>



                        <!-- Profile Section -->
                        <form action="update_profile.php" method="post" class="bg-dark rounded-4 p-4 mb-4" onsubmit="return validateForm()">
                                <h4 class="text-light">Profile Information</h4>
                                <div class="mb-3">
                                    <label for="fullname" class="form-label text-light">Fullname</label>
                                    <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Fullname" value="<?php echo htmlspecialchars($fullname); ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label text-light">Username</label>
                                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label text-light">Address</label>
                                    <input type="text" id="address" name="address" class="form-control" placeholder="Address" value="<?php echo htmlspecialchars($address); ?>">
                                </div>
                                <button type="submit" class="btn btn-outline-warning w-25 mt-3">Save</button>
                            </form>

                            <?php
                            if (isset($_GET['status']) && ($_GET['status'] == "success1" || $_GET['status'] == "error1")) {
                                // Get the status value from the URL query parameter
                                $status = $_GET['status'];
                                
                                // Set the appropriate message, alert class, and icon based on the status
                                if ($status == "success1") {
                                    $alertClass = "alert-success";
                                    $message = "Information updated successfully";
                                    $icon = "bi-check-circle";  // Success icon
                                } else if ($status == "error1") {
                                    $alertClass = "alert-danger";
                                    $message = "Information update unsuccessful";
                                    $icon = "bi-x-circle";  // Error icon
                                }
                            ?>
                                <!-- HTML and Bootstrap Alert with Icons -->
                                <div class="mt-3">
                                    <div class="alert <?php echo $alertClass; ?> alert-dismissible fade show rounded rounded-4" role="alert">
                                        <i class="bi <?php echo $icon; ?> me-2"></i>
                                        <?php echo $message; ?>
                                        <!-- Dismiss Button -->
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        <!-- Contact Section -->
                        <form action="update_contact.php" method="post" class="bg-dark rounded-4 p-4 mb-4">
                            <h4 class="text-light">Contact Information</h4>
                            <div class="mb-3">
                                <label for="email" class="form-label text-light">Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="contact" class="form-label text-light">Contact No.</label>
                                <input type="text" id="contact" name="contact" class="form-control" placeholder="Contact No." value="<?php echo htmlspecialchars($contact_num); ?>">
                            </div>
                            <button type="submit" class="btn btn-outline-warning w-25 mt-3">Save</button>
                        </form>

                        
                        <?php
                            if (isset($_GET['status']) && ($_GET['status'] == "success2" || $_GET['status'] == "error2")) {
                                // Get the status value from the URL query parameter
                                $status = $_GET['status'];
                                
                                // Set the appropriate message, alert class, and icon based on the status
                                if ($status == "success2") {
                                    $alertClass = "alert-success";
                                    $message = "Information updated successfully";
                                    $icon = "bi-check-circle";  // Success icon
                                } else if ($status == "error2") {
                                    $alertClass = "alert-danger";
                                    $message = "Password updated unsuccessful";
                                    $icon = "bi-x-circle";  // Error icon
                                }
                            ?>
                                <!-- HTML and Bootstrap Alert with Icons -->
                                <div class="mt-3">
                                    <div class="alert <?php echo $alertClass; ?> alert-dismissible fade show rounded rounded-4" role="alert">
                                        <i class="bi <?php echo $icon; ?> me-2"></i>
                                        <?php echo $message; ?>
                                        <!-- Dismiss Button -->
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        <!-- Change Password Section -->
                        <form id="changePasswordForm" action="change_password.php" method="post" class="bg-dark rounded-4 p-4 mb-4">
                            <h4 class="text-light">Change Password</h4>

                            <div class="mb-3">
                                <label for="current_password" class="form-label text-light">Current Password</label>
                                <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Current Password">
                            </div>

                            <div class="mb-3">
                                <label for="new_password" class="form-label text-light">New Password</label>
                                <input type="password" id="new_password" name="new_password" class="form-control" placeholder="New Password">
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label text-light">Confirm Password</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                                <div class="invalid-feedback">
                                    Passwords do not match.
                                </div>
                            </div>

                            <!-- Show Password Checkbox -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="togglePassword">
                                <label class="form-check-label text-light" for="togglePassword">Show Passwords</label>
                            </div>

                            <button type="submit" class="btn btn-outline-warning w-25 mt-3">Save</button>
                        </form>

                        <!-- JavaScript for Show/Hide Password and Validation -->
                        <script>
                            // Toggle show/hide passwords
                            document.getElementById('togglePassword').addEventListener('change', function () {
                                const passwordFields = [
                                    document.getElementById('current_password'),
                                    document.getElementById('new_password'),
                                    document.getElementById('confirm_password')
                                ];

                                passwordFields.forEach(field => {
                                    field.type = this.checked ? 'text' : 'password';
                                });
                            });

                            // Validate new and confirm password match
                            document.getElementById('changePasswordForm').addEventListener('submit', function (e) {
                                const newPassword = document.getElementById('new_password');
                                const confirmPassword = document.getElementById('confirm_password');

                                if (newPassword.value !== confirmPassword.value) {
                                    confirmPassword.classList.add('is-invalid');
                                    e.preventDefault(); // Prevent form from submitting
                                } else {
                                    confirmPassword.classList.remove('is-invalid');
                                }
                            });
                        </script>


                    </div>

                </div>

            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
