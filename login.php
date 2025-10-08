<?php
@include 'config.php';
session_start();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check user in users table
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if ($password === $row['password']) {
            
            // If admin login
            if ($row['role'] === 'admin') {
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_username'] = $row['username'];
                $_SESSION['admin_role'] = $row['role'];

                header('Location: admin/admin_home.php');
                exit();

            } else { 
                // If user login
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_username'] = $row['username'];
                $_SESSION['user_role'] = $row['role'];

                //  Fetch member info using username match
                $member_result = mysqli_query($conn, "SELECT id, name FROM members WHERE name='".$row['username']."' LIMIT 1");
                if(mysqli_num_rows($member_result) > 0){
                    $member = mysqli_fetch_assoc($member_result);
                    $_SESSION['member_id'] = $member['id'];
                    $_SESSION['member_name'] = $member['name'];
                }

                header('Location: user/home.php');
                exit();
            }

        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>FitTrack_gym - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
</head>
<body>

<div class="login-container"> 
   <img class="logo" src="img/logo.png" width="150" alt="FitTrack_gym">
   <div class="login-box text-center">
      <h2 class="my-3">Welcome!</h2>
      <form method="POST">
          <input type="text" name="username" class="form-control my-2" placeholder="Username" required>
          <input type="password" name="password" class="form-control my-2" placeholder="Password" required>
          
          <?php if (!empty($error)): ?>
              <div class="text-danger"><?= $error ?></div>
          <?php endif; ?>
          
          <button type="submit" class="btn btn-warning fw-bold w-100 mt-2">LOGIN</button>
          <p class="mt-3">Still don’t have an account? <a href="register.php" class="text-warning">Register now</a></p>
      </form>
   </div>
</div>
</body>
</html>