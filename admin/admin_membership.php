<?php
session_start();
@include '../config.php';

$error = "";

if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $description = $_POST['description'];
 
    $sql = "INSERT INTO memberships (title, price, duration, description) VALUES ('$title', '$price', '$duration', '$description')";
    $conn->query($sql);
    header("Location: admin_membership.php#memberships");
}

$editData = null;
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    $result = $conn->query("SELECT * FROM memberships WHERE id = $editId");
    $editData = $result->fetch_assoc();
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM memberships WHERE id = $id");
    header("Location: admin_membership.php#memberships");
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];

    if (empty($id)) {
        $_SESSION['error_message'] = "Please select a membership to update by clicking the Edit button first.";
        header("Location: admin_membership.php");
        exit;
    }

    $title = $_POST['title'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];

    $conn->query("UPDATE memberships SET title='$title', price='$price', description='$description', duration='$duration' WHERE id=$id");
    header("Location: admin_membership.php#memberships");
}

$memberships = $conn->query("SELECT * FROM memberships ORDER BY id DESC");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Membership</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="../css/admin_membership.css" rel="stylesheet">
</head>
<body>
    <?php @include ('admin_header.php'); ?>

    <?php if (isset($_SESSION['error_message'])): ?>
    <div class="container mt-3">
        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="font-weight: bold;">
            <?= $_SESSION['error_message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>


    <div class="container">
        <h2 class="text-center mb-4 mt-4" style="color: #ff6600;">ADD NEW MEMBERSHIP PLANS</h2>
    
    <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card p-4 mb-5 shadow-lg border-0">
<form method="POST">
    <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control form-control-lg shadow-sm" 
               value="<?= $editData['title'] ?? '' ?>" 
               placeholder="e.g., Premium Plan" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Price (₹)</label>
        <input type="number" name="price" class="form-control form-control-lg shadow-sm" 
               value="<?= $editData['price'] ?? '' ?>" 
               min="0" placeholder="e.g., 999" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Duration</label>
        <input type="text" name="duration" class="form-control form-control-lg shadow-sm" 
               value="<?= $editData['duration'] ?? '' ?>" 
               placeholder="e.g., 1 Month / 6 Months" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control form-control-lg shadow-sm" rows="3" 
                  placeholder="Write about the plan..." required><?= $editData['description'] ?? '' ?></textarea>
    </div>

    <div class="text-center mt-4">
      <?php if ($editData): ?>
       <div class="d-flex justify-content-center gap-3">
        <button type="submit" name="update" class="btn btn-primary">Update Membership Plan</button>
        <a href="admin_membership.php" class="btn btn-secondary">Cancel</a>
       </div>
      <?php else: ?>
       <button type="submit" name="add" class="btn btn-success">Add Membership Plan</button>
      <?php endif; ?>
    </div>
</form>
  </div>
 </div>
</div>

    <div class="row g-4 mb-5">
   <h2 id="memberships" class="mb-4 text-center fw-bold" style="color: #ff6600;">MEMBERSHIP PLANS ADDED</h2>
   <?php foreach ($memberships as $m): ?>
       <div class="col-md-4">
            <div class="card p-3 h-100 text-center">
                <h5 class="mb-2" style="color: #ff6600; font-weight: bold;"><?= $m['title'] ?></h5>
                <p class="text-muted mb-1"><?= $m['description'] ?></p>
                <p class="text-white mb-1"><strong style="color: #ffb74d; font-weight: bold;">Duration:</strong> <?= $m['duration'] ?></p>
                <h6><strong style="color: #ffb74a; font-weight: bold;">Price:</strong> ₹<?= $m['price'] ?></h6>

                <div class="d-flex justify-content-center gap-2 mt-3">
                    <a href="?edit=<?= $m['id'] ?>" class="btn btn-warning px-4">Edit</a>
                    <a href="?delete=<?= $m['id'] ?>" class="btn btn-danger px-3">Delete</a>
                </div>    
            </div>
        </div>
   <?php endforeach; ?>
</div>

<script>
function fillForm(id, title, price, description, duration) {
    document.getElementById('id').value = id;
    document.getElementById('title').value = title;
    document.getElementById('price').value = price;
    document.getElementById('description').value = description;
    document.getElementById('duration').value = duration;

    // Hide Add button
    document.getElementById('addBtn').style.display = "none";

    // Show Update + Cancel buttons
    let editBtns = document.getElementById('editBtns');
    editBtns.style.display = "flex";
    editBtns.style.visibility = "visible";

    document.getElementById('title').focus();
}

function resetForm() {
    document.getElementById('id').value = "";
    document.getElementById('title').value = "";
    document.getElementById('price').value = "";
    document.getElementById('description').value = "";
    document.getElementById('duration').value = "";

    // Show Add button again
    document.getElementById('addBtn').style.display = "inline-block";

    // Hide Update + Cancel buttons
    let editBtns = document.getElementById('editBtns');
    editBtns.style.display = "none";
    editBtns.style.visibility = "hidden";
}

</script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"> </script>
</body>
</html>   