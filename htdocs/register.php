
<?php
session_start();
$message = '';
require 'vendor/autoload.php'; // Load PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database connection
$conn = new mysqli("sql212.infinityfree.com", "if0_37332007", "OvpN2AKrm7h8DP", "if0_37332007_quiz_db");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $otp = rand(100000, 999999);
    $random_string = substr(str_shuffle('012345678901234567890123456789'), 0, 10);

    // Prefix the string with 'QUIZ'
    $quiz_id = 'QUIZ' . $random_string;

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute(); // Execute the query
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = "<div class='alert alert-danger'>This email "." $email "." is already registered. Please use a different email.</div>";
        }
    else{
    // Insert user data
    $stmt = $conn->prepare("INSERT INTO users (quiz_id, name, email, password, otp) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $quiz_id, $name, $email, $password, $otp);

    if ($stmt->execute()) {
        // Send OTP using PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'worldnaturedotcom@gmail.com'; // SMTP username
            $mail->Password = 'twtr pkxa rtyu lfrm'; // SMTP password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('worldnaturedotcom@gmail.com', 'Quiz App');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Email Verification OTP';
            $mail->Body    =  "Dear,<br>$name<br>"
            . "Congratulations on successfully registering for the quiz!<br><br>"
            . "Your OTP for verification is <b>$otp</b>.<br>"
            . "Your Quiz ID is <b>$quiz_id</b>.<br><br>"
            . "Thank you for registering with us!<br><br>"
            . "Best regards,<br>"
            . "Quiz App Team";

            $mail->send();
            $_SESSION['email'] = $email;
            header('Location: verify_otp.php');
            exit();
        } catch (Exception $e) {
            $message="Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students | Registeration</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.0-beta2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css?v=1.1">
    <link rel="icon" href="images/school_8220314.png" type="image/x-icon">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card login-card shadow-lg">
                    <div class="row g-0" >
                        <!-- Left side image -->
                        <div class="col-md-6">
                            <img src="images/pexels-olly-3762800.jpg" class="img-fluid h-100" alt="Login Image" style="object-fit: cover;">
                        </div>

                        <!-- Right side form -->
                        <div class="col-md-6">
                            <div class="card-body p-5">
                                <?php if(!empty($message)) echo$message ?>
                                <h4 class="card-title text-center mb-4">Register</h4>
                                <form action="" method="POST">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Full Name:</label>
                                        <input type="text" name="name" id="name" class="form-control form-control-lg"  placeholder="Enter your name" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label">Email Address:</label>
                                        <input type="email" name="email" id="email" class="form-control form-control-lg"  placeholder="Enter your email" required>
                                    </div>
                                    <div class="form-group mb-3">
                                    <label for="password" class="form-label">Password:</label>
                                        <input type="password" name="password" id="password" class="form-control form-control-lg"  placeholder="Enter your password" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block mt-3 w-100">Register</button>
                                </form>
                                <p class="text-center mt-3">
                                    Already have an account? <a href="login.php">Sign in here</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"></script>
</body>
</html>
