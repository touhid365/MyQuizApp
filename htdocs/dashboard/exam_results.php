<?php
include '../databae.php';


session_start();
$user_id = $_SESSION['user_id'];

// Retrieve student's stream from the database
// $student_stream_query = $conn->query("SELECT * FROM users WHERE id = '$user_id'");
// $student_stream_row = $student_stream_query->fetch_assoc();
// $student_stream = $student_stream_row['stream']; // Get the student's stream (e.g., Science or Arts)

// Fetch the list of exams from the database
$result = $conn->query("SELECT id, title FROM exams ");
$count = 1;

if ($result === false) {
    die('Error: ' . htmlspecialchars($conn->error));
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result </title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../images/school_8220314.png" type="image/x-icon">
    <style>
        /* Custom CSS */
        .table td, .table th {
            vertical-align: middle;
            text-align: center;
        }
        .action-btns .btn {
            margin: 1px 1px 5px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Exam Results</h2>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Exam Name</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                 <th scope='row'><?=$count++?></th>
                 <td><?= $row['title']?></td>
                 <td class='action-btns'>
                    <a href='your_result.php?exam_id=<?=$row['id'] ?>'  class='btn btn-primary'>Result</a>
                    <a href='scoreboard.php?exam_id=<?= $row['id'] ?>'  class='btn btn-success'>Scoreboard</a>
                    <a href='exam_answer_key.php?exam_id=<?= $row['id'] ?>'  class='btn btn-warning'>Answer Key</a>
                 </td>
                </tr>
            <?php endwhile; ?>
            <?php
            // Sample data for demonstration
            // $exams = [
            //     ['id' => 1, 'name' => 'Math Exam'],
            //     ['id' => 2, 'name' => 'Science Exam'],
            //     ['id' => 3, 'name' => 'History Exam'],
            // ];

            // foreach ($exams as $exam) {
            //     echo "<tr>";
            //     echo "<th scope='row'>" . $exam['id'] . "</th>";
            //     echo "<td>" . $exam['name'] . "</td>";
            //     echo "<td class='action-btns'>
            //             <a href='result.php?exam_id=" . $exam['id'] . "' class='btn btn-primary'>Result</a>
            //             <a href='scoreboard.php?exam_id=" . $exam['id'] . "' class='btn btn-success'>Scoreboard</a>
            //           </td>";
            //     echo "</tr>";
            // }
            ?> 
        </tbody>
    </table>
</div>


<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
