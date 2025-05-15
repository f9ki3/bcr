<?php 
include 'session.php'; // Include session
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Forgot Password - Enter Email</title>
</head>
<body class="bg-color1 d-flex flex-column min-vh-100">

  <?php include 'components/header.php'; ?>
  <?php include 'components/header_out.php'; ?>

  <div class="container d-flex justify-content-center align-items-center flex-grow-1">
    <div class="card bg-color2 rounded rounded-4 p-5" style="max-width: 500px; width: 100%;">
      <h4 class="text-center mb-3 text-light">Forgot Password</h4>
      <p class="text-center mb-4 text-light">Enter your email to receive a password reset code</p>

      <form action="forgot_sendmail.php" method="GET">
        <div class="mb-3">
          <label for="email" class="form-label text-light">Email address</label>
          <input 
            type="email" 
            class="form-control" 
            id="email" 
            name="email" 
            required 
            placeholder="example@gmail.com"
          >
        </div>
        <button type="submit" class="btn btn-color1 w-100">Send Reset Code</button>
      </form>
    </div>
  </div>

  <?php include 'components/lowerfooter.php'; ?>
  <?php include 'components/footer.php'; ?>
</body>
</html>
