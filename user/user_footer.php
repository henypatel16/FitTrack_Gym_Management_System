<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User footer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  .footer-top {
    background-color: #121212;
  }

  .icon-circle {
    background-color: #ff6600;
    color: #fff;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .main-footer {
    background-color: #000;
    color: #ccc;
  }

  .footer-col h5 {
    color: #fff;
    font-weight: bold;
    margin-bottom: 15px;
  }

  .footer-col ul li a {
    color: #aaa;
    text-decoration: none;
    display: block;
    margin-bottom: 8px;
    transition: 0.3s;
  }

  .footer-col ul li a:hover {
    color: orange;
  }

  .footer-col p a {
    color: #fff;
    font-weight: 600;
    text-decoration: none;
    display: block;
  }

  .footer-col p small {
    font-size: 12px;
    color: #aaa;
  }

  .footer-col p a:hover {
    color: orange;
  }

  .social-icons a {
    color: #ccc;
    margin-right: 12px;
    font-size: 18px;
    transition: 0.3s;
  }

  .social-icons a:hover {
    color: orange;
  }

  .footer-bottom {
    border-top: 1px solid #333;
    font-size: 14px;
  }

  .logo {
    font-size: 32px;
    font-weight: bold;
  }
</style>
</head>
<body>
<section class="footer-top">
  <div class="container text-center d-flex justify-content-around flex-wrap py-4">
    <div class="footer-info-item d-flex align-items-center mb-2">
      <div class="icon-circle"><i class="fas fa-map-marker-alt"></i></div>
      <div class="ms-2 text-white">333 Middle Winchendon Rd, Fitness Street, Surat</div>
    </div>
    <div class="footer-info-item d-flex align-items-center mb-2">
      <div class="icon-circle"><i class="fas fa-phone"></i></div>
      <div class="ms-2 text-white">+91 63512 49014 | 125-668-886</div>
    </div>
    <div class="footer-info-item d-flex align-items-center mb-2">
      <div class="icon-circle"><i class="fas fa-envelope"></i></div>
      <div class="ms-2 text-white">FitTrack_gym@gmail.com</div>
    </div>
  </div>
</section>

<footer class="main-footer py-5">
  <div class="container d-flex justify-content-between flex-wrap">
    <div class="footer-col mb-4" style="max-width: 260px;">
      <h2 class="logo">
        <span style="color: #ff6600;">FIT</span><span style="color: White;">TRACK</span><i class="fas fa-dumbbell" style="color:gray;"></i>
      </h2>
    <p class="mb-0">Stay motivated, stay strong. Follow us for the latest fitness tips, offers, and updates!</p>
     
      <div class="social-icons mt-3">
        <a href="https://facebook.com"><i class="fab fa-facebook-f"></i></a>
        <a href="https://twitter.com"><i class="fab fa-twitter"></i></a>
        <a href="https://youTube.com"><i class="fab fa-youtube"></i></a>
        <a href="https://instagram.com"><i class="fab fa-instagram"></i></a>
      </div>
</div>

    <div class="footer-col mb-4">
      <h5>Useful Links</h5>
      <ul class="list-unstyled">
        <li><a href="home.php">Home</a></li>
        <li><a href="membership.php">Memberships</a></li>
        <li><a href="classes.php">Classes</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="services.php">Services</a></li>
      </ul>
    </div>

    <div class="footer-col mb-4">
      <h5>Support</h5>
      <ul class="list-unstyled">
        <li><a href="../login.php">Login</a></li>
        <li><a href="../register.php">Registration</a></li>
        <li><a href="#">Subscribe</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </div>

   
    <div class="footer-col mb-4" style="max-width: 260px;">
      <h5>Tips & Guides</h5>
      <p>
        <a href="#">Physical fitness may help prevent depression, anxiety</a>
        <small>3 min read | 20 Comment</small>
      </p>
      <p>
        <a href="#">Fitness: The best exercise to lose belly fat and tone up...</a>
        <small>3 min read | 20 Comment</small>
      </p>
    </div>
  </div>

  <div class="footer-bottom text-center py-3 mt-3">
    <p class="text-white text-center mt-3">Copyright ©2025 All rights reserved &#10084; by <span style="color: #ff6600;">FIT TRACK</span></p>
  </div>
  
</footer>
</body>
</html>