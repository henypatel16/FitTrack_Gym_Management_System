<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Services - FitTrack</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/services.css">
</head>

<body>
<?php include 'user_header.php'; ?>

<div class="page-banner d-flex flex-column justify-content-center align-items-center text-center">
  <span style="color: #ff6600; font-size: 26px; font-weight: bold;">OUR SERVICES</span>
  <h2 class="display-5 fw-bold text-white mt-2">DISCOVER WHAT WE OFFER</h2>
</div>

<!-- Services Section -->
<div class="services-section">
  <div class="container">
    <div class="row justify-content-center">

    <!-- BMI -->
      <div class="col-md-4">
       <a href="bmi.php">
        <div class="service-card">
          <img src="../img/bmi.jpeg" alt="BMI" class="service-img">
          <h4><i class="fas fa-heartbeat"></i> BMI Check</h4>
          <p>Measure your Body Mass Index and monitor health progress effectively.</p>
        </div>
       </a>
      </div>

      <!-- Attendance -->
      <div class="col-md-4">
        <a href="attendance.php">
         <div class="service-card">
          <img src="../img/attendance.jpg" alt="Attendance" class="service-img">
          <h4><i class="fas fa-calendar-check"></i> Attendance</h4>
          <p>Stay disciplined and track your gym visits with our smart attendance system.</p>
         </div>
        </a>
      </div>

        <!-- Workout & Diet -->
      <div class="col-md-4">
        <a href="workout_diet.php">
         <div class="service-card">
          <img src="../img/diet.jpg" alt="Workout & Diet" class="service-img">
          <h4><i class="fas fa-utensils"></i> Workout & Diet</h4>
          <p>Get personalized workout and nutrition plans for faster and sustainable results.</p>
         </div>
        </a>
      </div>

    </div>

    <!-- second row -->
    <div class="row justify-content-center mt-4">
    
      <!-- Trainers -->
      <div class="col-md-4">
       <a href="trainer.php">
        <div class="service-card">
          <img src="../img/trainer.avif" alt="Trainers" class="service-img">
          <h4><i class="fas fa-user-tie"></i> Trainers</h4>
          <p>Train with certified experts who guide you at every step of your fitness journey.</p>
        </div>
       </a>
      </div>
     
      <!-- Equipment -->
      <div class="col-md-4">
        <a href="equipment.php">
        <div class="service-card">
          <img src="../img/form roller and mat.jpg" alt="Equipment" class="service-img">
          <h4><i class="fas fa-dumbbell"></i> Equipment</h4>
          <p>Access modern equipment designed to maximize performance and safety.</p>
        </div>
       </a>
      </div>

     </div>
  </div>
</div>

<?php include 'user_footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
