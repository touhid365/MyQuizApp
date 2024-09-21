<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: /online_exam/login.php");
    exit();
}

// Include the database connection file (optional if needed)
$conn = new mysqli("sql212.infinityfree.com", "if0_37332007", "OvpN2AKrm7h8DP", "if0_37332007_quiz_db");
include '../databae.php';

// Retrieve the user's information (optional)
$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['email'];
$sql ="SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);



$exam_id = $_GET['id'];

// Prepare the SQL statement with placeholders
$sql = "SELECT exams.id, exams.title AS exam_title, exams.total_time, questions.id AS question_id, questions.question, questions.option_a, questions.option_b, questions.option_c, questions.option_d
        FROM exams
        LEFT JOIN questions ON exams.id = questions.exam_id
        WHERE exams.id = ?";

// Prepare the statement
$stmt = mysqli_prepare($conn, $sql);

// Bind the parameters
mysqli_stmt_bind_param($stmt, 'i', $exam_id); // Assuming $exam_id is an integer

// Execute the statement
mysqli_stmt_execute($stmt);

// Fetch the results
$result = mysqli_stmt_get_result($stmt);
$questions = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Close the statement
mysqli_stmt_close($stmt);


$exam_title = '';
$total_time = 0;
$total_questions = 0;

if (!empty($questions)) {
    $exam_title = $questions[0]['exam_title'];
    $total_time = $questions[0]['total_time'];
    $total_questions = count($questions);
} else {
    $exam_title = 'Not Found';
}

