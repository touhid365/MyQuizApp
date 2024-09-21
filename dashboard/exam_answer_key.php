<?php
$host = 'localhost';
$db = 'quiz_db';
$user = 'root'; // Change as per your database username
$pass = ''; // Change as per your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
session_start();

$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
$exam_id = $_GET['exam_id'];

// Fetch user answers and correct answers by joining user_answers and questions tables
$sql = " 
    SELECT 
        q.id as question_id,
        q.question,
        ua.selected_option, 
        q.correct_option, 
        ua.user_id,
        rs.name
    FROM 
        user_answers ua
    INNER JOIN 
        questions q 
    ON 
        ua.question_id = q.id
    INNER JOIN 
        users rs
    ON 
        ua.user_id = rs.id
    WHERE 
        ua.user_id = :user_id AND ua.exam_id = :exam_id
";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindParam(':exam_id', $exam_id, PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Answer Key</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link rel="icon" href="../images/school_8220314.png" type="image/x-icon">
    <style>
        body {
            background-color: #f0f4f8;
            color: #333;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 30px;
        }
        .premium-table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
        }
        .premium-table th, .premium-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .premium-table th {
            background-color: #0056b3;
            color: white;
            text-align: center;
        }
        .premium-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .premium-table tr:hover {
            background-color: #e2e6ea;
        }
        .header {
            background-color: #0056b3;
            color: white;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
        }
        .alert-info {
            border: 1px solid #0056b3;
            background-color: #e9f5ff;
            color: #0056b3;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .highlight-correct {
            color: #28a745;
            font-weight: bold;
        }
        .highlight-wrong {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1> Your Answer Key</h1>
        </div>
        <div class="alert alert-info" role="alert">
            <strong>Instructions:</strong> Review the answers and compare them with the correct options.
        </div>
        <table class="premium-table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Question No</th>
                    <th>Question</th>
                    <th>User Answer</th>
                    <th>Correct Answer</th>
                    <th>Student Name</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?php echo $count++; ?></td> 
                        <td><?php echo $result['question_id']; ?></td> 
                        <td><?php echo htmlspecialchars($result['question']); ?></td>
                        <td><?php echo htmlspecialchars($result['selected_option']); ?></td>
                        <td class="highlight-correct"><?php echo htmlspecialchars($result['correct_option']); ?></td>
                        <td><?php echo htmlspecialchars($result['name'] ) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
