<?php  
session_start();  
include '../config.php';  

// if admin not login 
// if (!isset($_SESSION['admin_id'])) {  
//     header("Location: ../login.php");  
//     exit();  
// }  

// only admin can access this page 
// if ($_SESSION['role'] != 'admin') {  
//     header("Location: ../login.php");  
//     exit();  
// }  

$admin_id = $_SESSION['admin_id'];  

// fetch admin details 
$sql = "SELECT * FROM users WHERE id = '$admin_id' AND role = 'admin'";  
$result = $conn->query($sql);  
$admin = $result->fetch_assoc();  

// Profile update  
if (isset($_POST['update_profile'])) {  
    $username = trim($_POST['username']);  

    // Profile pic update  
    $profile_pic = $admin['profile_pic'];   
    if (!empty($_FILES['profile_pic']['name'])) {  
        $targetDir = "../images/";  
        if (!is_dir($targetDir)) {  
            mkdir($targetDir, 0777, true);  
        }  
        $fileName = time() . "_" . basename($_FILES["profile_pic"]["name"]);  
        $targetFilePath = $targetDir . $fileName;  
        move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetFilePath);  
        $profile_pic = $fileName;  
    }  

    $update_sql = "UPDATE users SET username='$username', profile_pic='$profile_pic' WHERE id='$admin_id'";  
    if ($conn->query($update_sql)) {  
        echo "<script>alert('Profile updated successfully!'); window.location='admin_profile.php';</script>";  
    } else {  
        echo "<script>alert('Error updating profile!');</script>";  
    }  
}  

// Password change  
if (isset($_POST['change_password'])) {  
    $current_pass = $_POST['current_password'];  
    $new_pass = $_POST['new_password'];  
    $confirm_pass = $_POST['confirm_password'];  

    if ($current_pass == $admin['password']) {   
        if ($new_pass == $confirm_pass) {  
            $update_pass_sql = "UPDATE users SET password='$new_pass' WHERE id='$admin_id'";  
            if ($conn->query($update_pass_sql)) {  
                echo "<script>alert('Password changed successfully!'); window.location='admin_profile.php';</script>";  
            } else {  
                echo "<script>alert('Error updating password!');</script>";  
            }  
        } else {  
            echo "<script>alert('New password and confirm password do not match!');</script>";  
        }  
    } else {  
        echo "<script>alert('Current password is incorrect!');</script>";  
    }  
}  

// Logout  
if (isset($_POST['logout'])) {  
    session_destroy();  
    header("Location: ../login.php");  
    exit();  
}  
?>  

<!DOCTYPE html>  
<html lang="en">  
<head>  
  <meta charset="UTF-8">  
  <title>Admin Profile</title>  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="../css/admin_profile.css" rel="stylesheet">
</head>  

<body>   
      <?php include 'admin_header.php'; ?>  

<div class="container mt-3 text-center">  
    <h2 class="mb-4 mt-4">ADMIN PROFILE</h2>  

    <!-- Profile Card -->  
    <div class="card profile-card p-4 mb-5">  
          
        <!-- Profile Image -->  
        <div class="text-center mb-4">  
            <img src="../images/<?= $admin['profile_pic'] ? $admin['profile_pic'] : 'default.png'; ?>"   
                 class="img-fluid rounded-circle shadow"   
                 style="width: 180px; height: 180px; object-fit: cover;">  
            <p class="mt-3"><span class="badge bg-danger"><?= ucfirst($admin['role']); ?></span></p>  
        </div>  

        <div class="row">  
            <!-- Update Profile -->  
            <div class="col-md-6 border-end">  
                <form method="post" enctype="multipart/form-data" class="text-start">  
                    <h4 class="text-warning"><i class="bi bi-person-lines-fill"></i> UPDATE PROFILE</h4>  
                    <div class="mb-3">  
                        <label class="form-label">Username</label>  
                        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($admin['username']); ?>" required>  
                    </div>  
                    <div class="mb-3">  
                        <label class="form-label">Profile Picture</label>  
                        <input type="file" name="profile_pic" class="form-control">  
                    </div>  
                    <div class="text-center gap-4 d-flex justify-content-center">  
                        <button type="submit" name="update_profile" class="btn btn-warning">  
                            <i class="bi bi-check-circle"></i> Save Changes  
                        </button>  
                        <button type="submit" name="logout" class="btn btn-danger">  
                            <i class="bi bi-box-arrow-right"></i> Logout  
                        </button>  
                    </div>  
                </form>  
            </div>  

            <!-- Change Password -->  
            <div class="col-md-6">  
                <form method="post" class="text-start">  
                    <h4 class="text-warning"><i class="bi bi-shield-lock"></i> CHANGE PASSWORD</h4>  
                    <div class="mb-3">  
                        <label class="form-label">Current Password</label>  
                        <input type="password" name="current_password" class="form-control" required>  
                    </div>  
                    <div class="mb-3">  
                        <label class="form-label">New Password</label>  
                        <input type="password" name="new_password" class="form-control" required>  
                    </div>  
                    <div class="mb-3">  
                        <label class="form-label">Confirm New Password</label>  
                        <input type="password" name="confirm_password" class="form-control" required>  
                    </div>  
                    <div class="text-center">  
                        <button type="submit" name="change_password" class="btn btn-warning">  
                            <i class="bi bi-lock-fill"></i> Change Password  
                        </button>  
                    </div>  
                </form>  
            </div>  
        </div>  
    </div>  
</div>  

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>  
</body>  
</html>
