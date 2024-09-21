
<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: /online_exam/login.php");
    exit();
}

// Include the database connection file (optional if needed)
include '../databae.php';

// Retrieve the user's information (optional)
$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['email'];
$sql ="SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);


// Fetch the list of exams from the database matching the student's stream
$result = $conn->query("SELECT id, title, total_marks, total_question, total_time FROM exams  ");

if ($result === false) {
    die('Error: ' . htmlspecialchars($conn->error));
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Exams</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaX73wMY8fHLE9CMei8RleI/1D2K8Ck64UHBVDKNLWLae/7fhHp8+LWWw7G" crossorigin="anonymous">

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
    <link rel="icon" href="../images/school_8220314.png" type="image/x-icon">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }
        .exam-card {
            border: 2px solid #007bff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        .exam-header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .exam-body {
            background-color: #fff;
            padding: 20px;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
        }
        th, td {
            text-align: center;
            padding: 10px;
            border: 1px solid #dee2e6;
        }
        th {
            background-color: #f1f1f1;
        }
        .start-btn {
            background-color: coral;
            border: none;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            text-transform: uppercase;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .start-btn:hover {
            background-color: #218838;
            color: #fff;
        }
        .complete-exam {
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
        }
        .complete-exam h5 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card exam-card">
                    <div class="card-header exam-header">
                        <h2 class="mb-0">Available Exams</h2>
                    </div>
                    <div class="card-body exam-body">
                        <h5>Select an exam from the list below:</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Exam Name</th>
                                    <th>Total Questions</th>
                                    <th>Total Marks</th>
                                    <th>Total Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <?php
                                // Check if the student has already completed this exam
                                $exam_id = $row['id'];
                                $check_result = $conn->query("SELECT id FROM user_answers WHERE user_id = '$user_id' AND exam_id = '$exam_id' LIMIT 1");
                                $has_completed = $check_result->num_rows > 0;
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                                    <td><?php echo htmlspecialchars($row['total_question']); ?></td>
                                    <td><?php echo htmlspecialchars($row['total_marks']); ?></td>
                                    <td><?php echo htmlspecialchars($row['total_time']); ?> minutes</td>
                                    <td>
                                        <?php if ($has_completed): ?>
                                            <a href="#" class="start-btn" style="text-decoration: none; background:#218838; ">Complete</a>
                                        <?php else: ?>
                                            <a href="instructions.php?id=<?= $exam_id ?>" class="start-btn" style="text-decoration: none;">Start</a>
                                        <?php endif; ?>
                                    </td>
                                    <!-- <td><a href="instructions.php?id=<?=$row['id']?>" class="start-btn" onclick="startExam('React Basics Quiz')" style="text-decoration: none;" >Start</a></td> -->
                                </tr>
                                <?php endwhile; ?>
                               
                            </tbody>
                        </table>
                        <div class="complete-exam" id="completeExamSection" style="display: none;">
                            <h5>Complete the Exam: <span id="selectedExam"></span></h5>
                            <form id="examForm" action="submit_exam.php" method="post">
                                <!-- Example question, you can dynamically load the selected exam questions here -->
                                <div class="mb-3">
                                    <label class="form-label">What is React?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="q1" id="q1a" value="A">
                                        <label class="form-check-label" for="q1a">A JavaScript library for building user interfaces</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="q1" id="q1b" value="B">
                                        <label class="form-check-label" for="q1b">A server-side framework</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="q1" id="q1c" value="C">
                                        <label class="form-check-label" for="q1c">A database management system</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Submit Exam</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
