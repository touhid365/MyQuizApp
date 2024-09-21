<?php
session_start();
$message = '';

// Include your database connection file
include './databae.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user from the database
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify if user exists and password is correct
    if ($user && password_verify($password, $user['password'])) {
        if ($user['is_verified']) {
            $_SESSION['user_id'] = $user['id']; // Set session variables
            $_SESSION['email'] = $user['email'];
            header("Location: ./dashboard/index.php "); // Redirect to the user dashboard
        }
        else{
            $message = "<div class='alert alert-info'>Please verify your email address before logging in.<a href='verify_otp.php?email=". $user['email']."' class='alert-link'>verify now</a>. "."</div>";
            // header("Location: verify_otp.php");
        }
       
    } else {
        
        $message ="<div class='alert alert-danger'>Invalid email or password</div>"; // Handle incorrect login
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students | Login</title>
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
                            <img src="images/pexels-erfan-moghadm-49565497-10933033 (2).jpg" class="img-fluid h-100" alt="Login Image" style="object-fit: cover;">
                        </div>

                        <!-- Right side form -->
                        <div class="col-md-6">
                            <div class="card-body p-5">
                                <h4 class="card-title text-center mb-4">Login</h4>
                                <?php if(!empty($message)) echo$message ?>
                                <form action="" method="POST">
                                    <div class="form-group mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Login</button>
                                </form>
                                <p class="text-center mt-3">
                                    Don't have an account? <a href="register.php">Sign up here</a>
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
