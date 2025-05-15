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
    <!-- Optional: Add Google Fonts for better typography -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="bg-color1">

    <?php include 'components/header.php'; ?>
    <?php include 'components/header_out.php'?>

   <div class="container my-5 " style="height: 100vh;">
    <div class="row align-items-center">
        <!-- Left Column: Registration Form -->
        <div class="col-md-5 p-5 rounded-4 ">
            

            <form action="login_action.php" method="POST" enctype="multipart/form-data">
                <!-- Logo at the top -->
                <div class="text-center mb-4">
                    <img src="assets/img/mylogo.png" alt="Logo" style="max-width: 100px;">
                </div>

                <div class="text-center mb-3">
                    <h3 class="mt-2 text-light">Welcome User</h3>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="username" class="form-label text-light">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="password" class="form-label text-light">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <span class="input-group-text">
                                <i class="bi bi-eye-slash" id="togglePassword" style="cursor:pointer;"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-color1">Login</button>
                </div>

                                
                <!-- Error alert -->
                <?php if (isset($_GET['message']) && $_GET['message'] == 'error'): ?>
                    <div class="alert alert-danger mt-3 justify-content-center d-flex" role="alert">
                        Invalid username or password. Please try again.
                    </div>
                <?php endif; ?>

                <!-- Forgot password and sign up links at the bottom -->
                <div class="text-center">
                    <a href="forgot_password.php" class="text-light d-block mb-1">Forgot Password?</a>
                    <a href="register.php" class="text-light">Don't have an account?</a>
                </div>
            </form>


            <script>
                // Get the password input and the toggle icon
                const passwordInput = document.getElementById('password');
                const togglePassword = document.getElementById('togglePassword');

                // Toggle the password visibility
                togglePassword.addEventListener('click', function() {
                    // Check the current type of the input field
                    const type = passwordInput.type === 'password' ? 'text' : 'password';
                    passwordInput.type = type;

                    // Toggle the icon (bi-eye or bi-eye-slash)
                    this.classList.toggle('bi-eye');
                    this.classList.toggle('bi-eye-slash');
                });
            </script>


        </div>

        <!-- Right Column: Image -->
        <div class="col-md-7 text-center">
            <img src="assets/img/art1.svg" alt="Registration Banner" class="img-fluid rounded-4 ">
        </div>
    </div>
</div>


</div>



    
    <?php include 'components/lowerfooter.php'; ?>
    <?php include 'components/footer.php'; ?>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
