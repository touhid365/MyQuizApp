<?php
session_start();
// Assuming this is part of verify_otp.php
$email = $_SESSION['email']; // Retrieve the email from session or database after OTP verification
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verified Successfully</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.0-beta2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/success_msg.css">
    <link rel="icon" href="images/school_8220314.png" type="image/x-icon">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <!-- Success message card -->
                <div class="card shadow-lg">
                    <div class="card-body text-center p-5">
                        <h4 class="card-title text-success mb-4">Email Verified!</h4>
                        <p class="mb-4">Your email <strong><?php echo htmlspecialchars($email); ?></strong> has been verified successfully.</p>
                        <p class="mb-4">You can now log in to your account.</p>
                        <a href="login.php" class="btn btn-primary w-100">Login Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"></script>
</body>
</html>
