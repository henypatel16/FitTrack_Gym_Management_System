<?php
include '../config.php'; 

$sql = "SELECT * FROM equipment";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Our Equipment</title>
  <link rel="stylesheet" href="../css/equipment.css"> 
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<?php include 'user_header.php'; ?>

<section class="equipment-section">
  <div class="container mb-5 mt-4">
    <h2 class="section-subtitle text-center">OUR EQUIPMENT</h2>
    <h3 class="section-title text-center mb-5">MODERN & PROFESSIONAL GEAR</h3>

    <div class="row">
      <?php
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              ?>
              <div class="col-md-4 mb-4">
                <div class="equipment-card">
                  <img src="../uploads/<?php echo $row['image']; ?>" alt="Equipment Image" class="equipment-img">
                  <h4><?php echo $row['name']; ?></h4>
                  <p><i class="fas fa-tag"></i><strong> Type:</strong> <?php echo $row['category']; ?></p>
                  <p><i class="fas fa-boxes"></i><strong> Quantity:</strong> <?php echo $row['quantity']; ?></p>
                </div>
              </div>
              <?php
          }
      } else {
          echo "<p class='text-center text-light'>No equipment available.</p>";
      }
      ?>
    </div>
  </div>
</section>


<?php include 'user_footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
