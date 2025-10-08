<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About Us - FitTrack Gym</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="../css/about.css" rel="stylesheet">  
</head>

<body>
<?php include 'user_header.php'; ?>

<!-- Page Banner -->
<div class="page-banner d-flex flex-column justify-content-center align-items-center text-center">
  <span style="color: #ff6600; font-size: 26px; font-weight: bold;">ABOUT US</span>
  <h2 class="display-5 fw-bold text-white mt-2">KNOW MORE ABOUT FITTRACK GYM</h2>
</div>

<!-- About Section -->
<div class="container about-content py-5">
  <div class="row align-items-center">
    <!-- Left side Image -->
    <div class="col-md-6 mb-4">
      <img src="../img/about.webp" alt="Our Gym" class="img-fluid rounded-4 shadow-lg">
    </div>

    <!-- Right side Content -->
    <div class="col-md-6 text-light">
      <h2 class="mb-3 fw-bold">WHO WE ARE</h2>
      <p>
        At <strong>FitTrack Gym</strong>, we believe fitness is more than just workouts - it’s a lifestyle. 
        Our mission is to empower people of all ages to live healthier and stronger lives through 
        personalized training, state-of-the-art equipment, and a supportive community.
      </p>
      <p>
        With certified trainers and a wide variety of programs, we make sure you achieve your fitness 
        goals - whether it’s building muscle, losing weight, or improving stamina.
      </p>
    </div>
  </div>
</div>

<!-- Features Section -->
<div class="features py-5">
  <div class="container text-center">
    <h2 class="mb-5 fw-bold"style="color: #ff6600;">WHY CHOOSE US?</h2>
    
    <div class="row g-4">
      <div class="col-md-4">
        <div class="feature-box p-4 rounded-4 shadow-lg">
          <i class="fas fa-dumbbell fa-3x mb-3 text-warning"></i>
          <h4 class="text-light">Modern Equipment</h4>
          <p>Top-notch machines and weights designed for every fitness level.</p>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="feature-box p-4 rounded-4 shadow-lg">
          <i class="fas fa-users fa-3x mb-3 text-warning"></i>
          <h4 class="text-light">Expert Trainers</h4>
          <p>Certified trainers who guide you every step of the way.</p>
        </div>
      </div>
    
    <div class="col-md-4">
        <div class="feature-box p-4 rounded-4 shadow-lg">
          <i class="fas fa-heartbeat fa-3x mb-3 text-warning"></i>
          <h4 class="text-light">Personalized Plans</h4>
          <p>Workout and diet plans tailored to your specific goals.</p>
        </div>
      </div>
   

   <div class="row g-4 mt-4">
      
   <div class="col-md-4">
        <div class="feature-box p-4 rounded-4 shadow-lg">
            <i class="fas fa-clipboard-list fa-2x text-warning mb-3"></i>
            <h4 class="text-light">Tailored Programs</h4>
            <p>Personalized training programs designed according to your body type, fitness level, and unique goals.</p>
        </div>
    </div>
   
    <div class="col-md-4">
        <div class="feature-box p-4 rounded-4 shadow-lg">
            <i class="fas fa-users fa-2x text-warning mb-3"></i>
            <h5 class="text-light">Supportive Community</h5>
            <p>You’re not just joining a gym, you’re becoming part of a family that celebrates every success with you.</p>
        </div>
      </div>
    
   <div class="col-md-4">
        <div class="feature-box p-4 rounded-4 shadow-lg">
            <i class="fas fa-broom fa-2x text-warning mb-3"></i>
            <h5 class="text-light">Clean & Hygienic</h5>
            <p>We ensure a clean, modern, and hygienic environment so you can focus on your workout with peace of mind.</p>
        </div>
      </div>
     </div>
    </div>
   </div>
  </div>
</div>

<!-- Client Reviews Section -->
<div class="reviews py-5">
  <div class="container text-center">
    <h2 class="mb-5 fw-bold" style="color: #ff6600;">WHAT OUR CLIENTS SAY</h2>
    <div class="row g-4 justify-content-center">

      <div class="col-md-4">
        <div class="review-card p-4 rounded-4 shadow-lg text-light">
          <img src="../img/client1.avif" class="review-img rounded-circle mb-3" alt="Client 1">
          <p>"FitTrack Gym has completely transformed my lifestyle. The trainers are so motivating and supportive!"</p>
          <h6 class="text-warning">- Rahul Sharma</h6>
        </div>
      </div>

      <div class="col-md-4">
        <div class="review-card p-4 rounded-4 shadow-lg text-light">
          <img src="../img/client2.avif" class="review-img rounded-circle mb-3" alt="Client 2">
          <p>"I love the energy here! The workouts are well-structured, and the staff always pushes me to do my best. Highly recommended!"</p>
          <h6 class="text-warning">- Neha Gupta</h6>
        </div>
      </div>

      <div class="col-md-4">
        <div class="review-card p-4 rounded-4 shadow-lg text-light">
          <img src="../img/client3.avif" class="review-img rounded-circle mb-3" alt="Client 3">
          <p>"Joining FitTrack Gym was the best decision I made. Great facilities, friendly trainers, and real results in just a few weeks!"</p>
          <h6 class="text-warning">- Arjun Mehta</h6>
        </div>
      </div>

    </div>
  </div>
</div>

<?php include 'user_footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
