<?php
include '../config.php';

// trainer data fetch 
$query = "SELECT * FROM trainers ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Our Trainers - FitTrack</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/trainer.css">
</head>

<body>
<?php include 'user_header.php'; ?>

<!-- Trainers Section -->
<div class="trainers-section">
  <div class="container">

    <!-- Section Heading -->
    <div class="text-center mb-5 mt-4">
      <span class="section-subtitle">OUR TRAINERS</span>
      <h2 class="section-title">MEET THE EXPERTS BEHIND YOUR FITNESS JOURNEY</h2>
    </div>

    <div class="row justify-content-center">
      <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <div class="col-md-4">
          <div class="trainer-card">
            <img src="../uploads/<?php echo $row['profile_pic']; ?>" alt="Trainer" class="trainer-img">
            <h4><i class="fas fa-user-tie"></i> <?php echo $row['name']; ?></h4>
            <p><i class="fas fa-dumbbell"></i> <strong>Specialization:</strong> <?php echo $row['specialization']; ?></p>
            <p><i class="fas fa-briefcase"></i> <strong>Experience:</strong> <?php echo $row['experience']; ?> years</p>
            <p><i class="fas fa-clock"></i> <strong>Availability:</strong> <?php echo $row['availability']; ?></p>
            <p><i class="fas fa-phone"></i> <strong>Contact:</strong> <?php echo $row['contact']; ?></p>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>

<?php include 'user_footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
