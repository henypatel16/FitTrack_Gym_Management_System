<?php
session_start();
include '../config.php';

// Agar user login nahi hai
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$resultMsg = "";

// --- Calculate & Insert BMI ---
if (isset($_POST['calculate'])) {
    $age = $_POST['age']; 
    $height = $_POST['height'];
    $weight = $_POST['weight'];

    if ($weight > 0 && $height > 0) {
        $bmi = $weight / (($height / 100) * ($height / 100));
        $bmi = round($bmi, 2);

        if ($bmi < 18.5) {
            $status = "Underweight";
        } elseif ($bmi >= 18.5 && $bmi < 24.9) {
            $status = "Healthy";
        } elseif ($bmi >= 25 && $bmi < 29.9) {
            $status = "Overweight";
        } else {
            $status = "Obese";
        }

        $resultMsg = "Your BMI is <b>$bmi</b>. You are <b>$status</b>.";

        $stmt = $conn->prepare("INSERT INTO bmi_records (user_id, age, height, weight, bmi, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("iiidd", $user_id, $age, $height, $weight, $bmi);
        $stmt->execute();
        $stmt->close();
    } else {
        $resultMsg = "Please enter valid values.";
    }
}

// --- Delete Record ---
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM bmi_records WHERE id=? AND user_id=?");
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: bmi.php");
    exit();
}

// --- Fetch All Records ---
$records = $conn->query("SELECT * FROM bmi_records WHERE user_id=$user_id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BMI Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/bmi.css"> 
</head>

<body>
<?php include 'user_header.php'; ?>

<section class="bmi-section">
  <div class="container mb-5 mt-4">

    <!-- Subtitle & Title -->
    <h2 class="section-subtitle text-center">CHECK YOUR BODY</h2>
    <h3 class="section-title text-center">BMI CALCULATOR</h3>
    <p class="text-center mb-5" style="color:#c8c6c6;">Calculate your BMI and track your progress towards a healthier lifestyle.</p>

    <div class="row">
      <!-- BMI CHART -->
      <div class="col-lg-6 mb-4">
        <div class="card-custom">
          <h4 class="mb-3 text-warning"><i class="fas fa-table"></i> BMI CHART</h4>
          <p style="color: #bbb;">Use this chart to understand your body mass index range.</p>
          <div class="table-responsive">
            <table class="table custom-table table-bordered text-center">
              <thead>
                <tr>
                  <th>BMI</th>
                  <th>WEIGHT STATUS</th>
                </tr>
              </thead>
              <tbody>
                <tr><td>Below 18.5</td><td>Underweight</td></tr>
                <tr><td>18.5 - 24.9</td><td>Healthy</td></tr>
                <tr><td>25.0 - 29.9</td><td>Overweight</td></tr>
                <tr><td>30.0 and Above</td><td>Obese</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- BMI CALCULATOR FORM -->
      <div class="col-lg-6 mb-4">
        <div class="card-custom">
          <h4 class="mb-3 text-warning"><i class="fas fa-calculator"></i> CALCULATE YOUR BMI</h4>
          <p>Enter your age, height and weight to calculate your BMI instantly.</p>
          <form method="POST">
            <div class="row mb-3">
              <div class="col-sm-6 mb-2">
                <input type="number" name="age" class="form-control" placeholder="Age" min="0" required>
              </div>
              <div class="col-sm-6 mb-2">
                <input type="number" name="height" class="form-control" placeholder="Height / cm" min="0" required>
              </div>
              <div class="col-sm-6 mb-2">
                <input type="number" name="weight" class="form-control" placeholder="Weight / kg" min="0" required>
              </div>
            </div>
            <div class="text-center">
            <button type="submit" name="calculate" class="btn btn-warning px-4">Calculate</button></div>
          </form>

          <?php if ($resultMsg != "") { ?>
            <div class="mt-3 alert alert-dark text-warning text-center"><?= $resultMsg; ?></div>
          <?php } ?>
        </div>
      </div>
    </div>

    <!-- BMI RECORDS -->
    <div class="mt-5">
      <h3 class="section-title text-center mb-4">YOUR BMI RECORDS</h3>
      <div class="card-custom">
        <div class="table-responsive">
          <table class="table custom-table table-bordered text-center">
            <thead>
              <tr>
                <th><i class="fas fa-id-card"></i> AGE</th>
                <th><i class="fas fa-ruler-vertical"></i> HEIGHT (CM)</th>
                <th><i class="fas fa-weight"></i> WEIGHT (KG)</th>
                <th><i class="fas fa-heartbeat"></i> BMI</th>
                <th><i class="fas fa-calendar-alt"></i> DATE</th>
                <th><i class="fas fa-check-circle"></i> ACTION</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($records->num_rows > 0) { 
                while ($row = $records->fetch_assoc()) { ?>
                  <tr>
                    <td><?= $row['age'] ?></td>
                    <td><?= $row['height'] ?></td>
                    <td><?= $row['weight'] ?></td>
                    <td><?= $row['bmi'] ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                      <a href="bmi.php?delete=<?= $row['id'] ?>" 
                         onclick="return confirm('Delete this record?')" 
                         class="btn btn-danger btn-sm">Delete</a>
                    </td>
                  </tr>
              <?php } } else { ?>
                <tr><td colspan="6" style="color:#ff9900;">No records found.</td></tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</section>

<?php include 'user_footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
