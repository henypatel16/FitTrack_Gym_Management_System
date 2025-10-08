<?php
session_start();
include '../config.php';

$searchTerm = "";
$results = [];

if (isset($_GET['q'])) {
    $searchTerm = trim($_GET['q']);

    if ($searchTerm != "") {
        // Membership search
        $sql_membership = "SELECT id, title AS name, description, price, duration, 'Membership' AS type 
                           FROM memberships 
                           WHERE title LIKE '%$searchTerm%' OR description LIKE '%$searchTerm%'";
        $res1 = $conn->query($sql_membership);

        // Classes search
        $sql_classes = "SELECT id, title AS name, trainer, date, time, image, capacity, 'Class' AS type 
                        FROM classes 
                        WHERE title LIKE '%$searchTerm%' OR trainer LIKE '%$searchTerm%'";
        $res2 = $conn->query($sql_classes);

        // Trainers search
        $sql_trainers = "SELECT id, name, specialization, experience, availability, email, contact, 'Trainer' AS type 
                         FROM trainers 
                         WHERE name LIKE '%$searchTerm%' OR specialization LIKE '%$searchTerm%'";
        $res3 = $conn->query($sql_trainers);

        // Equipment search
        $sql_equipment = "SELECT id, name, category as description, image, 'Equipment' AS type 
                          FROM equipment 
                          WHERE name LIKE '%$searchTerm%' OR category LIKE '%$searchTerm%'";
        $res4 = $conn->query($sql_equipment);

        // Merge all results
        if ($res1) { while($row = $res1->fetch_assoc()) $results[] = $row; }
        if ($res2) { while($row = $res2->fetch_assoc()) $results[] = $row; }
        if ($res3) { while($row = $res3->fetch_assoc()) $results[] = $row; }
        if ($res4) { while($row = $res4->fetch_assoc()) $results[] = $row; }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/search.css">
</head>

<body class="dark-theme">
<?php include 'user_header.php'; ?>
    
<div class="container mt-5">
    <h2 class="page-title mb-4"><i class="bi bi-search"></i> SEARCH</h2>

    <form method="get" action="search.php" class="mb-5 search-box d-flex">
        <input type="text" name="q" class="form-control me-2" placeholder="Search for classes, trainers name, memberships, dumbbell..." value="<?= htmlspecialchars($searchTerm) ?>">
        <button type="submit" class="btn btn-search"><i class="bi bi-search"></i></button>
    </form>

    <?php if ($searchTerm != ""): ?>
        <h4 class="mb-3">Results for: <span class="highlight"><?= htmlspecialchars($searchTerm) ?></span></h4>

        <div class="row mt-3">
            <?php if (count($results) > 0): ?>
                <?php foreach($results as $row): ?>
                    <div class="col-md-4">

                        <div class="result-card mb-4">
                            <?php if (!empty($row['image'])): ?>
                                <img src="../uploads/<?= $row['image']; ?>" class="card-img-top result-img" alt="<?= $row['name']; ?>">
                            <?php else: ?>
                                    
                            <?php endif; ?>

                            <div class="card-body px-2 g-2">
                                <h5 class="card-title mt-3 mb-2 text-center"><?= $row['name']; ?></h5>


                                <?php if ($row['type'] == "Membership"): ?>
                                    <p><?= $row['description']; ?></p>
                                    <p><strong>Price:</strong> ₹<?= $row['price']; ?> | <strong>Duration:</strong> <?= $row['duration']; ?></p>
                                    <a href="membership.php?id=<?= $row['id']; ?>" class="btn btn-details">View Details</a>


                                <?php elseif ($row['type'] == "Class"): ?>
                                    <p><strong>Trainer:</strong> <?= $row['trainer']; ?></p>
                                    <p><strong>Date:</strong> <?= $row['date']; ?> | <strong>Time:</strong> <?= $row['time']; ?></p>
                                    <p><strong>Capacity:</strong> <?= $row['capacity']; ?></p>
                                    <a href="classes.php?id=<?= $row['id']; ?>" class="btn btn-details">View Details</a>


                                <?php elseif ($row['type'] == "Trainer"): ?>
                                    <p><strong>Specialization:</strong> <?= $row['specialization']; ?></p>
                                    <p><strong>Experience:</strong> <?= $row['experience']; ?> years</p>
                                    <p><strong>Availability:</strong> <?= $row['availability']; ?></p>
                                    <p><strong>Email:</strong> <?= $row['email']; ?></p>
                                    <p><strong>Contact:</strong> <?= $row['contact']; ?></p>
                                    <a href="trainer.php?id=<?= $row['id']; ?>" class="btn btn-details">View Details</a>


                                <?php elseif ($row['type'] == "Equipment"): ?>
                                    <p><strong>Category:</strong> <?= $row['description']; ?></p>
                                    <a href="equipment.php?id=<?= $row['id']; ?>" class="btn btn-details">View Details</a>

                                <?php endif; ?>
                                <p><span class="badge bg-info mt-2"><?= $row['type']; ?></span></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-results">No results found.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'user_footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
