<?php
session_start();
$message ='';
$conn = new mysqli("sql212.infinityfree.com", "if0_37332007", "OvpN2AKrm7h8DP", "if0_37332007_quiz_db");
$email = isset($_GET['email']) ? $_GET['email'] : $_SESSION['email'];


// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['resend'])) {
        $email = isset($_GET['email']) ? $_GET['email'] : $_SESSION['email'];
        
        // $email = $_SESSION['email'];

        // Generate a new OTP
        $new_otp = rand(100000, 999999);

        // Update OTP in the database
        $conn->query("UPDATE users SET otp='$new_otp' WHERE email='$email'");

        // Send the new OTP via email using PHPMailer
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Specify your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'worldnaturedotcom@gmail.com';  // SMTP username
            $mail->Password = 'twtr pkxa rtyu lfrm';     // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('worldnaturedotcom@gmail.com', 'Quiz App');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Resend OTP for Email Verification';
            $mail->Body = "Your new OTP is <b>$new_otp</b>. Please enter this OTP to verify your email.";

            $mail->send();
            echo '';
            $message ="<div class='alert alert-success'> Your new OTP has been sent successfully to- "." <strong>$email</strong> "." email id!</div>";

        } catch (Exception $e) {
           
            $message ="<div class='alert alert-info'>OTP could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
        }
    } else {
        // $email = $_SESSION['email'];

        // Combine all OTP digits into one string
        $input_otp = implode('', $_POST['otp']);

        // Fetch the stored OTP from the database
        $result = $conn->query("SELECT otp FROM users WHERE email='$email'");
        $row = $result->fetch_assoc();

        // Check if the entered OTP matches the stored OTP
        if ($row['otp'] == $input_otp) {
            $conn->query("UPDATE users SET is_verified=1 WHERE email='$email'");
            header('Location: success_msg.php');
            
        } else {
           
            $message ="<div class='alert alert-danger'> OTP is Invalid! Please try another one or resend OTP.</div>";
            
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification For login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.0-beta2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/otp_page.css">
    <link rel="icon" href="images/school_8220314.png" type="image/x-icon">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <!-- Card wrapper -->
                <div class="card shadow-lg">
                    <div class="card-body p-4">
                        <h4 class="card-title text-center mb-4">Verify OTP</h4>
                        <?php if(!empty($message)) echo$message ?>
                        <p class="text-center mb-4">Enter the 6-digit OTP sent to your email.</p>
                        <form id="otp-form" action="" method="POST">
                            <div class="otp-input-container d-flex justify-content-between mb-3">
                                <input type="text" class="otp-input" maxlength="1" name="otp[]" required>
                                <input type="text" class="otp-input" maxlength="1" name="otp[]" required>
                                <input type="text" class="otp-input" maxlength="1" name="otp[]" required>
                                <input type="text" class="otp-input" maxlength="1" name="otp[]" required>
                                <input type="text" class="otp-input" maxlength="1" name="otp[]" required>
                                <input type="text" class="otp-input" maxlength="1" name="otp[]" required>
                            </div>
                            
                            <!-- Flexbox row for buttons -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary w-48">Verify</button>
                            </div>
                        </form>

                        <!-- Resend OTP Button inside the same row -->
                        <form action="" method="POST">
                            <div class="d-flex justify-content-between">
                                <button type="submit" name="resend" style=" background: coral; " class="btn btn-secondary w-48">Resend OTP</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"></script>
</body>
</html>

