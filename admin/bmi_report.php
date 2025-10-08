<?php
session_start();
@include '../config.php'; 


// Fetch BMI records with user details
$sql = "SELECT b.id, u.username, b.age, b.height, b.weight, b.bmi, b.created_at 
        FROM bmi_records b 
        JOIN users u ON b.user_id = u.id 
        ORDER BY b.created_at DESC";
$result = $conn->query($sql);

// --- Delete Record ---
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM bmi_records WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: bmi_report.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">  
    <link href="../css/bmi_report.css" rel="stylesheet">
</head>

<body>
    <?php @include ('admin_header.php'); ?>
    
<section class="bmi-section">
  <div class="container">
    
    <!-- Section Heading -->
    <div class="text-center mb-5">
      <h2 class="section-title">BMI REPORT (ALL USERS)</h2>
      <p>View and manage BMI records submitted by all users.</p>
    </div>

    <!-- Table Card -->
    <div class="card-custom">
      <div class="table-responsive">
        <table class="table custom-table text-center align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>User</th>
              <th>Age</th>
              <th>Height (m)</th>
              <th>Weight (kg)</th>
              <th>BMI</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($result->num_rows > 0) { 
              while($row = $result->fetch_assoc()) { ?>
                <tr>
                  <td><?php echo $row['id']; ?></td>
                  <td><?php echo htmlspecialchars($row['username']); ?></td>
                  <td><?php echo $row['age']; ?></td>
                  <td><?php echo $row['height']; ?></td>
                  <td><?php echo $row['weight']; ?></td>
                  <td><?php echo $row['bmi']; ?></td>
                  <td><?php echo $row['created_at']; ?></td>
                  <td>
                    <a href="bmi_report.php?delete=<?= $row['id'] ?>" 
                       onclick="return confirm('Delete this record?')" 
                       class="btn btn-danger btn-sm">Delete
                    </a>
                  </td>
                </tr>
              <?php } 
            } else { ?>
              <tr>
                <td colspan="8">
                  <div class="alert alert-dark text-center m-0">
                    No BMI records found.
                  </div>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
