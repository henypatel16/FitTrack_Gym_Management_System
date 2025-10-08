<?php
session_start();
@include '../config.php';

// Booking Confirm
if (isset($_GET['confirm'])) {
    $id = intval($_GET['confirm']);
    mysqli_query($conn, "UPDATE class_join SET status = 'Confirmed' WHERE id = $id");
    header("Location: admin_booking.php");
    exit();
}

// Booking Cancel
if (isset($_GET['cancel'])) {
    $id = intval($_GET['cancel']);
    mysqli_query($conn, "UPDATE class_join SET status = 'Cancelled' WHERE id = $id");
    header("Location: admin_booking.php");
    exit();
}

// Booking Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM class_join WHERE id = $id limit 1");
    header("Location: admin_booking.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Manage Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_booking.css">
</head>

<body>
  <?php @include ('admin_header.php'); ?>

<div class="container">
  <h2 class="mb-4 text-center">MANAGE CLASS BOOKINGS</h2>

  <div class="table-responsive">
    <table class="table table-bordered table-hover text-center table-dark">
      <thead class="table-dark">
        <tr>
          <th>Class Title</th>
          <th>Name</th>
          <th>Date & Time</th>
          <th>Status</th>
          <th>Joined At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result = mysqli_query($conn, "SELECT cj.*, c.title, c.date, c.time 
                                       FROM class_join cj 
                                       JOIN classes c ON cj.class_id = c.id 
                                       ORDER BY cj.joined_at DESC");
        if (mysqli_num_rows($result) > 0):
            while ($row = mysqli_fetch_assoc($result)):
        ?>
          <tr>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['Name']) ?></td>
            <td><?= $row['date'] ?>  <?= date('h:i A', strtotime($row['time'])) ?></td>    
            <td>
              <?php if ($row['status'] == 'Pending'): ?>
                <span class="badge bg-warning text-dark">Pending</span>
              <?php elseif ($row['status'] == 'Confirmed'): ?>
                <span class="badge bg-success">Confirmed</span>
              <?php else: ?>
                <span class="badge bg-danger">Cancelled</span>
              <?php endif; ?>
            </td>
            <td><?= $row['joined_at'] ?></td>
            <td>
              <a href="?confirm=<?= $row['id'] ?>" class="btn btn-success btn-sm">Confirm</a>
              <a href="?cancel=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Cancel</a>
              <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
          </tr>
        <?php endwhile; else: ?>
          <tr>
            <td colspan="9" class="text-white">No bookings found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
        
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
