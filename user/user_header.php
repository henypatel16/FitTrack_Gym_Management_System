<?php
//  session_start(); 
 @include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FitTrack - header</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
        .navbar-nav .nav-link:hover, .navbar-nav .nav-link.active {
            color: #ff6600;
            border-bottom: 2px solid #ff6600;
        }
        .icon-buttons a {
            color: white;
            font-size: 18px;
            margin-left: 15px;
            text-decoration: none !important;
            border: none !important;
        }
        .icon-buttons a:hover {
            color: #ff6600;
        }
        @media (max-width: 991px) {
            .navbar {
                padding: 15px;
            }
            .icon-buttons {
                margin-top: 10px;
                text-align: center;
                margin-right: 30px;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
  <a class="navbar-brand fw-bold" href="#" style="font-size: 1.3em;">
    <span style="color: #ff6600;">FIT</span><span style="color: White;">TRACK</span><i class="fas fa-dumbbell" style="color:gray;"></i>
  </a>

  <span class="navbar-divider"></span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="mainNavbar">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="membership.php">Membership</a></li>
                <li class="nav-item"><a class="nav-link" href="classes.php">Classes</a></li>
                <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            </ul>

            <div class="icon-buttons d-flex align-items-center">
                <a href="search.php"><i class="bi bi-search"></i></a>
                <a href="profile.php"><i class="bi bi-person-circle"></i></a>
            </div>
        </div>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>  