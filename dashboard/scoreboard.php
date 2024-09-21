<?php
include '../databae.php';
session_start();
$message = '';
$user_id = $_SESSION['user_id']; // Get the current user's ID

$exam_id = $_GET['exam_id'];

// Assuming you have the selected exam ID stored in a variable
$selected_exam_id = $exam_id;

$sql = "SELECT 
        r.id,
        s.name AS student_name, 
        s.quiz_id AS Quiz_ID,
        e.title AS exam_name, 
        r.total_questions, 
        r.correct_answers, 
        r.score, 
        r.percentage, 
        r.created_at,
        FIND_IN_SET(r.percentage, (
            SELECT GROUP_CONCAT(percentage ORDER BY percentage DESC) 
            FROM results_tb 
            WHERE exam_id = r.exam_id
        )) AS `ranking`,
        r.user_id AS result_user_id
    FROM 
        results_tb r
    JOIN 
        users s ON r.user_id = s.id
    JOIN 
        exams e ON r.exam_id = e.id
    WHERE 
        r.exam_id = '$selected_exam_id' 
    ORDER BY 
        r.percentage DESC, r.created_at ASC";

$result = $conn->query($sql);
$count = 1;

if ($result === false) {
    $message = "Error: " . $conn->error;
    exit;
}

$scoreboard = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $scoreboard[] = $row;
    }
} else {
    $message = '<div class="alert alert-danger" role="alert"><strong>Error!</strong> No results found.</div>';
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Scoreboard</title>
    <!-- Bootstrap CSS -->
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../images/school_8220314.png" type="image/x-icon">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table-wrapper {
            width: 80%;
            margin: 50px auto;
        }
        h2 {
            margin-top: 20px;
            text-align: center;
            color: #343a40;
        }
        table {
            margin-bottom: 20px;
        }
        .highlight {
            background-color: #d4edda; /* Light green background for highlighted row */
        }
    </style>
</head>
<body>

<h2>Exam Scoreboard</h2>

<div class="table-wrapper">
    <table class="table table-bordered table-hover table-striped table-responsive-sm">
        <thead class="thead-dark">
            <tr>
                <th>S.NO</th>
                <th>Student Name</th>
                <th>Quiz ID</th>
                <th>Score</th>
                <th>Percentage</th>
                <th>Rank</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($scoreboard)): ?>
                <?php foreach ($scoreboard as $row): ?>
                    <tr class="<?php echo $row['result_user_id'] == $user_id ? 'highlight' : ''; ?>">
                        <td><?php echo htmlspecialchars($count++); ?></td>
                        <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['Quiz_ID']); ?></td>
                        <td><?php echo htmlspecialchars($row['score']); ?></td>
                        <td><?php echo htmlspecialchars($row['percentage']); ?></td>
                        <td><?php echo htmlspecialchars($row['ranking']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No scores available</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
