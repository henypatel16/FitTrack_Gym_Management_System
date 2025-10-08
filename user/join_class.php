<?php
session_start();
@include '../config.php';

// if (!isset($_SESSION['username'])) {
//     header("Location: ../login.php");
//     exit();
// }

$class_id = isset($_GET['class_id']) ? intval($_GET['class_id']) : 0;
if ($class_id <= 0) {
    echo "<div class='alert alert-danger'>Invalid class ID.</div>";
    exit();
}

$class_query = mysqli_query($conn, "SELECT * FROM classes WHERE id = $class_id");
if (mysqli_num_rows($class_query) == 0) {
    echo "<div class='alert alert-danger'>Class not found.</div>";
    exit();
}
$class = mysqli_fetch_assoc($class_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Join Class - Hustlers Gym</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/join_class.css">
</head>
<body>
<?php include 'user_header.php'; ?>

<div class="join-class-section py-5 mt-4">
  <div class="form-wrapper  mx-auto p-4 bg-dark text-white rounded">
    <h2 class="text-center mb-4" style="color: #ff6600;">JOIN CLASS</h2>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="join_process.php" method="POST">
      <input type="hidden" name="class_id" value="<?= $class['id']; ?>">

      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="tel" name="phone" class="form-control" placeholder="Enter your phone number" required>
      </div>
     
      <div class="mb-3">
        <label class="form-label">Class Title</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($class['title']); ?>" readonly>
      </div>

      <div class="mb-3">
        <label class="form-label">Date & Time</label>
        <input type="text" class="form-control" value="<?= $class['date'] . ' at ' . $class['time']; ?>" readonly>
      </div>


      <div class="text-center d-flex justify-content-center gap-3 mt-3">
        <button type="submit" class="btn btn-warning px-4">CONFIRM</button>
        <a href="classes.php" class="btn btn-info px-4">CANCEL</a>
      </div>

    </form>
  </div>
</div>

<?php include 'user_footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>