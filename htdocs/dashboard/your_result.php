<?php
$host = 'sql212.infinityfree.com';
$db = 'if0_37332007_quiz_db';
$user = 'if0_37332007'; // Change as per your database username
$pass = 'OvpN2AKrm7h8DP'; // Change as per your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

session_start();
$user_id = $_SESSION['user_id'];
$exam_id = $_GET['exam_id'];

// Check if the user has submitted answers for the exam
$sql = "SELECT COUNT(*) FROM user_answers WHERE user_id = :user_id AND exam_id = :exam_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindParam(':exam_id', $exam_id, PDO::PARAM_INT);
$stmt->execute();
$submission_count = $stmt->fetchColumn();

if ($submission_count > 0) {
    // Fetch total questions
    $sql = "SELECT COUNT(*) AS total_questions FROM questions WHERE exam_id = :exam_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':exam_id', $exam_id, PDO::PARAM_INT);
    $stmt->execute();
    $total_questions = $stmt->fetchColumn();

    // Fetch correct answers
    $sql = "SELECT COUNT(*) AS correct_answers
            FROM user_answers ua
            JOIN questions q ON ua.question_id = q.id
            WHERE ua.user_id = :user_id AND ua.exam_id = :exam_id AND ua.selected_option = q.correct_option";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':exam_id', $exam_id, PDO::PARAM_INT);
    $stmt->execute();
    $correct_answers = $stmt->fetchColumn();
    
    $score = $correct_answers;
    $percentage = ($total_questions > 0) ? ($correct_answers / $total_questions) * 100 : 0;
} else {
    $total_questions = 0;
    $correct_answers = 0;
    $score = 0;
    $percentage = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results Card</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../images/school_8220314.png" type="image/x-icon">

    <style>
        .card-custom {
            max-width: 450px;
            margin: auto;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            background-color: #ffff;
            box-shadow: 2px 9px 6px 15px rgba(0, 0, 0, 0.1);
        }
        @media (max-width:789px) {
            .card-custom {
                margin: 100px 10px;
                height: 70vh;
            }
        }
        

        .score-circle {
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
        }

        .score-circle .circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: conic-gradient(#4CAF50 85%, #ddd 0);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .score-circle .circle span {
            font-size: 24px;
            color: #333;
            font-weight: bold;
        }

        .btn-custom {
            margin: 10px;
        }

        .stats p {
            margin: 12px 0;
            font-size: 18px;
        }

        .stats strong {
            font-weight: bold;
            color: #4CAF50;
        }
        .text-success
        {
            font-weight: bold;
            margin: 9px;
            font-size: 1.8rem;
        }
    </style>
</head>
<body>
    <div class="card card-custom">
        <?php 
        if ($total_questions > 0) { ?>
            <h3 class="text-success">🎉 Congratulations 🎉</h3>
            <p>You successfully completed the Quiz Test. Now you can click on finish and go back to your home page.</p>
            <div class="stats">
                <p>Total Questions: <strong><?= $total_questions ?></strong></p>
                <p>Correct Questions: <strong><?= $correct_answers ?></strong></p>
                <p>Accuracy: <strong><?php echo number_format($percentage, 2); ?>%</strong></p>
            </div>
            <p>Your Score: <strong><?= $score ?>/<?= $total_questions ?></strong></p>
            <p>Passing Score: <strong>80%</strong></p>
        <?php } else { ?>
            <h3 class="text-success">🙇🏻💔 Sorry..! 🙇🏻‍♂️💔</h3>
            <p>You did not complete the Exam.</p>
            <div class="stats">
                <p>Total Questions: <strong>0</strong></p>
                <p>Correct Questions: <strong>0</strong></p>
                <p>Accuracy: <strong>0%</strong></p>
            </div>
            <p>Your Score: <strong>0/0</strong></p>
            <p><strong>No result found!</strong></p>
        <?php } ?>
        <a href="index.php" class="btn btn-primary btn-custom">Go Back</a>
        <button class="btn btn-outline-secondary btn-custom">Share</button>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
