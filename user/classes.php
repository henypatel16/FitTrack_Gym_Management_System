<?php
session_start();
@include '../config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Classes - FitTrack</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/user_classes.css">
</head>
<body>

<?php include 'user_header.php'; ?>

<div class="page-banner d-flex flex-column justify-content-center align-items-center text-center">
  <span style="color: #ff6600; font-size: 26px; font-weight: bold;">OUR CLASSES</span>
  <h2 class="display-5 fw-bold text-white mt-2">EXPLORE OUR FITNESS PROGRAMS</h2>
</div>

<div class="container-fluid px-0">
  <div class="section-title">
     <div class="container-fluid my-0 py-0 px-0" style="background-color: #000;">
    <div class="d-flex justify-content-end mb-3 p-4">
            <a href="join_process.php" class="btn btn-outline-light border rounded-pill px-4 py-2">VIEW MY BOOKINGS</a>
           </div>

  <div class="card-container">
    <?php
    $query = "SELECT * FROM classes";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0):
      while ($row = mysqli_fetch_assoc($result)):
    ?>
    <div class="class-card mb-4 mt-4">
      <img src="../uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Class Image">
      <h4 class="text-center"><?php echo htmlspecialchars($row['title']); ?></h4>
      <div class="details">Trainer: <?php echo htmlspecialchars($row['trainer']); ?></div>
      <div class="details">Date: <?php echo htmlspecialchars($row['date']); ?></div>
      <div class="details">Time: <?php echo date("h:i A",strtotime($row['time'])); ?></div>
      <div class="details">Capacity: <?php echo htmlspecialchars($row['capacity']); ?></div>
      <a href="join_class.php?class_id=<?php echo $row['id']; ?>" class="btn btn-join text-white text-center mb-2 mt-2">JOIN NOW</a>

    </div>
    <?php endwhile; else: ?>
      <p class="text-center text-muted">No classes available at the moment.</p>
    <?php endif; ?>
  </div>
</div>
    </div>
</div>

<?php include 'user_footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>