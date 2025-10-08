<?php
@include '../config.php';
session_start();

// Delete message
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM contact_messages WHERE id = $id") or die("Query failed");
    header("Location: admin_message.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Messages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">  
    <link rel="stylesheet" href="../css/admin_message.css">
</head>
<body>

<?php include 'admin_header.php'; ?>

<div class="container mt-4">
    <h2 class="text-center mb-4" style="color: #ff6600;">USER MESSAGES</h2>

    <div class="table-responsive">
        <table class="table table-dark table-bordered table-hover text-center custom-table">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($conn, "SELECT * FROM contact_messages ORDER BY id DESC") or die("Query failed");
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td>
                        <a href="admin_message.php?delete=<?php echo $row['id']; ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Are you sure you want to delete this message?');">
                           Delete
                        </a>
                    </td>
                </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="6" class="text-center text-muted">No messages found</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"> </script>
</body>
</html>
