<?php include 'session.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Online Application</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional: Add Google Fonts for better typography -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="bg-color1">

    <?php include 'components/header.php'; ?>
    <nav class="navbar navbar-expand-lg bg-color2 ">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand text-light d-flex align-items-center" href="index.php">
                <img src="assets/img/mylogo.png" alt="Barangay Logo" width="40" height="40" class="me-2">
                Barangay 176-F
            </a>

            <!-- Toggler for mobile -->
           <nav class="navbar navbar-expand-lg bg-dark">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>


            <!-- Navbar links -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="login.php">Login</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-outline-light" href="register.php">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="container">
            <h1 class="text-color1">Welcome to Barangay 176-F Online Application System</h1>
            <p>Request your barangay certificates such as Barangay Clearance, Certificate of Residency, and Indigency Certificates with ease through our online platform. File and monitor Blotter Reports conveniently from anywhere.</p>
            <a href="login.php" class="btn btn-lg btn-color1 mt-4">Get Started</a>
        </div>
    </section>

   <section class="py-5 text-center">
    <div class="container">
        <h2 class="mb-4 text-light">What You Can Do</h2>
        <div class="row g-4">
            <!-- Barangay Clearance -->
            <div class="col-md-4">
                <div class="card h-100 p-4 shadow-sm bg-color2 text-light">
                    <div class="card-body">
                        <i class="bi bi-file-earmark-text display-6"></i>
                        <h5 class="card-title mt-4">Barangay Clearance</h5>
                        <p class="card-text">Easily request your Barangay Clearance online without waiting in long lines.</p>
                    </div>
                </div>
            </div>
            <!-- Certificate of Residency -->
            <div class="col-md-4">
                <div class="card h-100 p-4 shadow-sm bg-color2 text-light">
                    <div class="card-body">
                        <i class="bi bi-house-door display-6"></i>
                        <h5 class="card-title mt-4">Certificate of Residency</h5>
                        <p class="card-text">Get official proof of residency issued by the Barangay quickly and efficiently.</p>
                    </div>
                </div>
            </div>
            <!-- Certificate of Indigency -->
            <div class="col-md-4">
                <div class="card h-100 p-4 shadow-sm bg-color2 text-light">
                    <div class="card-body">
                        <i class="bi bi-person-lines-fill display-6"></i>
                        <h5 class="card-title mt-4">Certificate of Indigency</h5>
                        <p class="card-text">Apply for indigency certificates as proof of financial hardship for support services.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




    <section class="py-5 bg-bg-color2 text-light">
    <div class="container">
        <h2 class="mb-4 text-center">How to Use the Online Application System</h2>
        <div class="row align-items-center">
            <!-- Left: Video -->
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="ratio ratio-16x9">
                    <video controls>
                        <source src="./assets/video/myvideo.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>

            <!-- Right: Instructions -->
            <div class="col-md-6">
                <h4 class="mb-3">Step-by-Step Guide</h4>
                <ul class="list-unstyled">
                    <li><i class="bi bi-check-circle-fill me-2 text-success"></i> Login or create your account</li>
                    <li><i class="bi bi-check-circle-fill me-2 text-success"></i> Choose the service you need (e.g., Clearance, Indigency)</li>
                    <li><i class="bi bi-check-circle-fill me-2 text-success"></i> Fill out the form and submit your request</li>
                    <li><i class="bi bi-check-circle-fill me-2 text-success"></i> Track the status of your application</li>
                    <li><i class="bi bi-check-circle-fill me-2 text-success"></i> Receive confirmation and claim your document</li>
                </ul>
                <p class="mt-3">Watch the video to learn more about how to navigate and use the system efficiently.</p>
            </div>
        </div>
    </div>
</section>


    
    <?php include 'components/lowerfooter.php'; ?>
    <?php include 'components/footer.php'; ?>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
