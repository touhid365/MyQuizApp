<?php
ob_start(); // Start output buffering
session_start();

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

// include '../databae.php'; // Make sure db.php sets up $conn as a MySQLi connection


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'] ;
    
    $exam_id = $_POST['exam_id'];
    $answers = $_POST['answers']; // Array of question_id => selected_option

    // fetch the total question from database
    $sql = "SELECT COUNT(*) AS total_questions FROM questions WHERE exam_id = :exam_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':exam_id', $exam_id, PDO::PARAM_INT);
    $stmt->execute();
    $total_questions = $stmt->fetchColumn();

    foreach ($answers as $question_id => $selected_option) {
        // Check if the user answered the question
      
        if ($selected_option) {
           
                    $sql = "SELECT 
                        ua.question_id, 
                        ua.selected_option, 
                        q.correct_option 
                    FROM 
                        user_answers ua
                    INNER JOIN 
                        questions q 
                    ON 
                        ua.question_id = q.id
                    WHERE 
                        ua.user_id = :user_id 
                    AND 
                        ua.exam_id = :exam_id
                ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':user_id' => $user_id,
                    ':exam_id' => $exam_id
                ]);
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($results) {
                    foreach ($results as $result) {
                        echo "Question ID: " . $result['question_id'] . "<br>";
                        echo "Selected Option: " . $result['selected_option'] . "<br>";
                        echo "Correct Option: " . $result['correct_option'] . "<br><br>";
                    }
                } else {
                    echo "No results found.";
                }
                

          
        }
           // Check if the user has already submitted answers for this exam
        include 'db.php';
        $sql = "SELECT COUNT(*) FROM user_answers WHERE user_id = :user_id AND exam_id = :exam_id ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':exam_id', $exam_id, PDO::PARAM_INT);
        $stmt->execute();
        $submission_count = $stmt->fetchAll();
        
        if ( $submission_count == $user_id  ) {
         // If answers are already submitted, redirect to results page or show a message
         header("Location: confirmation.php?exam_id=" . $exam_id);
         exit();
        } else {

        // Store the user's answer
        $sql = "INSERT INTO user_answers (user_id, exam_id, question_id, selected_option)
                VALUES (:user_id, :exam_id, :question_id, :selected_option)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':exam_id' => $exam_id,
            ':question_id' => $question_id,
            ':selected_option' => $selected_option
        ]);
    }
}



    // -------------storethe result ----------
    $sql = "SELECT COUNT(*) FROM results_tb WHERE user_id = :user_id AND exam_id = :exam_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':exam_id', $exam_id, PDO::PARAM_INT);
    $stmt->execute();
    $result_count = $stmt->fetchColumn();
   
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
$incorrect_answers = 0;


// Calculate score and percentage
$score = $correct_answers;
$percentage = ($correct_answers / $total_questions) * 100;

//store the result, into database table result_td

if ($result_count == $user_id) {
    // If the result is already stored, redirect to results page or show a message
    header("Location: your_result.php?exam_id=" . $exam_id);
    exit();
} else {

// Store the result in the results_tb table
$sql = "INSERT INTO results_tb (user_id, exam_id, total_questions, correct_answers, score, percentage)
        VALUES (:user_id, :exam_id, :total_questions, :correct_answers, :score, :percentage)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':user_id' => $user_id,
    ':exam_id' => $exam_id,
    ':total_questions' => $total_questions,
    ':correct_answers' => $correct_answers,
    ':score' => $score,
    ':percentage' => $percentage
]);

      // Redirect to the result page after storing the result
    //   header("Location: result.php?exam_id=" . $exam_id);
      header("Location:confirmation.php?exam_id=" . $exam_id);
      
}

}
ob_end_flush(); // Flush the output buffer and turn off output buffering



