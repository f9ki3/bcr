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
                <div class="bg-dark rounded-4 p-4 mb-4">
                        <h2 class="text-light">Welcome, resident of Barangay 147-f!</h2>
                        <p class="text-light mb-4">Manage your barangay certificate requests easily.</p>

                        <div class="row text-light">
                            <div class="col-md-4 mb-3">
                                <div class="bg-secondary rounded-3 p-3">
                                    <h5>🕓 In Progress</h5>
                                    <p class="mb-0">0 Request(s)</p>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="bg-success text-white rounded-3 p-3">
                                    <h5>📤 Ready for Pickup/Download</h5>
                                    <p class="mb-0">3 Certificate(s)</p>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="bg-danger text-white rounded-3 p-3">
                                    <h5>❌ Rejected</h5>
                                    <p class="mb-0">1 Request(s)</p>
                                </div>
                            </div>
                        </div>
                </div>

                <form action="update_contact.php" method="POST" class="bg-dark rounded-4 p-4 mb-4">
                    <h4 class="text-light mb-3">🔔 Notification</h4>

                    <!-- Add your notification form fields here if needed -->
                    <p class="text-light mb-0">You will receive updates about your requests via the contact details you provided.</p>
                </form>


            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>
