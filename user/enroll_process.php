<?php  
session_start();  
include('../config.php');  

if (isset($_POST['enroll'])) {  
    $name = $_POST['name'];  
    $email = $_POST['email'];  
    $phone = $_POST['phone'];  
    $plan = $_POST['plan'];  
    $payment_method = $_POST['payment_method'];  
    $status = "Pending"; 

    $sql = "INSERT INTO enrollments (name, email, phone, plan, payment_method, status)  
            VALUES ('$name', '$email', '$phone', '$plan', '$payment_method', '$status')";  

    if (mysqli_query($conn, $sql)) {  
        $_SESSION['enroll_id'] = mysqli_insert_id($conn);
        header("Location: enroll_process.php"); 
        exit();  
    } else {  
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";  
    }  
}  
?>

<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Status</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/enroll_process.css">
</head>  

<body>
    <?php include 'user_header.php'; ?> 

    <div class="container my-5 pt-5">  
        <?php  
           if (isset($_SESSION['enroll_id'])) {  
                $id = $_SESSION['enroll_id'];  
                $result = mysqli_query($conn, "SELECT * FROM enrollments WHERE id = $id");  
                if (mysqli_num_rows($result) > 0) {  
                    $data = mysqli_fetch_assoc($result);  
        ?>  
            <div class="card shadow p-4 mb-5">  
                <h3 class="text-center mb-3">ENROLLMENT STATUS</h3>  
                <p><strong>Name:</strong> <?php echo htmlspecialchars($data['name']); ?></p>  
                <p><strong>Plan:</strong> <?php echo htmlspecialchars($data['plan']); ?></p>  
                <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($data['payment_method']); ?></p>  
                <p><strong>Status:</strong>  
                    <?php  
                        if ($data['status'] == "Pending") {  
                            echo '<span class="badge bg-warning text-dark">Pending</span>';  
                        } elseif ($data['status'] == "Paid") {  
                            echo '<span class="badge bg-success">Paid</span>';  
                        } else {  
                            echo '<span class="badge bg-danger">Cancelled</span>';  
                        }  
                    ?>  
                </p>  
                <a href="membership.php" class="btn btn-primary mt-3"> Back to Memberships</a>  
            </div>  
        <?php  
                }  
            }  
        ?>

        <hr class="my-4">
        <h4 class="text-center mb-4">YOUR ENROLLMENT HISTORY</h4>
        <?php
        if (isset($data['email'])) {
            $email = $data['email'];
            $history_result = mysqli_query($conn, "SELECT * FROM enrollments WHERE email = '$email' ORDER BY enrolled_on DESC");

            if (mysqli_num_rows($history_result) > 0) {
                echo '<div class="table-responsive text-center"><table class="table table-bordered table-hover">';
                echo '<thead class="table-dark">
                        <tr>
                          <th>#</th>
                          <th>Plan</th>
                          <th>Payment Method</th>
                          <th>Status</th>
                          <th>Enrolled On</th>
                        </tr>
                      </thead><tbody>';

                $i = 1;
                while ($row = mysqli_fetch_assoc($history_result)) {
                    echo '<tr>';
                    echo '<td>' . $i++ . '</td>';
                    echo '<td>' . htmlspecialchars($row['plan']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['payment_method']) . '</td>';
                    echo '<td>';
                    if ($row['status'] == 'Paid') {
                        echo '<span class="badge bg-success">Paid</span>';
                    } elseif ($row['status'] == 'Pending') {
                        echo '<span class="badge bg-warning text-dark">Pending</span>';
                    } else {
                        echo '<span class="badge bg-danger">Cancelled</span>';
                    }
                    echo '</td>';
                    echo '<td>' . $row['enrolled_on'] . '</td>';
                    echo '</tr>';
                }

                echo '</tbody></table></div>';
            } else {
                echo '<div class="alert alert-info">No previous enrollments found.</div>';
            }
        }
        ?>     
    </div>

    <?php include 'user_footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>  
</html>