// if (!isset($_SESSION['exam_id'])) {
//     header("Location:http://localhost/School-Manegment-System/Students/exam/confirmation.php");
//     exit();
// }
if (!isset($exam_id)) {
    header("Location:http://localhost/School-Manegment-System/Students/exam/confimation.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($exam_title) ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="icon" href="../images/school_8220314.png" type="image/x-icon">
    <style>
        /* Your existing CSS styles */
        body {
            background-color: #f8f9fa;
        }
        .quiz-card {
            border: 2px solid #6c63ff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .quiz-header {
            background-color: #fff;
            border-bottom: 1px solid #e9ecef;
            padding: 20px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .quiz-header h2 {
            margin: 0;
        }
        .quiz-body {
            background-color: #fff;
            padding: 20px;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }
        .progress {
            height: 3px;
            border-radius: 5px;
        }
        #timer {
            font-size: 18px;
            border: 1px solid crimson;
            padding: 2px;
            border-radius: 5px;
        }
        .timer-label {
            font-weight: bold;
            margin-right: 5px;
        }
        .nav-btns .btn {
            width: 100px;
        }
        .nav-btns .btn-primary {
            background-color: #6c63ff;
            border: none;
        }
        .nav-btns .btn-primary:hover {
            background-color: #5146d3;
        }
        .question {
            padding: 15px;
            margin-bottom: 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
        }
        .form-check-input {
            display: none;
        }
        .form-check-label {
            display: block;
            padding: 10px;
            border: 2px solid #dee2e6;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: #f8f9fa;
            cursor: pointer;
            transition: background-color 0.3s, border-color 0.3s, color 0.3s;
        }
        .form-check-input:checked + .form-check-label {
            background-color: #d4edda;
            border-color: #28a745;
            color: #008200;
        }
        .form-check-label:hover {
            background-color: #e9ecef;
            border-color: #6c63ff;
        }
    </style>
    <script>
    let timeLeft = <?= $total_time * 60; ?>;
let timerInterval;

function startTimer() {
    const timerElement = document.getElementById('time-remaining');
    timerInterval = setInterval(() => {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        seconds = seconds < 10 ? `0${seconds}` : seconds;
        timerElement.textContent = `${minutes}:${seconds}`;
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            alert("Time's up! Submitting your exam...");
            document.getElementById('quizForm').submit(); // Auto-submit the form
        }
        timeLeft--;
    }, 1000);
}

function submitAndResetTimer() {
    // Disable the submit button
    document.getElementById('submitBtn').disabled = true;
    
    // Set timer to 0 and stop further countdowns
    timeLeft = 0;
    clearInterval(timerInterval);

    // Optionally show a message to the user
    alert("Your exam is being submitted...");

    // Submit the form
    document.getElementById('quizForm').submit();

    // Refresh the page after a short delay
    setTimeout(function() {
        location.reload();
    }, 1000); // 1-second delay before refresh
}

window.onload = function() {
    startTimer();
    updateProgressBar();
    document.getElementById('submitBtn').disabled = false; // Ensure button is enabled when page loads
};

</script>

</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card quiz-card">
                    <div class="card-header quiz-header d-flex justify-content-between align-items-center">
                        <h2 class="mb-0"><?= htmlspecialchars($exam_title) ?></h2>
                        <div id="timer" class="text-danger fw-bold">
                            <span class="timer-label">Time Left: </span><span id="time-remaining"></span>
                        </div>
                    </div>
                    <div class="card-body quiz-body">
                        <div class="progress mb-4">
                            <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <form id="quizForm" action="submit_answer.php" method="post" onsubmit="submitAndResetTimer()">
                            <input type="hidden" name="exam_id" value="<?= $exam_id ?>">
                            <?php foreach ($questions as $index => $question): ?>
                                <div class="question" id="question-<?= $index ?>" style="<?= $index === 0 ? '' : 'display: none' ?>">
                                    <h5>Question <?= $index + 1 ?> of <?= $total_questions ?></h5>
                                    <p><?= htmlspecialchars($question['question']) ?></p>
                                    <input type="hidden" name="question_ids[]" value="<?= $question['question_id'] ?>">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="answers[<?= $question['question_id'] ?>]" value="A" id="q<?= $question['question_id'] ?>a">
                                        <label class="form-check-label" for="q<?= $question['question_id'] ?>a"><?= htmlspecialchars($question['option_a']) ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="answers[<?= $question['question_id'] ?>]" value="B" id="q<?= $question['question_id'] ?>b">
                                        <label class="form-check-label" for="q<?= $question['question_id'] ?>b"><?= htmlspecialchars($question['option_b']) ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="answers[<?= $question['question_id'] ?>]" value="C" id="q<?= $question['question_id'] ?>c">
                                        <label class="form-check-label" for="q<?= $question['question_id'] ?>c"><?= htmlspecialchars($question['option_c']) ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="answers[<?= $question['question_id'] ?>]" value="D" id="q<?= $question['question_id'] ?>d">
                                        <label class="form-check-label" for="q<?= $question['question_id'] ?>d"><?= htmlspecialchars($question['option_d']) ?></label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="d-flex justify-content-between mt-4 nav-btns">
                                <?php
                                // Check if the student has already completed this exam
                                $exam_id = $question['id'];
                                $conn = new mysqli("sql212.infinityfree.com", "if0_37332007", "OvpN2AKrm7h8DP", "if0_37332007_quiz_db");
                                $check_result = $conn->query("SELECT id FROM user_answers WHERE user_id = '$user_id' AND exam_id = '$exam_id' LIMIT 1");
                                $has_completed = $check_result->num_rows > 0;
                                ?>
                                <button type="button" id="prevBtn" class="btn btn-secondary" onclick="navigateQuestion(-1)" disabled>Previous</button>
                                <button type="button" id="nextBtn" class="btn btn-primary" onclick="navigateQuestion(1)">Next</button>
                                <?php if ($has_completed): ?>
                                <button type="submit" class="btn btn-success" id="submitBtn" style="display: none;" disabled>Submit</button>
                                <?php else: ?>
                                <button type="submit" class="btn btn-success" id="submitBtn" style="display: none;">Submit</button>
                                <?php endif; ?>    
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentQuestion = 0;
        const totalQuestions = <?= $total_questions ?>;

        function updateProgressBar() {
            const progress = ((currentQuestion + 1) / totalQuestions) * 100;
            document.getElementById('progress-bar').style.width = `${progress}%`;
            document.getElementById('progress-bar').setAttribute('aria-valuenow', progress);
        }

        function navigateQuestion(step) {
            document.getElementById(`question-${currentQuestion}`).style.display = 'none';
            currentQuestion += step;
            document.getElementById(`question-${currentQuestion}`).style.display = 'block';
            document.getElementById('prevBtn').disabled = currentQuestion === 0;
            document.getElementById('nextBtn').style.display = currentQuestion === totalQuestions - 1 ? 'none' : 'inline-block';
            document.getElementById('submitBtn').style.display = currentQuestion === totalQuestions - 1 ? 'inline-block' : 'none';
            updateProgressBar();
        }

        window.onload = function() {
            startTimer();
            updateProgressBar();
        };
    </script>
    <!-- <script>
    setTimeout(function(){
        window.location.href = 'confirmation.php'; // Redirect to another page, e.g., the dashboard
    }, 1000); // 5-second delay before redirect
    </script> -->
</body>
</html>
