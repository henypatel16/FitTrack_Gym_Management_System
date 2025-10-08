<?php
session_start();
include '../config.php';

// Check login and session
if(!isset($_SESSION['user_id']) || !isset($_SESSION['member_id'])){
    header("Location: ../login.php");
    exit;
}

$member_id = $_SESSION['member_id'];
$member_name = $_SESSION['member_name'];

// Fetch plans for this member
$sql = "SELECT * FROM plans WHERE member_id='$member_id' ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Workout & Diet Plans</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="../css/workout_diet.css">
</head>

<body>
<?php include 'user_header.php'; ?>

<section class="plans-section">
  <div class="container mb-5 mt-4">
    <h2 class="section-subtitle text-center">YOUR PLANS</h2>
    <h3 class="section-title text-center"><span style="text-transform: uppercase;"><?php echo $member_name; ?>'s<span> WORKOUT & DIET SCHEDULE</h3>
    <p class="text-center mb-5" style="color: #c8c6c6;">Follow your personalized schedule to achieve your fitness goals faster.</p>

    <?php if(mysqli_num_rows($result) > 0){ ?>
      <div class="card-custom">
        <div class="table-responsive">
          <table class="table table-dark table-bordered table-hover align-middle custom-table text-center">
            <thead>
              <tr>
                <th>#</th>
                <th><i class="fas fa-file-alt"></i> Plan Title</th>
                <th><i class="fas fa-tag"></i> Type</th>
                <th><i class="fas fa-align-left"></i> Description</th>
                <th><i class="fas fa-clock"></i> Duration</th>
                <th><i class="fas fa-calendar-alt"></i> Assigned On</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $count = 1;
              while($row = mysqli_fetch_assoc($result)){ ?>
                <tr>
                  <td><?php echo $count++; ?></td>
                  <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                  <td><?php echo ucfirst(htmlspecialchars($row['type'])); ?></td>
                  <td><?php echo nl2br(htmlspecialchars($row['description'])); ?></td>
                  <td><?php echo htmlspecialchars($row['duration']); ?></td>
                  <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php } else { ?>
      <p style="color:#ff9900; text-align:center;">No plans assigned yet.</p>
    <?php } ?>
  </div>
</section>

<?php include 'user_footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
