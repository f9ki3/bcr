<?php
// incident_reports.php
include '../config.php';
include 'session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Barangay Online Application</title>
</head>
<body class="bg-color1 d-flex flex-column min-vh-100">

    <?php include 'header.php'; ?>

    <div class="d-flex flex-grow-1 justify-content-center align-items-center">


       <div class="col-md-5 p-5 rounded-4 ">
            

            <form action="login_action.php" method="POST" enctype="multipart/form-data">
                <!-- Logo at the top -->
                <div class="text-center mb-4">
                    <img src="../assets/img/mylogo.png" alt="Logo" style="max-width: 100px;">
                </div>

                <div class="text-center mb-3">
                    <h3 class="mt-2 text-light">Welcome Administrator</h3>
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
                <!-- <div class="text-center">
                    <a href="forgot_password.php" class="text-light d-block mb-1">Forgot Password?</a>
                    <a href="register.php" class="text-light">Don't have an account?</a>
                </div> -->
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
        
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
