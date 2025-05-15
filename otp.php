<?php 
include 'session.php'; // Include session
// ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Online Application - OTP Verification</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .otp-input {
            width: 3rem;
            height: 3rem;
            text-align: center;
            font-size: 1.5rem;
            margin: 0 0.3rem;
        }
    </style>
</head>
<body class="bg-color1 d-flex flex-column min-vh-100">

    <?php include 'components/header.php'; ?>
    <?php include 'components/header_out.php'; ?>

    <div class="container d-flex justify-content-center align-items-center flex-grow-1">
        <div class="card bg-color2 p-5 rounded rounded-4" style="max-width: 500px; width: 100%;">
            <h4 class="text-center mb-3 text-light">Two-Factor Authentication</h4>
            <p class="text-center text-light mb-4">Enter the 6-digit code sent to your email to login</p>

            <form action="verify_otp.php" method="POST" class="text-center">
                <div class="d-flex justify-content-center mb-4">
                    <input type="text" name="otp[]" maxlength="1" class="form-control otp-input" required>
                    <input type="text" name="otp[]" maxlength="1" class="form-control otp-input" required>
                    <input type="text" name="otp[]" maxlength="1" class="form-control otp-input" required>
                    <input type="text" name="otp[]" maxlength="1" class="form-control otp-input" required>
                    <input type="text" name="otp[]" maxlength="1" class="form-control otp-input" required>
                    <input type="text" name="otp[]" maxlength="1" class="form-control otp-input" required>
                </div>
                <?php
                $status = isset($_GET['status']) ? $_GET['status'] : '';
                ?>

                <?php if ($status === 'incorrect_otp'): ?>
                    <div class="alert alert-danger text-center" role="alert">
                        Incorrect OTP. Please try again.
                    </div>
                <?php endif; ?>

                <!-- Hidden field for email -->
                <?php
                $email = isset($_GET['email']) ? $_GET['email'] : '';
                ?>
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

                <button type="submit" class="btn btn-color1 w-100">Verify</button>

                <div class="mt-3">
                    <small class="text-light">
                        Didn't receive the code? 
                        <span id="resend-container">
                            <span id="countdown">Resend in <span id="timer">60</span>s</span>
                            <a href="sendmail.php?email=<?php echo urlencode($email); ?>" id="resend-link" style="display: none;">Resend</a>
                        </span>
                    </small>
<script>
    const timerElement = document.getElementById("timer");
    const resendLink = document.getElementById("resend-link");
    const countdown = document.getElementById("countdown");

    const RESEND_TIMEOUT = 60; // seconds
    const RESEND_KEY = "otp_resend_start_time";

    function startCountdown() {
        const now = Math.floor(Date.now() / 1000);
        localStorage.setItem(RESEND_KEY, now);
        updateCountdown(now);
    }

    function updateCountdown(startTime) {
        const interval = setInterval(() => {
            const currentTime = Math.floor(Date.now() / 1000);
            const elapsed = currentTime - startTime;
            const remaining = RESEND_TIMEOUT - elapsed;

            if (remaining > 0) {
                timerElement.textContent = remaining;
            } else {
                clearInterval(interval);
                countdown.style.display = "none";
                resendLink.style.display = "inline";
                localStorage.removeItem(RESEND_KEY);
            }
        }, 1000);
    }

    // Check if there's a previous countdown stored
    const storedTime = localStorage.getItem(RESEND_KEY);
    if (storedTime) {
        const elapsed = Math.floor(Date.now() / 1000) - parseInt(storedTime, 10);
        if (elapsed < RESEND_TIMEOUT) {
            updateCountdown(parseInt(storedTime, 10));
        } else {
            countdown.style.display = "none";
            resendLink.style.display = "inline";
        }
    } else {
        // Start new countdown on page load (optional)
        startCountdown();
    }
</script>

                </div>
            </form>
        </div>
    </div>

    <?php include 'components/lowerfooter.php'; ?>
    <?php include 'components/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Optional: Auto focus to next field -->
    <script>
        const inputs = document.querySelectorAll('.otp-input');
        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
        });
    </script>
</body>
</html>
