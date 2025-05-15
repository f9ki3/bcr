<?php
// Barangay Certificate Request Page
?>
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
        <?php include 'navigation.php'; ?>

        <!-- Main Content -->
        <main class="container-fluid p-4">
            <div class="container bg-dark p-5 rounded rounded-4 shadow-sm">
                <h2 class="mb-4 text-light">Request Certificate</h2>
                <?php
                            if (isset($_GET['status']) && ($_GET['status'] == "success" || $_GET['status'] == "error")) {
                                // Get the status value from the URL query parameter
                                $status = $_GET['status'];
                                
                                // Set the appropriate message, alert class, and icon based on the status
                                if ($status == "success") {
                                    $alertClass = "alert-success";
                                    $message = "Certification Requested successfully";
                                    $icon = "bi-check-circle";  // Success icon
                                } else if ($status == "error") {
                                    $alertClass = "alert-danger";
                                    $message = "Certification Requested unsuccessful";
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
                <form action="request_cert_action.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="fullname" class="form-label text-light">Full Name</label>
                            <input type="text" id="fullname" name="fullname" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="address" class="form-label text-light">Address</label>
                            <input type="text" id="address" name="address" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="contact" class="form-label text-light">Contact Number</label>
                            <input type="text" id="contact" name="contact" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label text-light">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="birthdate" class="form-label text-light">Date of Birth</label>
                            <input type="date" id="birthdate" name="birthdate" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="birthplace" class="form-label text-light">Place of Birth</label>
                            <input type="text" id="birthplace" name="birthplace" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label for="age" class="form-label text-light">Age</label>
                            <input type="number" id="age" name="age" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label for="gender" class="form-label text-light">Gender</label>
                            <select id="gender" name="gender" class="form-select" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="civil_status" class="form-label text-light">Civil Status</label>
                            <select id="civil_status" name="civil_status" class="form-select" required>
                                <option value="">Select Civil Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="religion" class="form-label text-light">Religion</label>
                            <input type="text" id="religion" name="religion" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="purpose" class="form-label text-light">Purpose of Request</label>
                            <select id="purpose" name="purpose" class="form-select" onchange="toggleOtherPurpose()" required>
                                <option value="">Select Purpose</option>
                                <option value="School Requirement">School Requirement</option>
                                <option value="Bank Requirement">Bank Requirement</option>
                                <option value="NHA Requirement">NHA Requirement</option>
                                <option value="SSS Requirement">SSS Requirement</option>
                                <option value="Senior Citizen Requirement">Senior Citizen Requirement</option>
                                <option value="Birth Certificate Requirement">Birth Certificate Requirement</option>
                                <option value="Other">Other (Please Specify)</option>
                            </select>
                        </div>

                        <div class="col-md-12" id="other-purpose-group" style="display: none;">
                            <label for="other_purpose" class="form-label text-light">Please specify other purpose</label>
                            <input type="text" id="other_purpose" name="other_purpose" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="certificateType" class="form-label text-light">Certificate Type</label>
                            <select id="certificateType" name="certificateType" class="form-select" required>
                                <option value="">Select Certificate Type</option>
                                <option value="Barangay Clearance">Barangay Clearance</option>
                                <option value="Certificate of Residency">Certificate of Residency</option>
                                <option value="Certificate of Indigency">Certificate of Indigency</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="proof_of_identity" class="form-label text-light">Upload Proof of Identity</label>
                            <input type="file" id="proof_of_identity" name="proof_of_identity" class="form-control" accept="image/jpeg, image/png, image/jpg, application/pdf" required>
                        </div>
                    </div>

                    <!-- ... your existing form fields ... -->

                    <div class="mt-4">
                        <!-- Checkbox to confirm user review -->
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="reviewCheck" onchange="toggleSubmitButton()">
                           <label class="form-check-label text-warning" for="reviewCheck">
                                I agree that I have reviewed the data in the form before submitting
                            </label>
                        </div>

                        <!-- Submit button disabled by default -->
                        <button type="submit" id="submitBtn" class="btn btn-outline-warning w-100 w-md-25 mt-3" disabled>Submit Request</button>
                    </div>

                    <script>
                        function toggleOtherPurpose() {
                            const purpose = document.getElementById('purpose').value;
                            const otherGroup = document.getElementById('other-purpose-group');
                            otherGroup.style.display = (purpose === 'Other') ? 'block' : 'none';
                        }

                        function toggleSubmitButton() {
                            const checkbox = document.getElementById('reviewCheck');
                            const submitBtn = document.getElementById('submitBtn');
                            submitBtn.disabled = !checkbox.checked;
                        }

                        function validateForm() {
                            // Add custom validation logic here if needed
                            return true;
                        }
                    </script>

                </form>
            </div>
        </main>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        function toggleOtherPurpose() {
            const purpose = document.getElementById('purpose').value;
            const otherGroup = document.getElementById('other-purpose-group');
            otherGroup.style.display = (purpose === 'Other') ? 'block' : 'none';
        }

        function validateForm() {
            // Add custom validation logic here if needed
            return true;
        }
    </script>
</body>
</html>
