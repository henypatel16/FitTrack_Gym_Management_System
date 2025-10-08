<?php  
session_start();  
include('../config.php');  

if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    $class_id = intval($_POST['class_id']);  
    $name     = mysqli_real_escape_string($conn, $_POST['name']);  
    $email    = mysqli_real_escape_string($conn, $_POST['email']);  
    $phone    = mysqli_real_escape_string($conn, $_POST['phone']);  
    $status   = "Pending";  

    $sql = "INSERT INTO class_join (class_id, Name, email, phone, status, joined_at)  
            VALUES ('$class_id', '$name', '$email', '$phone', '$status', NOW())";  

    if (mysqli_query($conn, $sql)) {  
        $_SESSION['join_id'] = mysqli_insert_id($conn);  
        header("Location: join_process.php");  
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
    <title>Class Join Status</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">  
    <link rel="stylesheet" href="../css/join_process.css">  
</head>  
<body>  

<?php include 'user_header.php'; ?>  

<div class="container my-5 pt-3">  
    <?php  
       if (isset($_SESSION['join_id'])) {  
            $id = $_SESSION['join_id'];  
            $result = mysqli_query($conn, "SELECT cj.*, c.title, c.date, c.time 
                                           FROM class_join cj 
                                           JOIN classes c ON cj.class_id = c.id 
                                           WHERE cj.id = $id");  
            if (mysqli_num_rows($result) > 0) {  
                $data = mysqli_fetch_assoc($result);  
    ?>  
        <div class="card shadow p-4 mb-5">  
            <h3 class="text-center mb-3">BOOKING STATUS</h3>  
            <p><strong>Name:</strong> <?= htmlspecialchars($data['Name']); ?></p>  
            <p><strong>Class:</strong> <?= htmlspecialchars($data['title']); ?></p>  
            <p><strong>Date & Time:</strong> <?= $data['date'] . " at " . $data['time']; ?></p>  
            <p><strong>Booking Status:</strong>  
                <?php  
                    if ($data['status'] == "Pending") {  
                        echo '<span class="badge bg-warning text-dark">Pending</span>';  
                    } elseif ($data['status'] == "Confirmed") {  
                        echo '<span class="badge bg-success">Confirmed</span>';  
                    } else {  
                        echo '<span class="badge bg-danger">Cancelled</span>';  
                    }  
                ?>  
            </p>  
            <a href="classes.php" class="btn btn-primary mt-3">Back to Classes</a>  
        </div>  
    <?php  
            }  
        }  
    ?>  

    <hr class="my-4">  
    <h4 class="text-center mb-4">YOUR CLASS JOIN HISTORY</h4>  
    <?php  
    if (isset($data['email'])) {  
        $email = $data['email'];  
        $history_result = mysqli_query($conn, "SELECT cj.*, c.title, c.date, c.time  
                                               FROM class_join cj  
                                               JOIN classes c ON cj.class_id = c.id  
                                               WHERE cj.email = '$email'  
                                               ORDER BY cj.joined_at DESC");  

        if (mysqli_num_rows($history_result) > 0) {  
            echo '<div class="table-responsive text-center"><table class="table table-bordered table-hover">';  
            echo '<thead class="table-dark">  
                    <tr>  
                      <th>#</th>  
                      <th>Class</th>  
                      <th>Date & Time</th>  
                      <th>Booking Status</th>  
                      <th>Joined On</th>  
                    </tr>  
                  </thead><tbody>';  

            $i = 1;  
            while ($row = mysqli_fetch_assoc($history_result)) {  
                echo '<tr>';  
                echo '<td>' . $i++ . '</td>';  
                echo '<td>' . htmlspecialchars($row['title']) . '</td>';  
                echo '<td>' . $row['date'] . ' at ' . $row['time'] . '</td>';  
                echo '<td>';  
                if ($row['status'] == 'Confirmed') {  
                    echo '<span class="badge bg-success">Confirmed</span>';  
                } elseif ($row['status'] == 'Pending') {  
                    echo '<span class="badge bg-warning text-dark">Pending</span>';  
                } else {  
                    echo '<span class="badge bg-danger">Cancelled</span>';  
                }  
                echo '</td>';  
                echo '<td>' . $row['joined_at'] . '</td>';  
                echo '</tr>';  
            }  

            echo '</tbody></table></div>';  
        } else {  
            echo '<div class="alert alert-info">No previous classes joined.</div>';  
        }  
    }  
    ?>     
</div>  

<?php include 'user_footer.php'; ?>  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>  
</body>  
</html>