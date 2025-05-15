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

   <div class="container mb-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 bg-color2 p-5 rounded rounded-4 shadow"> <!-- Wider column for 2-cols -->
            <!-- Logo -->
            <div class="text-center mb-3">
                <h3 class="mt-2 text-light">Create an Account</h3>
            </div>

            <form action="register_action.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <!-- Username -->
                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label text-light">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>

                    <!-- Full Name -->
                    <div class="col-md-6 mb-3">
                        <label for="fullname" class="form-label text-light">Full Name</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" required>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label text-light">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <!-- Contact Number -->
                    <div class="col-md-6 mb-3">
                        <label for="contact" class="form-label text-light">Contact Number</label>
                        <input type="tel" class="form-control" id="contact" name="contact" required>
                    </div>

                    <!-- Password -->
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label text-light">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <span class="input-group-text"><i class="bi bi-eye-slash" id="togglePassword" style="cursor:pointer;"></i></span>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="col-md-6 mb-3">
                        <label for="confirm_password" class="form-label text-light">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            <span class="input-group-text"><i class="bi bi-eye-slash" id="toggleConfirmPassword" style="cursor:pointer;"></i></span>
                        </div>
                    </div>

                        <small class="form-text mb-3 text-light">
                            Password must be at least 8 characters long, contain one uppercase letter, one lowercase letter, one number, and one special character (e.g., !@#$%^&*). Example: <strong>Example@123</strong>
                        </small>

                    <!-- Address -->
                    <div class="col-md-12 mb-3">
                        <label for="address" class="form-label text-light">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="2" required></textarea>
                    </div>

                    <!-- Upload Profile Picture -->
                    <div class="col-md-12 mb-4">
                        <label for="profile_picture" class="form-label text-light">Upload Profile Picture</label>
                        <input class="form-control" type="file" id="profile_picture" name="profile_picture" accept="image/*">
                    </div>
                </div>

                <!-- Submit -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-color1">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>



    
    <?php include 'components/lowerfooter.php'; ?>
    <?php include 'components/footer.php'; ?>
    <script>
document.querySelector("form").addEventListener("submit", function (e) {
    // Remove previous validation states
    const fields = ["contact", "password", "confirm_password", "address"];
    fields.forEach(id => {
        document.getElementById(id).classList.remove("is-invalid");
    });

    let isValid = true;

    // Validate phone number
    const phoneInput = document.getElementById("contact");
    const phoneValue = phoneInput.value.trim();
    const phoneRegex = /^\d{11}$/;
    if (!phoneRegex.test(phoneValue)) {
        phoneInput.classList.add("is-invalid");
        if (!phoneInput.nextElementSibling || !phoneInput.nextElementSibling.classList.contains("invalid-feedback")) {
            phoneInput.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Contact number must be exactly 11 digits.</div>`);
        }
        isValid = false;
    }

    // Validate password
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("confirm_password");
    const passwordValue = passwordInput.value;
    const confirmPasswordValue = confirmPasswordInput.value;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;

    if (!passwordRegex.test(passwordValue)) {
        passwordInput.classList.add("is-invalid");
        if (!passwordInput.nextElementSibling || !passwordInput.nextElementSibling.classList.contains("invalid-feedback")) {
            passwordInput.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Password must meet the required complexity.</div>`);
        }
        isValid = false;
    }

    if (passwordValue !== confirmPasswordValue) {
        confirmPasswordInput.classList.add("is-invalid");
        if (!confirmPasswordInput.nextElementSibling || !confirmPasswordInput.nextElementSibling.classList.contains("invalid-feedback")) {
            confirmPasswordInput.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Passwords do not match.</div>`);
        }
        isValid = false;
    }

    // Validate address contains 'Barangay 176-F'
    const addressInput = document.getElementById("address");
    const addressValue = addressInput.value.toLowerCase();
    if (!addressValue.includes("barangay 176-f".toLowerCase())) {
        addressInput.classList.add("is-invalid");
        if (!addressInput.nextElementSibling || !addressInput.nextElementSibling.classList.contains("invalid-feedback")) {
            addressInput.insertAdjacentHTML("afterend", `<div class="invalid-feedback">Address must include "Barangay 176-F".</div>`);
        }
        isValid = false;
    }

    // Prevent submission if any validation fails
    if (!isValid) {
        e.preventDefault();
    }
});
</script>
<script>
// Toggle Password
document.getElementById("togglePassword").addEventListener("click", function () {
    const passwordInput = document.getElementById("password");
    const icon = this;
    const isPassword = passwordInput.type === "password";
    passwordInput.type = isPassword ? "text" : "password";
    icon.classList.toggle("bi-eye");
    icon.classList.toggle("bi-eye-slash");
});

// Toggle Confirm Password
document.getElementById("toggleConfirmPassword").addEventListener("click", function () {
    const confirmPasswordInput = document.getElementById("confirm_password");
    const icon = this;
    const isPassword = confirmPasswordInput.type === "password";
    confirmPasswordInput.type = isPassword ? "text" : "password";
    icon.classList.toggle("bi-eye");
    icon.classList.toggle("bi-eye-slash");
});
</script>


</body>
</html>
