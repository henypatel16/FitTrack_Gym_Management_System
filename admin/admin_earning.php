<?php
//session_start();
include('../config.php');

if (isset($_POST['update_status'])) {
  $id = $_POST['update_id'];
  $newStatus = $_POST['new_status'];
  mysqli_query($conn, "UPDATE enrollments SET status='$newStatus' WHERE id=$id");
}

if (isset($_POST['delete_enrollment'])) {
  $id = $_POST['delete_id'];
  mysqli_query($conn, "DELETE FROM enrollments WHERE id=$id");
}

$query = "SELECT e.*, m.price FROM enrollments e LEFT JOIN memberships m ON TRIM(e.plan) = TRIM(m.title) ORDER BY e.id DESC";
$result = mysqli_query($conn, $query);

$earnQuery = "SELECT SUM(m.price) AS total_earning FROM enrollments e JOIN memberships m ON TRIM(e.plan) = TRIM(m.title) WHERE e.status = 'Paid'";
$earnResult = mysqli_query($conn, $earnQuery);
$row = mysqli_fetch_assoc($earnResult);
$totalEarnings = $row['total_earning'] ?? 0;
?>


<!DOCTYPE html>
<html>
<head>
  <title>Admin - Earnings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_earning.css">
</head>
<body>
  <?php include 'admin_header.php'; ?>

  <div class="container my-1">
    <h2 class="mb-4">Total Earnings: ₹<?php echo number_format($totalEarnings); ?></h2>

    <div class="table-responsive">
    <table class="table table-bordered table-hover text-center table-dark">
      <thead class="table-dark">
        <tr>
          <th>Name</th>
          <th>Plan</th>
          <th>Price</th>
          <th>Payment</th>
          <th>Status</th>
          <th style="width: 250px;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td><?php echo htmlspecialchars($row['name']); ?></td>
          <td><?php echo htmlspecialchars($row['plan']); ?></td>
          <td>₹<?php echo number_format($row['price']); ?></td>
          <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
          <td><?php echo htmlspecialchars($row['status']); ?></td>
          <td style="text-align: center;">
        
          <form method="POST" style="display: flex; align-items: center; justify-content: center; gap: 8px;">
           <input type="hidden" name="update_id" value="<?php echo $row['id']; ?>">
           
              <select name="new_status" class="form-select form-select-sm bg-dark text-white border-secondary " style="width: 120px;">
                 <option value="Pending" <?php if ($row['status']=='Pending') echo 'selected'; ?>>Pending</option> 
                 <option value="Paid" <?php if ($row['status']=='Paid') echo 'selected'; ?>>Paid</option> 
                 <option value="Cancelled" <?php if ($row['status']=='Cancelled') echo 'selected'; ?>>Cancelled</option>
              </select>
            
            
                <button type="submit" name="update_status" class="btn btn-success btn-sm">Update</button>
                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                <button type="submit" name="delete_enrollment" class="btn btn-danger btn-sm">Delete</button>
            
          </form>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>