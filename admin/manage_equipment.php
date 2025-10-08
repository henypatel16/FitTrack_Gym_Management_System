<?php
session_start();
@include '../config.php';

// Helpers
function safe($v){ return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
function upload_image($file, $old = null){
    if (!isset($file['name']) || $file['error'] !== UPLOAD_ERR_OK) return $old;
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new = time() . '_' . bin2hex(random_bytes(4)) . '.' . strtolower($ext);
    $dir = realpath(__DIR__ . '/../uploads');
   
    if (!$dir) {
       @mkdir(__DIR__ . '/../uploads', 0777, true); $dir = realpath(__DIR__ . '/../uploads');
       }
    $equipDir = $dir . '/equipment';
   
    if (!is_dir($equipDir)) @mkdir($equipDir, 0777, true);
    $target = $equipDir . '/' . $new;
   
    if (move_uploaded_file($file['tmp_name'], $target)) {
        return 'equipment/' . $new;
    }
    return $old;
}

// --------- ADD EQUIPMENT ----------
if (isset($_POST['add_equipment'])) {
    $name          = mysqli_real_escape_string($conn, $_POST['name']);
    $category      = mysqli_real_escape_string($conn, $_POST['category']);
    $quantity      = (int)($_POST['quantity'] ?? 0);
    $purchase_date = mysqli_real_escape_string($conn, $_POST['purchase_date']);
    $price         = (float)($_POST['price'] ?? 0);
    $condition     = mysqli_real_escape_string($conn, $_POST['condition_status']);
    $imagePath     = upload_image($_FILES['image']);

    $sql = "INSERT INTO equipment (name, category, quantity, purchase_date, price, condition_status, image)
            VALUES ('$name','$category',$quantity," . 
            ($purchase_date ? "'$purchase_date'" : "NULL") . ", $price, '$condition'," .
            ($imagePath ? "'$imagePath'" : "NULL") . ")";
    mysqli_query($conn, $sql);
    header("Location: manage_equipment.php#equipment");
    exit;
}

// --------- DELETE EQUIPMENT ----------
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $res = mysqli_query($conn, "SELECT image FROM equipment WHERE id=$id");
    if ($res && $row = mysqli_fetch_assoc($res)) {
        if (!empty($row['image'])) {
            $full = realpath(__DIR__ . '/../uploads/' . $row['image']);
            if ($full && file_exists($full)) @unlink($full);
        }
    }
    mysqli_query($conn, "DELETE FROM equipment WHERE id=$id");
    header("Location: manage_equipment.php#equipment");
    exit;
}

// --------- EDIT ----------
$edit = null;
if (isset($_GET['edit'])) {
    $eid  = (int)$_GET['edit'];
    $resE = mysqli_query($conn, "SELECT * FROM equipment WHERE id=$eid");
    $edit = mysqli_fetch_assoc($resE) ?: null;
}

// --------- UPDATE EQUIPMENT ----------
if (isset($_POST['update_equipment'])) {
    $id            = (int)$_POST['id'];
    $name          = mysqli_real_escape_string($conn, $_POST['name']);
    $category      = mysqli_real_escape_string($conn, $_POST['category']);
    $quantity      = (int)($_POST['quantity'] ?? 0);
    $purchase_date = mysqli_real_escape_string($conn, $_POST['purchase_date']);
    $price         = (float)($_POST['price'] ?? 0);
    $condition     = mysqli_real_escape_string($conn, $_POST['condition_status']);
    $oldImg = null;
    $rOld = mysqli_query($conn, "SELECT image FROM equipment WHERE id=$id");
    if ($rOld && $o = mysqli_fetch_assoc($rOld)) $oldImg = $o['image'];
    $newImg = upload_image($_FILES['image'], $oldImg);

    $sql = "UPDATE equipment SET
              name='$name',
              category='$category',
              quantity=$quantity,
              purchase_date=" . ($purchase_date ? "'$purchase_date'" : "NULL") . ",
              price=$price,
              condition_status='$condition',
              image=" . ($newImg ? "'$newImg'" : "NULL") . "
            WHERE id=$id";
    mysqli_query($conn, $sql);
    header("Location: manage_equipment.php#equipment");
    exit;
}

// --------- FETCH LIST ----------
$list = mysqli_query($conn, "SELECT * FROM equipment ORDER BY created_at DESC, id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Equipment</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">  
  <link href="../css/manage_equipment.css" rel="stylesheet">
</head>
<body class="dark-theme">
  <?php @include 'admin_header.php'; ?>

<div class="container mt-4">
  <h2 class="page-title text-center"><?= $edit ? "EDIT EQUIPMENT" : "ADD NEW EQUIPMENT" ?></h2>

  <!-- Add/Edit Form -->
  <div class="card form-card shadow-lg mt-3">
    <div class="card-body">
      <form method="POST" enctype="multipart/form-data" class="row g-3">
        <?php if ($edit): ?>
          <input type="hidden" name="id" value="<?= safe($edit['id']) ?>">
        <?php endif; ?>

        <div class="col-md-6">
          <label class="form-label">Equipment Name</label>
          <input type="text" name="name" class="form-control" value="<?= safe($edit['name'] ?? '') ?>" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">Category</label>
          <select name="category" class="form-select">
            <option value="">Select Category</option>
            <?php
            $cats = ['Cardio','Strength','Free Weights','Flexibility','Other'];
            $cur  = $edit['category'] ?? '';
            foreach($cats as $c){
              $sel = ($cur === $c) ? 'selected' : '';
              echo "<option $sel value=\"".safe($c)."\">".safe($c)."</option>";
            }
            ?>
          </select>
        </div>
 
         <div class="col-md-6">
          <label class="form-label">Price (₹)</label>
          <input type="number" step="0.01" min="0" name="price" class="form-control" value="<?= safe($edit['price'] ?? '0') ?>">
        </div>

        <div class="col-md-6">
          <label class="form-label">Quantity</label>
          <input type="number" min="0" name="quantity" class="form-control" value="<?= safe($edit['quantity'] ?? '0') ?>" required>
        </div>

        <div class="col-md-4">
          <label class="form-label">Purchase Date</label>
          <input type="date" name="purchase_date" class="form-control" value="<?= safe($edit['purchase_date'] ?? '') ?>">
        </div>

        <div class="col-md-4">
          <label class="form-label">Condition</label>
          <select name="condition_status" class="form-select" required>
            <?php
              $conds = ['Active','Inactive','Maintenance'];
              $curc  = $edit['condition_status'] ?? 'Active';
              foreach($conds as $cs){
                $sel = ($curc === $cs) ? 'selected' : '';
                echo "<option $sel value=\"$cs\">$cs</option>";
              }
            ?>
          </select>
        </div>

        <div class="col-md-4">
          <label class="form-label">Image (Optional)</label>
          <input type="file" name="image" class="form-control" accept="image/*">
          <?php if (!empty($edit['image'])): ?>
            <img src="../uploads/<?= safe($edit['image']) ?>" width="80" class="mt-2 rounded">
          <?php endif; ?>
        </div>

        <div class="col-12 text-center mt-4">
          <button type="submit" name="<?= $edit ? 'update_equipment' : 'add_equipment' ?>" class="btn btn-primary px-5">
            <?= $edit ? 'Update Equipment' : 'Add Equipment' ?>
          </button>
          <?php if ($edit): ?>
            <a href="manage_equipment.php" class="btn btn-secondary">Cancel</a>
          <?php endif; ?>
        </div>
    
      </form>
    </div>
  </div>
  <hr class="my-5 text-light">
</div>

  

  <!-- Equipment List -->
  <h3 id="equipment" class="page-title text-center mb-3">EQUIPMENT LIST</h3>

  <div class="container-fluid my-4">
    <div class="row">
    
    <?php if ($list && mysqli_num_rows($list) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($list)): ?>

          <div class="col-md-3 mb-4 d-flex justify-content-center">
    
          <div class="card trainer-card h-100">
            <?php if (!empty($row['image'])): ?>
                <img src="../uploads/<?= safe($row['image']) ?>" alt="<?= safe($row['name']) ?>">
              <?php else: ?>
                <img src="https://via.placeholder.com/150?text=No+Image" alt="No Image">
              <?php endif; ?>
    
              <div class="card-body">
                <h5 class="card-title text-center"><?= safe($row['name']) ?></h5>
                <p class="card-text"><strong>Category:</strong> <?= safe($row['category']) ?></p>
                <p class="card-text"><strong>Quantity:</strong> <?= (int)$row['quantity'] ?></p>
                <p class="card-text"><strong>Price:</strong> ₹<?= number_format((float)$row['price'], 2) ?></p>
                <p class="card-text"><strong>Purchased:</strong> <?= safe($row['purchase_date']) ?: '—' ?></p>
                <p class="card-text"><strong>Status:</strong>
                  <span class="<?= $row['condition_status']=='Active' ? 'text-success fw-bold' : ($row['condition_status']=='Maintenance' ? 'text-warning fw-bold' : 'text-danger fw-bold') ?>">
                    <?= $row['condition_status'] ?>
                  </span>
                </p>
    
                <div class="d-flex justify-content-center gap-2 mt-1 mb-2">
                  <a href="manage_equipment.php?edit=<?= (int)$row['id'] ?>" class="btn btn-warning px-4">Edit</a>
                  <a href="manage_equipment.php?delete=<?= (int)$row['id'] ?>" 
                     onclick="return confirm('Delete this equipment?')" 
                     class="btn btn-danger px-3">Delete</a>
                </div>
              </div>
            </div>
          </div>

     <?php endwhile; ?>
      <?php else: ?>
        <div class="alert alert-dark">No equipment found. Add your first item above.</div>
      <?php endif; ?>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
