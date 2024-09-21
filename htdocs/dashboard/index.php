<?php include 'header.php'; ?>

<div class="container mt-5" style="border-radius: 1rem;" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <h4 class="card-title mb-4" >Hi, <strong style="color:#777;" ><?php echo htmlspecialchars($row['name']); ?></strong> Welcome to your My<span style="color :coral; font-weight: 600; " >Quiz</span>App Dashboard.<br> Your quizid is - <span style="color: coral; font-size: 22px;"><?php echo htmlspecialchars($row['quiz_id']); ?></span></h4>
                    <p class="card-text">Here you can manage your quiz test, view your results, and access various features.</p>
                    <a href="exam_shedule.php" class="btn btn-primary">Start Quiz</a>
                    <a href="exam_results.php" class="btn btn-success">Results</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-primary text-center text-white mt-5 ">
    <div class=" mt-4 p-3">
      <p>
        Made by 
        <a class="text-white" href="https://github.com/touhid365/">@touhid365</a>
      </p>
   </div>
  <!-- Copyright -->
  <div class="text-center p-3 mt-4" style="background-color: rgba(0, 0, 0, 0.2);">
    © 2024 all right reserved
    <a class="text-white" href="https://myquizapp.wuaze.com/">MyQuizApp.com</a>
  </div>
  <!-- Copyright -->
</footer>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
