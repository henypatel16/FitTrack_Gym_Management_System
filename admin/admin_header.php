<style>
  body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-size: cover;
  
  }

  .navbar {
    background-color: #000;
    padding: 12px 15px;
  }

  .navbar-divider { 
    height: 40px;
    width: 1px;
    background-color: rgba(255, 255, 255, 0.3);
    margin-right: 20px;
  }

  .navbar-nav .nav-link {
    color: #fff;
    margin: 0 10px;
    text-transform: uppercase;
    font-weight: 500;
    font-size: 14px;
  }

  .navbar-nav .nav-link:hover,.navbar-nav .nav-link.active {
    color: #ff6600;
    border-bottom: 2px solid #ff6600;
  }

  .icon-buttons a {
    color: white;
    font-size: 18px;
    margin-left: 15px;
    text-decoration: none;
    border: none;
  }

  .icon-buttons a:hover {
    color: #ff6600;
  }

  .dropdown-menu {
    background-color: #000;
  }

  .dropdown-menu .dropdown-item {
    color: #fff;
  }

  .dropdown-menu .dropdown-item:hover {
    background-color: #222;
    color: #ff6600;
  }

  @media (max-width: 991px) {
    .navbar {
      padding: 15px;
    }

    .icon-buttons {
      margin-top: 10px;
      text-align: center;
    }
  }
</style>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#" style="font-size: 1.3em;">
      <span style="color: #ff6600;">FIT</span><span style="color: White;">TRACK</span><i class="fas fa-dumbbell" style="color: gray;"></i>
    </a>

    <span class="navbar-divider"></span>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="admin_home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_membership.php">Membership Plans</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_classes.php">Classes</a></li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="manageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Manage
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="manageDropdown">
            <li><a class="dropdown-item" href="manage_member.php">Manage Member</a></li>
            <li><a class="dropdown-item" href="manage_trainer.php">Manage Trainer</a></li>
            <li><a class="dropdown-item" href="manage_attendance.php">Manage Attendance</a></li>
            <li><a class="dropdown-item" href="manage_equipment.php">Manage Equipment</a></li>
            <li><a class="dropdown-item" href="manage_workout_diet.php">Workout/Diet Plan</a></li>
            <li><a class="dropdown-item" href="bmi_report.php">BMI Report</a></li>
          </ul>
        </li>
        
        <li class="nav-item"><a class="nav-link" href="admin_message.php">Message</a></li>
      </ul>

      <div class="icon-buttons d-flex align-items-center">
        <a href="admin_profile.php"><i class="bi bi-person-circle"></i></a>
      </div>
    </div>
  </div>
</nav>
