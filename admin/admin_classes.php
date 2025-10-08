<?php
session_start();
@include '../config.php';

function convertTo24Hour($hour, $minute, $ampm) {
    if ($ampm == 'PM' && $hour != 12) {
        $hour += 12;
    } elseif ($ampm == 'AM' && $hour == 12) {
        $hour = 0;
    }
    return sprintf('%02d:%02d:00', $hour, $minute);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $trainer = $_POST['trainer'];
    $date = $_POST['date'];
    $capacity = $_POST['capacity'];
    $id = $_POST['id'] ?? null;

    $hour = (int)$_POST['hour'];
    $minute = (int)$_POST['minute'];
    $ampm = $_POST['ampm'];
    $time = convertTo24Hour($hour, $minute, $ampm);

    $image_name = '';
    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $image_name);
    }

    if (isset($_POST['update'])) {
        if (empty($id)) {
            $_SESSION['error_message'] = "Please select a class to update by clicking the Edit button first.";
            header('Location: admin_classes.php#classes');
            exit;
        }

        $sql = "UPDATE classes SET 
            title='$title',
            trainer='$trainer',
            date='$date',
            time='$time',
            capacity='$capacity'" .
            ($image_name ? ", image='$image_name'" : "") .
            " WHERE id='$id'";
        mysqli_query($conn, $sql);

    } elseif (isset($_POST['add'])) {
        $sql = "INSERT INTO classes (title, trainer, date, time, capacity, image)
            VALUES ('$title', '$trainer', '$date', '$time', '$capacity', '$image_name')";
        mysqli_query($conn, $sql);
    }

    header('Location: admin_classes.php#classes');
    exit();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM classes WHERE id = $id");
    header('Location: admin_classes.php');
    exit();
}

$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM classes WHERE id = $id");
    $editData = mysqli_fetch_assoc($res);
    if ($editData) {
        $editTime = date('h:i A', strtotime($editData['time']));
        list($editHour, $editMinute, $editMeridiem) = sscanf($editTime, "%d:%d %s");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Manage Classes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_classes.css">
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
  <h2 class="text-center fw-bold mb-4 mt-4" style="padding-top: 3px;">ADD NEW CLASSES</h2>

  <div class="row justify-content-center">
    <div class="col-md-12 col-lg-12">

      <div class="card p-4 mb-5 shadow-lg border-0">
        <form method="POST" enctype="multipart/form-data"  class="row g-3">
        <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">
          
          <div class="col-md-6 mb-3">
            <label class="form-label">Class Title</label>
            <input type="text" name="title" class="form-control " required value="<?= $editData['title'] ?? '' ?>">
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label">Trainer</label>
            <input type="text" name="trainer" class="form-control " required value="<?= $editData['trainer'] ?? '' ?>">
          </div>
          
          <div class="col-md-6 mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control text-muted" required value="<?= $editData['date'] ?? '' ?>">
          </div>
          
          <div class="col-md-6 mb-3">
            <label class="form-label">Time</label>
            <div class="d-flex gap-2">
              <select name="hour" class="form-select custom-time text-muted" required>
                <?php for ($i = 1; $i <= 12; $i++): ?>
                  <option class="text-dark" value="<?= $i ?>" <?= (isset($editHour) && $editHour == $i) ? 'selected' : '' ?>><?= sprintf('%02d', $i) ?></option>
                <?php endfor; ?>
              </select>
              <select name="minute" class="form-select custom-time text-muted" required>
                <?php foreach ([0, 15, 30, 45] as $m): ?>
                  <option class="text-dark" value="<?= $m ?>" <?= (isset($editMinute) && $editMinute == $m) ? 'selected' : '' ?>><?= sprintf('%02d', $m) ?></option>
                <?php endforeach; ?>
              </select>
              <select name="ampm" class="form-select custom-time text-muted" required>
                <option class="text-dark" value="AM" <?= (isset($editMeridiem) && $editMeridiem == 'AM') ? 'selected' : '' ?>>AM</option>
                <option class="text-dark" value="PM" <?= (isset($editMeridiem) && $editMeridiem == 'PM') ? 'selected' : '' ?>>PM</option>
              </select>
            </div>
          </div>
          
          <div class="col-md-6 mb-3">
            <label class="form-label">Capacity</label>
            <input type="number" name="capacity" class="form-control " min="0" required value="<?= $editData['capacity'] ?? '' ?>">
          </div>
          
          
        <div class="col-md-6 file-upload-wrapper mb-3"> 
          <label class="form-label file-upload-label">Choose File</label>
          <input type="file" name="image" class="form-control text-muted" accept="image/*" <?= $editData ? '' : 'required' ?>>
        </div>

        <div class="text-center mt-4">
         <?php if ($editData): ?>
          <div class="d-flex justify-content-center gap-3">
            <button type="submit" name="update" class="btn btn-primary">Update Class</button>
            <a href="admin_classes.php" class="btn btn-secondary">Cancel</a>
          </div>
         <?php else: ?>
           <button type="submit" name="add" class="btn btn-success">Add Class</button>
         <?php endif; ?>
       </div>

     </form>
    </div>
   </div>
</div>

  <h2 id="classes" class="mb-4 text-center fw-bold">CLASSES ADDED</h2>
  <div class="row g-4">
    <?php
    $result = mysqli_query($conn, "SELECT * FROM classes ORDER BY created_at DESC");
    if (mysqli_num_rows($result) > 0):
        while ($row = mysqli_fetch_assoc($result)):
    ?>
      <div class="col-md-4 d-flex py-3">
        <div class="card p-3 h-100 w-100">
          <img src="../uploads/<?= $row['image'] ?>" class="img-fluid mb-3 rounded" alt="Class Image">
          <h5 class="text-center fw-bold" style="color: #ff6600; font-weight: bold;"><?= htmlspecialchars($row['title']) ?></h5>
          <p class="text-muted mb-1"><strong >Trainer:</strong> <?= $row['trainer'] ?></p>
          <p class="text-muted mb-1"><strong>Date:</strong> <?= $row['date'] ?></p>
          <p class="text-muted mb-1"><strong>Time:</strong> <?= date('h:i A', strtotime($row['time'])) ?></p>
          <p class="text-muted mb-1"><strong>Capacity:</strong> <?= $row['capacity'] ?></p>
          <p class="text-muted mb-1"><strong>Created:</strong> <?= $row['created_at'] ?></p>

          <div class="d-flex justify-content-center gap-2 mt-3">
            <a href="?edit=<?= $row['id'] ?>" class="btn btn-warning px-4">Edit</a>
            <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger px-3">Delete</a>
          </div>

        </div>
      </div>
    <?php endwhile; endif; ?>
  </div>
</div>
        
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
