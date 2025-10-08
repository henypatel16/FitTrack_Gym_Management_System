<?php
session_start();
@include '../config.php';

//  ADD / UPDATE 
if (isset($_POST['save'])) {
    $id = $_POST['id'] ?? '';
    $type = $_POST['type'];
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $duration = $_POST['duration'];
    $member_id = $_POST['member_id'];

    if ($id == '') {
        $sql = "INSERT INTO plans (type, title, description, duration, member_id) 
                VALUES ('$type','$title','$desc','$duration','$member_id')";
    } else {
        $sql = "UPDATE plans SET 
                    type='$type', 
                    title='$title', 
                    description='$desc', 
                    duration='$duration', 
                    member_id='$member_id' 
                WHERE id='$id'";
    }
    mysqli_query($conn, $sql);
    header("Location: manage_workout_diet.php#diet");
    exit;
}

//  DELETE 
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM plans WHERE id='$id'");
    header("Location: manage_workout_diet.php");
    exit;
}

// EDIT 
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM plans WHERE id='$id'");
    $editData = mysqli_fetch_assoc($res);
}

//  FETCH ALL PLANS 
$plansRes = mysqli_query($conn, "SELECT p.*, m.name as member_name 
                                 FROM plans p 
                                 LEFT JOIN members m ON p.member_id=m.id 
                                 ORDER BY p.created_at DESC");

//  FETCH MEMBERS 
$membersRes = mysqli_query($conn, "SELECT * FROM members ORDER BY name ASC");
$members = [];
while ($row = mysqli_fetch_assoc($membersRes)) $members[] = $row;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Workout & Diet Plans</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">  
    <link href="../css/manage_workout_diet.css" rel="stylesheet">
</head>

<body class="dark-theme">
 <?php @include ('admin_header.php'); ?>

<div class="container mt-4">
    <h2 class="page-title text-center"><?= $editData ? "EDIT PLAN" : "ADD NEW PLAN" ?></h2>

    <!-- Add / Edit Plan Form -->
    <div class="card form-card shadow-lg mt-3">
        <div class="card-body">
            <form method="POST" class="row g-3">
                <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

                <div class="col-md-6">
                    <label class="form-label">Plan Type</label>
                    <select name="type" class="form-select" required>
                        <option value="workout" <?= isset($editData) && $editData['type']=='workout' ? 'selected':''; ?>>Workout</option>
                        <option value="diet" <?= isset($editData) && $editData['type']=='diet' ? 'selected':''; ?>>Diet</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" 
                           value="<?= $editData['title'] ?? '' ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Duration</label>
                    <input type="text" name="duration" class="form-control" 
                           value="<?= $editData['duration'] ?? '' ?>" placeholder="e.g., 4 Weeks">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Assign To (Member)</label>
                    <select name="member_id" class="form-select" required>
                        <option value="">-- Select Member --</option>
                        <?php foreach($members as $m): ?>
                            <option value="<?= $m['id'] ?>" <?= isset($editData) && $editData['member_id']==$m['id'] ? 'selected':''; ?>>
                                <?= $m['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control"><?= $editData['description'] ?? '' ?></textarea>
                </div>


                <div class="col-12 text-center mt-4 mb-2">
                    <button type="submit" name="save" class="btn btn-primary">
                        <?= $editData ? 'Update Plan' : 'Save Plan' ?>
                    </button>
                    <?php if ($editData): ?>
                        <a href="manage_workout_diet.php" class="btn btn-secondary">Cancel</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

 <hr class="my-5 text-light">

 <!-- Plans Table -->
    <h3 id="diet" class="mt-5 mb-3 page-title text-center">WORKOUT & DIET PLANS LIST</h3>

    <div class="table-responsive mt-4 mb-5">
        <table class="table table-dark  table-bordered table-hover align-middle text-center">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Duration</th>
                    <th>Assigned To</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($plan = mysqli_fetch_assoc($plansRes)) { ?>
                <tr>
                    <td><?= ucfirst($plan['type']) ?></td>
                    <td><?= $plan['title'] ?></td>
                    <td><?= $plan['description'] ?></td>
                    <td><?= $plan['duration'] ?: 'N/A' ?></td>
                    <td><?= $plan['member_name'] ?: 'Not Assigned' ?></td>
                    <td><?= $plan['created_at'] ?></td>
                    <td>
                        <a href="manage_workout_diet.php?edit=<?= $plan['id'] ?>" class="btn btn-sm btn-warning px-3">Edit</a>
                        <a href="manage_workout_diet.php?delete=<?= $plan['id'] ?>" onclick="return confirm('Delete this plan?');" 
                           class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"> </script>
</body>
</html>
