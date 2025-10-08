<?php
session_start();
@include '../config.php';

// ---- Total Earnings ----
$total_earning = 0;
$earning_query = mysqli_query(
    $conn,
    "SELECT SUM(m.price) AS total 
     FROM enrollments e 
     JOIN memberships m ON TRIM(e.plan) = TRIM(m.title) 
     WHERE e.status = 'Paid'"
);
$fetch_earning = mysqli_fetch_assoc($earning_query);
if ($fetch_earning['total']) {
    $total_earning = $fetch_earning['total'];
}

// ---- Class Bookings ----
$booking_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM class_join");
$bookings = mysqli_fetch_assoc($booking_query)['total'] ?? 0;

// ---- Pending Payments ----
$pending_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM enrollments WHERE status='Pending'");
$pending = mysqli_fetch_assoc($pending_query)['total'] ?? 0;

// ---- Members per Plan (Graph Data) ----
$plans = [];
$plan_counts = [];
$plan_query = mysqli_query(
    $conn,
    "SELECT m.title, COUNT(e.id) AS total 
     FROM memberships m 
     LEFT JOIN enrollments e ON TRIM(e.plan) = TRIM(m.title) 
     GROUP BY m.title"
);
while ($row = mysqli_fetch_assoc($plan_query)) {
    $plans[] = $row['title'];
    $plan_counts[] = $row['total'];
}

// ---- Monthly Earnings (Graph Data) ----
$months = [];
$earnings = [];
$month_query = mysqli_query(
    $conn,
    "SELECT DATE_FORMAT(e.enrolled_on, '%M') AS month, 
            SUM(m.price) AS total 
     FROM enrollments e 
     JOIN memberships m ON TRIM(e.plan) = TRIM(m.title) 
     WHERE e.status = 'Paid' 
     GROUP BY DATE_FORMAT(e.enrolled_on, '%M'), MONTH(e.enrolled_on) 
     ORDER BY MONTH(e.enrolled_on)"
);
while ($row = mysqli_fetch_assoc($month_query)) {
    $months[] = $row['month'];
    $earnings[] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link href="../css/admin_home.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="dark-theme">

<?php @include ('admin_header.php'); ?>

<div class="container dashboard">
  <h1 class="dashboard-title text-center">Admin Dashboard</h1>
  
  <div class="row g-4">
    
    <!-- Class Bookings -->
    <div class="col-md-4">
      <a href="admin_booking.php" class="card-link">
        <div class="dashboard-card text-center">
          <i class="bi bi-house card-icon"></i>
          <h5><?= $bookings; ?></h5>
          <p>Class Bookings</p>
        </div>
      </a>
    </div>

    <!-- Earnings -->
    <div class="col-md-4">
      <a href="admin_earning.php" class="card-link">
        <div class="dashboard-card text-center">
          <i class="bi bi-bar-chart-line card-icon"></i>
          <h5>₹<?= $total_earning; ?></h5>
          <p>Total Earnings</p>
        </div>
      </a>
    </div>

    <!-- Pending Payments -->
    <div class="col-md-4">
     <a href="admin_earning.php" class="card-link">
      <div class="dashboard-card text-center pending-card">
        <i class="bi bi-cash-coin card-icon"></i>
        <h5><?= $pending; ?></h5>
        <p>Pending Payments</p>
      </div>
      </a>
    </div>

  </div>

  <!-- Graphs Section -->
  <div class="row mt-4">
    <div class="col-md-6">
      <div class="card p-3" style="background-color: #2c2c2c; color: #ff6600;">
        <h5 class="text-center">Members per Plan</h5>
        <canvas id="planChart"></canvas>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card p-3" style="background-color: #2c2c2c; color: #ff6600;">
        <h5 class="text-center">Monthly Earnings</h5>
        <canvas id="earningChart"></canvas>
      </div>
    </div>
  </div>

</div> 

<script>
  // Dark background plugin
  const darkBackground = {
    id: 'darkBackground',
    beforeDraw: (chart) => {
      const ctx = chart.ctx;
      ctx.save();
      ctx.fillStyle = '#1e1e1e'; 
      ctx.fillRect(0, 0, chart.width, chart.height);
      ctx.restore();
    }
  };

  // Members per Plan
  const planCtx = document.getElementById('planChart').getContext('2d');
  new Chart(planCtx, {
    type: 'bar',
    data: {
      labels: <?= json_encode($plans); ?>,
      datasets: [{
        label: 'Members',
        data: <?= json_encode($plan_counts); ?>,
        backgroundColor: 'rgba(54, 162, 235, 0.7)'
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { labels: { color: '#e0e0e0' } }
      },
      scales: {
        x: {
          ticks: { color: '#e0e0e0' },
          grid: { color: 'rgba(255,255,255,0.1)' }
        },
        y: {
          ticks: { color: '#e0e0e0' },
          grid: { color: 'rgba(255,255,255,0.1)' }
        }
      }
    },
    plugins: [darkBackground]
  });

  // Monthly Earnings
  const earningCtx = document.getElementById('earningChart').getContext('2d');
  new Chart(earningCtx, {
    type: 'bar', 
    data: {
      labels: <?= json_encode($months); ?>,
      datasets: [{
        label: 'Earnings (₹)',
        data: <?= json_encode($earnings); ?>,
        backgroundColor: 'rgba(255, 99, 132, 0.7)'
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { labels: { color: '#e0e0e0' } }
      },
      scales: {
        x: {
          ticks: { color: '#e0e0e0' },
          grid: { color: 'rgba(255,255,255,0.1)' },
          barPercentage: 0.5,      
          categoryPercentage: 0.5 
        },
        y: {
          ticks: { color: '#e0e0e0' },
          grid: { color: 'rgba(255,255,255,0.1)' }
        }
      }
    },
    plugins: [darkBackground]
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>