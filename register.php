<?php
@include 'config.php';
session_start();

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $profile_pic = $_FILES['profile_pic'] ?? null;

    if ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        $check_stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "Username already exists!";
        } else {
            $target_dir = "images/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $profile_pic_name = time() . '_' . basename($profile_pic['name']);
            $target_file = $target_dir . $profile_pic_name;

            if (move_uploaded_file($profile_pic['tmp_name'], $target_file)) {
                $role = 'user';
                $insert_stmt = $conn->prepare("INSERT INTO users (username, password, profile_pic, role) VALUES (?, ?, ?, ?)");
                $insert_stmt->bind_param("ssss", $username, $password, $profile_pic_name, $role);

                if ($insert_stmt->execute()) {
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $role;
                    header('Location: user/home.php');
                    exit();
                } else {
                    $message = "Registration failed!";
                }
            } else {
                $message = "Failed to upload profile picture!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>FitTrack_gym - Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/register.css" rel="stylesheet">
</head>
<body>
<div class="register-contrainer">
    <img class="logo" src="img/logo.png" width="150" alt="FitTrack_gym">
    <div class="register-box text-center">
        <h2 class="my-3">Create Account</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="username" class="form-control my-2" placeholder="Username" required>
            <input type="password" name="password" class="form-control my-2" placeholder="Password" required>
            <input type="password" name="confirm_password" class="form-control my-2" placeholder="Confirm Password" required>
            <input type="file" name="profile_pic" class="form-control my-2 text-white" required>

            <?php if (!empty($message)): ?>
                <div class="text-danger"><?= $message ?></div>
            <?php endif; ?>

            <button type="submit" class="btn btn-warning fw-bold w-100 mt-2">REGISTER</button>
            <p class="mt-3">Already Have An Account? <a href="login.php" class="text-warning">Login Now</a></p>
        </form>
    </div>
</div>
</body>
</html>