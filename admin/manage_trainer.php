<?php
session_start();
@include '../config.php'; 

// ADD TRAINER
if (isset($_POST['add_trainer'])) {
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    $experience = $_POST['experience'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $availability = $_POST['availability'];
    $status = $_POST['status'];

    $profile_pic = $_FILES['profile_pic']['name'];
    $tmp_name = $_FILES['profile_pic']['tmp_name'];
    $folder = "uploads/" . $profile_pic;
    if ($profile_pic) move_uploaded_file($tmp_name, $folder);

    $insert = "INSERT INTO trainers (name, specialization, experience, contact, email, availability, profile_pic, status) 
               VALUES ('$name', '$specialization', '$experience', '$contact', '$email', '$availability', '$profile_pic', '$status')";
    mysqli_query($conn, $insert);
    header("Location: manage_trainer.php#trainers");
    exit;
}

// UPDATE TRAINER
if (isset($_POST['update_trainer'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    $experience = $_POST['experience'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $availability = $_POST['availability'];
    $status = $_POST['status'];

    if (!empty($_FILES['profile_pic']['name'])) {
        $profile_pic = $_FILES['profile_pic']['name'];
        $tmp_name = $_FILES['profile_pic']['tmp_name'];
        $folder = "../uploads/" . $profile_pic;
        move_uploaded_file($tmp_name, $folder);

        $update = "UPDATE trainers SET 
                    name='$name',
                    specialization='$specialization',
                    experience='$experience',
                    contact='$contact',
                    email='$email',
                    availability='$availability',
                    profile_pic='$profile_pic',
                    status='$status'
                   WHERE id=$id";
    } else {
        $update = "UPDATE trainers SET 
                    name='$name',
                    specialization='$specialization',
                    experience='$experience',
                    contact='$contact',
                    email='$email',
                    availability='$availability',
                    status='$status'
                   WHERE id=$id";
    }

    mysqli_query($conn, $update);
    header("Location: manage_trainer.php#trainers");
    exit;
}

// DELETE TRAINER
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM trainers WHERE id=$id");
    header("Location: manage_trainer.php#trainers");
    exit;
}

// EDIT TRAINER
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM trainers WHERE id=$id");
    $editData = mysqli_fetch_assoc($result);
}

// FETCH ALL TRAINERS
$trainers = mysqli_query($conn, "SELECT * FROM trainers ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Trainers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">  
    <link href="../css/manage_trainer.css" rel="stylesheet">
</head>

<body class="dark-theme">
  <?php @include ('admin_header.php'); ?>

  <div class="container mt-4">
      <h2 class="page-title text-center"><?= $editData ? "EDIT TRAINER" : "ADD NEW TRAINER" ?></h2>

      <!-- Form -->
      <div class="card form-card shadow-lg mt-3">
        <div class="card-body">
          <form action="" method="POST" enctype="multipart/form-data" class="row g-3">
              <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

              <div class="col-md-6">
                <label class="form-label">Trainer Name</label>
                <input type="text" name="name" class="form-control" value="<?= $editData['name'] ?? '' ?>" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Specialization</label>
                <input type="text" name="specialization" class="form-control" value="<?= $editData['specialization'] ?? '' ?>" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Experience</label>
                <input type="text" name="experience" class="form-control" value="<?= $editData['experience'] ?? '' ?>">
              </div>

              <div class="col-md-6">
                <label class="form-label">Contact</label>
                <input type="text" name="contact" class="form-control" value="<?= $editData['contact'] ?? '' ?>">
              </div>

              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= $editData['email'] ?? '' ?>">
              </div>

              <div class="col-md-6">
                <label class="form-label">Availability</label>
                <input type="text" name="availability" class="form-control" value="<?= $editData['availability'] ?? '' ?>">
              </div>

              <div class="col-md-6">
                <label class="form-label">Profile Picture</label>
                <input type="file" name="profile_pic" class="form-control">
                <?php if (!empty($editData['profile_pic'])): ?>
                  <img src="uploads/<?= $editData['profile_pic'] ?>" width="80" class="mt-2 rounded">
                <?php endif; ?>
              </div>

              <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="Active" <?= (isset($editData) && $editData['status']=='Active')?'selected':'' ?>>Active</option>
                    <option value="Inactive" <?= (isset($editData) && $editData['status']=='Inactive')?'selected':'' ?>>Inactive</option>
                </select>
              </div>

              <div class="col-12 text-center mt-4">
                <button type="submit" name="<?= $editData ? 'update_trainer' : 'add_trainer' ?>" class="btn btn-primary px-5">
                  <?= $editData ? 'Update Trainer' : 'Add Trainer' ?>
                </button>
                <?php if ($editData): ?>
                  <a href="manage_trainer.php" class="btn btn-secondary">Cancel</a>
                <?php endif; ?>
              </div>
          </form>
        </div>
      </div>

      <hr class="my-5 text-light">

      <!-- Trainers card -->
      <h3 id="trainers" class="page-title text-center mb-3">TRAINERS LIST</h3>
   
      <div class="container my-4">
    <div class="row">
        <?php while($row = mysqli_fetch_assoc($trainers)) { ?>
            <div class="col-md-4 mb-4">
                <div class="card trainer-card h-100">
                    <img src="../uploads/<?= $row['profile_pic'] ?>" alt="<?= $row['name'] ?>">
                    <div class="card-body">
                        <h5 class="card-title text-center"><?= $row['name'] ?></h5>
                        <p class="card-text"><strong>Specialization:</strong> <?= $row['specialization'] ?></p>
                        <p class="card-text"><strong>Experience:</strong> <?= $row['experience'] ?> years</p>
                        <p class="card-text"><strong>Availability:</strong> <?= $row['availability'] ?></p>
                        <p class="card-text"><strong>Status:</strong> 
                            <span class="<?= $row['status']=='Active' ? 'text-success fw-bold' : 'text-danger fw-bold' ?>">
                                <?= $row['status'] ?>
                            </span>
                        </p>
                        <small>
                            <i class="bi bi-telephone"></i> <?= $row['contact'] ?> <br>
                            <i class="bi bi-envelope"></i> <?= $row['email'] ?>
                        </small>
                        <div class="d-flex justify-content-center gap-2 mt-3">
                            <a href="manage_trainer.php?edit=<?= $row['id'] ?>" class="btn btn-warning px-4">Edit</a>
                            <a href="manage_trainer.php?delete=<?= $row['id'] ?>" 
                               onclick="return confirm('Delete this trainer?')" 
                               class="btn btn-danger px-3">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
  </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
