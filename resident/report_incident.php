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
            <div class="container bg-dark text-light p-5 rounded-4 shadow-sm">
                <h2 class="mb-4">Report Incident</h2>

                <?php
                if (isset($_GET['status']) && in_array($_GET['status'], ['success', 'error'])) {
                    $status = $_GET['status'];
                    $alertClass = ($status == "success") ? "alert-success" : "alert-danger";
                    $message = ($status == "success") ? "Report Incident successfully" : "Report Incident unsuccessful";
                    $icon = ($status == "success") ? "bi-check-circle" : "bi-x-circle";
                ?>
                <div class="alert <?php echo $alertClass; ?> alert-dismissible fade show rounded-4" role="alert">
                    <i class="bi <?php echo $icon; ?> me-2"></i>
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>

                <form action="report_incident_action.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="complainant" class="form-label">Your Name:</label>
                            <input type="text" id="complainant" name="complainant" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="respondent" class="form-label">Respondent Name:</label>
                            <input type="text" id="respondent" name="respondent" class="form-control" required>
                        </div>

                        <div class="col-12">
                            <label for="incident_details" class="form-label">Incident Details:</label>
                            <textarea id="incident_details" name="incident_details" class="form-control" rows="5" required></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="incident_date" class="form-label">Incident Date:</label>
                            <input type="date" id="incident_date" name="incident_date" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="contact_num" class="form-label">Your Contact Number:</label>
                            <input type="text" id="contact_num" name="contact_num" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label for="location" class="form-label">Incident Location:</label>
                            <input type="text" id="location" name="location" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label for="image" class="form-label">Upload Image (Optional):</label>
                            <input type="file" id="image" name="image_path" class="form-control">
                        </div>

                        <div class="col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="reviewCheck" onchange="toggleSubmitButton()">
                                <label class="form-check-label text-warning" for="reviewCheck">
                                    I agree that I have reviewed the data in the form before submitting
                                </label>
                            </div>

                            <button type="submit" id="submitBtn" class="btn btn-outline-warning w-100 mt-2" disabled>
                                Submit Request
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Custom JS -->
    <script>
        function toggleSubmitButton() {
            const checkbox = document.getElementById('reviewCheck');
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = !checkbox.checked;
        }

        function validateForm() {
            // Add custom validation logic if needed
            return true;
        }
    </script>

</body>
</html>
