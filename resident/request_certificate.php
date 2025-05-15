<?php
// Barangay Certificate Request Page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Online Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

                    <div class="mt-4">
                       <button type="submit" class="btn btn-outline-warning w-100 w-md-25 mt-3">Submit Request</button>
                    </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
