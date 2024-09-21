<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Quiz App</title>
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@600&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="images/school_8220314.png" type="image/x-icon">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Nunito', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            overflow: hidden;
            position: relative;
        }

        .card-custom {
            max-width: 650px;
            height: 60vh;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            position: relative;
            background-color: #fff;
            padding: 20px;
            text-align: center;
            animation: fadeIn 1s ease-out;
        }

        .card-custom .img-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .card-custom .img-container img {
            width: 100px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: slideIn 1s ease-out;
        }

        .card-custom .welcome-message {
            font-size: 24px;
            font-weight: bold;
            color: #343a40;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }

        .card-custom .emoji {
            font-size: 48px;
            margin: 10px;
        }

        .card-custom .balloon {
            position: absolute;
            top: -30px;
            right: 20px;
            font-size: 60px;
            color: #ff6f61;
            animation: floatBalloon 4s infinite ease-in-out;
        }

        .card-custom .circle {
            position: absolute;
            bottom: -50px;
            left: 20px;
            width: 100px;
            height: 100px;
            background-color: #007bff;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            animation: floatCircle 6s infinite ease-in-out;
        }

        .card-custom .star {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 30px;
            color: #ffd700;
            animation: twinkle 2s infinite ease-in-out;
        }

        .card-custom .moon {
            position: absolute;
            top: 60px;
            right: 20px;
            font-size: 50px;
            color: #f0e68c;
            animation: floatMoon 5s infinite ease-in-out;
        }

        .card-custom .tree {
            position: absolute;
            bottom: -30px;
            right: 20px;
            width: 80px;
            font-size: 50px;
            height: 100px;
            /* background: url('https://via.placeholder.com/80x100?text=🌳') no-repeat center center; */
            /* background-size: contain; */
            animation: swayTree 3s infinite ease-in-out;
        }

        .card-custom .sun {
            position: absolute;
            top: 10px;
            left: -70px;
            font-size: 80px;
            color: #ffeb3b;
            animation: rotateSun 10s infinite linear;
        }

        .card-custom .btn-custom {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .card-custom .btn-custom:hover {
            background-color: #0056b3;
        }

        .confetti {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }

        .confetti div {
            position: absolute;
            width: 5px;
            height: 10px;
            background: #ff6f61;
            opacity: 0.8;
            animation: confettiFall 2s infinite;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes floatBalloon {
            0% { transform: translateY(0); }
            50% { transform: translateY(-30px); }
            100% { transform: translateY(0); }
        }

        @keyframes floatCircle {
            0% { transform: translateY(0); }
            50% { transform: translateY(-40px); }
            100% { transform: translateY(0); }
        }

        @keyframes twinkle {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        @keyframes floatMoon {
            0% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0); }
        }

        @keyframes swayTree {
            0% { transform: rotate(0deg); }
            50% { transform: rotate(5deg); }
            100% { transform: rotate(0deg); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        @keyframes rotateSun {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes confettiFall {
            0% { transform: translateY(0); }
            100% { transform: translateY(100vh); }
        }
    </style>
</head>
<body>
    <div class="confetti">
        <!-- Add confetti pieces -->
        <div style="left: 10%; animation-delay: 0s;"></div>
        <div style="left: 30%; animation-delay: 0.5s;"></div>
        <div style="left: 50%; animation-delay: 1s;"></div>
        <div style="left: 70%; animation-delay: 1.5s;"></div>
        <div style="left: 90%; animation-delay: 2s;"></div>
    </div>
    <div class="card card-custom">
        <div class="img-container">
            <img src="images/quiz.png" alt="Quiz Image">
        </div>
        <div class="welcome-message">
            <span class="emoji">🎉</span> Welcome to Quiz App! <span class="emoji">🚀</span>
        </div>
        <p>Get ready to test your knowledge with exciting quizzes and challenges. Start now by creating your account!</p>
        <a href="register.php" class="btn btn-custom">
            <i class="fas fa-user-plus"></i> Create Account
        </a>
        <div class="balloon">🎈</div>
        <div class="circle"></div>
        <div class="star">⭐</div>
        <div class="moon">🌙</div>
        <div class="tree">🌼</div>
        <div class="sun">☀️</div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
