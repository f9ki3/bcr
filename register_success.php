<?php 
include 'session.php'; // Include session
// ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Online Application</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="bg-color1">

    <?php include 'components/header.php'; ?>
    <?php include 'components/header_out.php'; ?>

    <div class="container my-5" style="height: 100vh;">
        <div class="row align-items-center">
            <div class="col-md-12 text-center">

                <!-- Success Message -->
                <div class="container text-center mb-4">
                    <div class="alert alert-success" role="alert">
                        Registration successful! Redirecting to login in <span id="countdown">5</span> seconds...
                    </div>
                </div>

                <!-- Image -->
                <img src="assets/img/art2.svg" alt="Registration Banner" class="img-fluid rounded-4">
            </div>
        </div>
    </div>

    <?php include 'components/lowerfooter.php'; ?>
    <?php include 'components/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Countdown Script -->
    <script>
        let seconds = 5;
        const countdown = document.getElementById("countdown");
        const interval = setInterval(() => {
            seconds--;
            countdown.textContent = seconds;
            if (seconds === 0) {
                clearInterval(interval);
                window.location.href = "login.php";
            }
        }, 1000);
    </script>
</body>
</html>
