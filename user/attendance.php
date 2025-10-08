<?php
session_start();
include '../config.php';

// Check login
if(!isset($_SESSION['user_id']) || !isset($_SESSION['member_id'])){
    header("Location: ../login.php");
    exit;
}

$member_id = $_SESSION['member_id'];
$member_name = $_SESSION['member_name'];

// Fetch attendance records for this member
$sql = "SELECT * FROM attendance WHERE member_id='$member_id' ORDER BY date DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $member_name; ?>'s Attendance</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="../css/attendance.css">
</head>

<body>
<?php include 'user_header.php'; ?>

<section class="attendance-section">
  <div class="container mb-5 mt-4">

    <!-- Subtitle & Title -->
    <h2 class="section-subtitle text-center">YOUR ATTENDANCE</h2>
    <h3 class="section-title text-center">
      <span style="text-transform: uppercase;"><?php echo $member_name; ?>'s</span> 
      ATTENDANCE RECORD
    </h3>
    <p class="text-center mb-5" style="color:#c8c6c6;">Track your consistency and stay motivated to reach your fitness goals.</p>

    <?php if(mysqli_num_rows($result) > 0){ ?>
      <div class="card-custom">
        <div class="table-responsive">
          <table class="table table-dark table-bordered table-hover align-middle custom-table text-center">
            <thead>
              <tr>
                <th>#</th>
                <th><i class="fas fa-calendar-alt"></i> Date</th>
                <th><i class="fas fa-check-circle"></i> Status</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $count = 1;
              while($row = mysqli_fetch_assoc($result)){ ?>
                <tr>
                  <td><?php echo $count++; ?></td>
                  <td><?php echo htmlspecialchars($row['date']); ?></td>
                  <td>
                    <?php 
                      $status = ucfirst($row['status']);
                      if($status == "Present"){
                        echo "<span class='badge bg-success'>$status</span>";
                      } elseif($status == "Absent"){
                        echo "<span class='badge bg-danger'>$status</span>";
                      } else {
                        echo "<span class='badge bg-secondary'>$status</span>";
                      }
                    ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php } else { ?>
      <p style="color:#ff9900; text-align:center;">No attendance records found.</p>
    <?php } ?>
  </div>
</section>

<?php include 'user_footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
