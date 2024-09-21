<?php
include '../databae.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submited Exam</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../images/school_8220314.png" type="image/x-icon">
    <style>
        .card-custom {
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        @media (max-width:790px) {
            .card-custom {
            margin: 20px 40px;
            
           
        }
        }
        .card-title
        {
            color: rgb(2, 150, 2);
        }
        .card-custom .btn-submit {
            background-color: #007bff;
            color: white;
            border: none;
        }
        .card-custom .btn-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-custom">
                    <div class="card-body">
                        <h5 class="card-title ">🎉🎊Your Exam is Submit Successfully🎉🎊</h5>
                        <p class="card-text">Once you submit your exam, you will not be able to make any changes. Please review your answers carefully before submitting.</p>
                        <a href="index.php" class="btn btn-submit">back to home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <script>
    setTimeout(function(){
        window.location.href = 'index.php'; // Redirect to another page, e.g., the dashboard
    }, 5000); // 5-second delay before redirect
    </script> -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
