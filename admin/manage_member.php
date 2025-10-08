<?php
@include '../config.php'; 

// ADD MEMBER
if (isset($_POST['add_member'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $plan_id = $_POST['plan_id'];
    $start_date = $_POST['start_date'];
    $status = $_POST['status'];

    // Fetch plan duration
   $plan_sql = "SELECT duration FROM memberships WHERE id = $plan_id";
   $plan_result = mysqli_query($conn, $plan_sql);
   $plan = mysqli_fetch_assoc($plan_result);
   $duration = strtolower($plan['duration']);  

    // Calculate end_date
    $end_date = date('Y-m-d', strtotime("+$duration", strtotime($start_date)));
    
    $sql = "INSERT INTO members (name, email, phone, gender, plan_id, start_date, end_date, status) 
        VALUES ('$name', '$email', '$phone', '$gender', '$plan_id', '$start_date', '$end_date', 'Active')";
    mysqli_query($conn, $sql);

    header("Location: manage_member.php#members");
    exit;
}

// DELETE MEMBER
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM members WHERE id=$id";
    mysqli_query($conn, $sql);
    header("Location: manage_member.php");
    exit;
}

// EDIT MEMBER - fetch details
$edit_member = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit_member = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM members WHERE id=$id"));
}

// UPDATE MEMBER
if (isset($_POST['update_member'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $plan_id = $_POST['plan_id'];
    $start_date = $_POST['start_date'];
    $status = $_POST['status'];

// Fetch plan duration
   $plan_sql = "SELECT duration FROM memberships WHERE id = $plan_id";
   $plan_result = mysqli_query($conn, $plan_sql);
   $plan = mysqli_fetch_assoc($plan_result);
   $duration = strtolower($plan['duration']);  

// Recalculate end_date
    $end_date = date('Y-m-d', strtotime("+$duration", strtotime($start_date)));
    

    $sql = "UPDATE members SET 
                name='$name',
                email='$email',
                phone='$phone',
                gender='$gender',
                plan_id='$plan_id',
                start_date='$start_date',
                end_date='$end_date',
                status='$status'
            WHERE id=$id";
    mysqli_query($conn, $sql);
    header("Location: manage_member.php#members");
    exit;
}

// FETCH ALL MEMBERS
$members = mysqli_query($conn, "SELECT members.*, memberships.title AS plan_name 
                                FROM members 
                                JOIN memberships ON members.plan_id = memberships.id 
                                ORDER BY members.id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Members</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">  
    <link href="../css/manage_member.css" rel="stylesheet">
</head>

<body class="dark-theme">
 <?php @include ('admin_header.php'); ?>

<div class="container mt-4">
    <h2 class="page-title text-center"><?= $edit_member ? "EDIT MEMBER" : "ADD NEW MEMBER" ?></h2>

    <!-- Add / Edit Member Form -->
    <div class="card form-card shadow-lg mt-3">
        <div class="card-body">
            <form method="POST" class="row g-3">
                <?php if ($edit_member): ?>
                    <input type="hidden" name="id" value="<?= $edit_member['id'] ?>">
                <?php endif; ?>

                <div class="col-md-6">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" 
                           value="<?= $edit_member['name'] ?? '' ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" 
                           value="<?= $edit_member['email'] ?? '' ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" 
                           value="<?= $edit_member['phone'] ?? '' ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select" required>
                        <option value="">Select Gender</option>
                        <option value="Male" <?= isset($edit_member['gender']) && $edit_member['gender']=='Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= isset($edit_member['gender']) && $edit_member['gender']=='Female' ? 'selected' : '' ?>>Female</option>
                        <option value="Other" <?= isset($edit_member['gender']) && $edit_member['gender']=='Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Membership Plan</label>
                    <select name="plan_id" class="form-select" required>
                        <option value="">Select Plan</option>
                        <?php
                        $plans = mysqli_query($conn, "SELECT * FROM memberships");
                        while ($plan = mysqli_fetch_assoc($plans)) {
                            $selected = ($edit_member && $edit_member['plan_id'] == $plan['id']) ? "selected" : "";
                            echo "<option value='".$plan['id']."' $selected>".$plan['title']." (₹".$plan['price'].")</option>";
                        }
                        ?>
                    </select>
                </div>

                 <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="Active" <?= isset($edit_member['status']) && $edit_member['status']=='Active' ? 'selected' : '' ?>>Active</option>
                        <option value="Inactive" <?= isset($edit_member['status']) && $edit_member['status']=='Inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" 
                           value="<?= $edit_member['start_date'] ?? '' ?>" required>
                </div>

              

                <div class="col-12 text-end text-center mt-4 mb-2">
                    <button type="submit" name="<?= $edit_member ? 'update_member' : 'add_member' ?>" class="btn btn-primary">
                        <?= $edit_member ? 'Update Member' : 'Add Member' ?>
                    </button>
                    <?php if ($edit_member): ?>
                        <a href="manage_member.php" class="btn btn-secondary">Cancel</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
 <hr class="my-5 text-light">

 <!-- Members Table -->
    <h3 id="members" class="mt-5 mb-3 page-title text-center">MEMBERS LIST</h3>
    <div class="table-responsive mt-4 mb-5">
        <table class="table table-dark table-bordered table-hover align-middle text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Plan</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($members)) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td><?= $row['gender'] ?></td>
                    <td><?= $row['plan_name'] ?></td>
                    <td><?= $row['start_date'] ?></td>
                    <td><?= $row['end_date'] ?></td>
                    <td>
                        <span class="badge <?= $row['status']=='Active' ? 'bg-success' : 'bg-danger' ?>">
                            <?= $row['status'] ?>
                        </span>
                    </td>
                    <td>
                        <a href="manage_member.php?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning px-3">Edit</a>
                        <a href="manage_member.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this member?');" 
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
