<?php
@include '../config.php';

//  Add Attendance
if (isset($_POST['add_attendance'])) {
    $member_id = $_POST['member_id'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    // Prevent duplicate entry for same date
    $check = $conn->prepare("SELECT * FROM attendance WHERE member_id=? AND date=?");
    $check->bind_param("is", $member_id, $date);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO attendance (member_id, date, status) VALUES (?,?,?)");
        $stmt->bind_param("iss", $member_id, $date, $status);
        $stmt->execute();
    }
    header("Location: manage_attendance.php#attendance");
    exit();
}

// Delete Attendance
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM attendance WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: manage_attendance.php");
    exit();
}

//  Update Attendance
if (isset($_POST['update_attendance'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE attendance SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    header("Location: manage_attendance.php");
    exit();
}

// Fetch Members 
$members = $conn->query("SELECT id, name FROM members");

//  Fetch Attendance
$attendance = $conn->query("SELECT a.id, m.name, a.date, a.status 
                            FROM attendance a 
                            JOIN members m ON a.member_id=m.id 
                            ORDER BY a.date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Attendance</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">  
    <link href="../css/manage_attendance.css" rel="stylesheet">
</head>

<body class="dark-theme">
<?php @include 'admin_header.php'; ?>

<div class="container mt-4">
    <h2 class="page-title text-center">MANAGE ATTENDANCE</h2>

    <!-- Add Attendance Form -->
    <div class="card form-card shadow-lg mt-3">
        <div class="card-body">
            <form method="POST" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Select Member</label>
                    <select name="member_id" class="form-select" required>
                        <option value="">-- Select Member --</option>
                        <?php while ($row = $members->fetch_assoc()) { ?>
                            <option value="<?= $row['id']; ?>"><?= $row['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="Present">Present</option>
                        <option value="Absent">Absent</option>
                    </select>
                </div>
                <div class="col-12 text-center mt-4 mb-2">
                    <button type="submit" name="add_attendance" class="btn btn-primary">Add Attendance</button>
                </div>
            </form>
        </div>
    </div>

    <hr class="my-5 text-light">

    <!-- Attendance Records -->
    <h3 id="attendance" class="page-title text-center mb-4">ATTENDANCE LIST</h3>
    <div class="table-responsive">
        <table class="table table-dark table-bordered table-hover align-middle text-center">
            <thead>
                <tr>
                    <th>Member Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $attendance->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['date']; ?></td>
                        <td>
                            <span class="badge <?= $row['status']=='Present' ? 'bg-success' : 'bg-danger' ?>">
                                <?= $row['status']; ?>
                            </span>
                        </td>
                        <td>
        
                        <!-- Edit Form -->
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                <select name="status" class="form-select form-select-sm d-inline w-auto">
                                    <option value="Present" <?= ($row['status'] == 'Present') ? 'selected' : ''; ?>>Present</option>
                                    <option value="Absent" <?= ($row['status'] == 'Absent') ? 'selected' : ''; ?>>Absent</option>
                                </select>
                                <button type="submit" name="update_attendance" class="btn btn-sm btn-warning">Update</button>
                            </form>

                        <!-- delete button -->
                            <a href="manage_attendance.php?delete=<?= $row['id']; ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Are you sure to delete this record?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
