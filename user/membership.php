<?php
session_start();
@include '../config.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Membership Plans - FitTrack</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="../css/user_membership.css" rel="stylesheet"> 
</head>
<body>
  <?php include 'user_header.php'; ?>

  <div class="page-banner d-flex flex-column justify-content-center align-items-center text-center">
    <span style="color: #ff6600; font-size: 26px; font-weight: bold;">OUR PLAN</span>
    <h2 class="display-5 fw-bold text-white mt-2">CHOOSE YOUR PRICING PLAN</h2>
  </div>
  <div class="container-fluid px-0">
    <div class="section-title">
          <div class="container-fluid my-0 py-0 px-0" style="background-color: #000;">
           <div class="d-flex justify-content-end mb-3 p-4">
            <a href="enroll_process.php" class="btn btn-outline-light border rounded-pill px-4 py-2">VIEW MY ENROLLMENTS</a>
           </div>

      <div class="card-container">
       <?php
         $query = "SELECT * FROM memberships";
         $result = mysqli_query($conn, $query);
         if (mysqli_num_rows($result) > 0):
         while ($row = mysqli_fetch_assoc($result)):
        ?>
    <div class="membership-card">
      <h4><?php echo htmlspecialchars($row['title']); ?></h4>
           <div class="price">₹ <?php echo htmlspecialchars($row['price']); ?></div>
           <div class="duration"><?php echo htmlspecialchars($row['duration']); ?></div>           
           <div class="description"><?php echo htmlspecialchars($row['description']); ?></div>
           <a href="enroll_form.php?plan=<?php echo urlencode($row['title']); ?>" class="btn btn-enroll text-white">ENROLL NOW</a>
    </div>
      <?php endwhile; else: ?>
        <p class="text-center text-muted">No memberships found.</p>
      <?php endif; ?>
    </div>
  </div>
 </div>

  <?php include 'user_footer.php'; ?>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>   