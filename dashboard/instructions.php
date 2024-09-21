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

// Fetch the list of exams from the database
$exam_id=$_GET['id'];
$sql = $conn->query("SELECT * FROM exams WHERE id = '$exam_id'");
$exam_id=$_GET['id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Instructions</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../images/school_8220314.png" type="image/x-icon">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }
        .instruction-card {
            border: 2px solid #007bff; /* Card border */
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        .instruction-header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .instruction-body {
            background-color: #fff;
            padding: 20px;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }
        .instruction-body h5 {
            margin-top: 20px;
            color: #6c757d;
        }
        .instruction-body ul {
            padding-left: 20px;
        }
        .instruction-body ul li {
            margin-bottom: 10px;
        }
        .start-btn {
            background-color: #28a745;
            border: none;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-transform: uppercase;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .start-btn:hover {
            background-color: #218838;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card instruction-card">
                    <div class="card-header instruction-header">
                        <h2 class="mb-0">Exam Instructions and Guidelines</h2>
                    </div>
                    <div class="card-body instruction-body">
                        <h5>Please read the following instructions carefully before you begin the exam:</h5>
                        <ul>
                            <li>The exam consists of multiple-choice questions.</li>
                            <?php while ($row = $sql->fetch_assoc()): ?>
                            <li>You have a total of <strong><?= $row['total_time']?> minutes</strong> to complete the exam.</li>
                            <li>You have a total of <strong><?= $row['total_question']?> questions</strong> for the exam.</li>
                            <?php endwhile; ?>
                            <li>Each question carries equal marks. There is no negative marking.</li>
                            <li>Make sure to select the most appropriate answer for each question.</li>
                            <li>Once you have completed the exam, you cannot go back to change your answers.</li>
                            <li>Click on the <strong>"Submit"</strong> button to submit your exam.</li>
                            <li>Ensure a stable internet connection throughout the exam.</li>
                            <li>If you encounter any issues, contact the exam administrator immediately.</li> 
                        </ul>
                        <h5>Guidelines:</h5>
                        <ul>
                            <li>Do not use any external resources or devices during the exam.</li>
                            <li>Maintain academic integrity. Any form of cheating or misconduct will result in disqualification.</li>
                            <li>Ensure you are in a quiet environment free from distractions.</li>
                            <li>Use only the allowed browser and device as specified by the exam administrator.</li>
                        </ul>
                        <div class="text-center mt-4">
                            <a href="online_exam.php?id=<?= $exam_id?>" class="start-btn" style="text-decoration: none; text-transform: lowercase; ">l am ready to being</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
