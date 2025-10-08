<?php
session_start();
@include '../config.php'; 

$selectedPlan = isset($_GET['plan']) ? $_GET['plan'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Enroll Now</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/enroll_form.css">
</head>
<body>
<?php include 'user_header.php'; ?>

<div class="enroll-section py-5 mt-5" >
  <div class="container">
    <div class="form-wrapper mx-auto p-4 bg-dark text-white rounded">
      <h2 class="text-center mb-4" style="color: #ff6600">Membership Enrollment</h2>
      
      <form action="enroll_process.php" method="POST">
        <div class="mb-3">
          <label>Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Phone</label>
          <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Selected Plan</label>
          <input type="text" name="plan" class="form-control" value="<?php echo htmlspecialchars(trim($selectedPlan)); ?>" readonly>
        </div>
        <div class="mb-4">
          <label>Payment Method</label>
          <select name="payment_method" class="form-control" required>
            <option value="Cash">Cash</option>
            <option value="Online">Online</option>
          </select>
        </div>
        <div class="justify-content-center text-center" style="display: flex; gap: 20px;">
          <button type="submit" name="enroll" class="btn btn-warning px-5">SUBMIT</button>
          <a href="membership.php" class="btn btn-info px-5 text-dark" style="text-decoration: none;">CANCEL</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'user_footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>