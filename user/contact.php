<?php
@include '../config.php'; 
session_start();

$success = "";
$error = "";

// If form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!empty($name) && !empty($email) && !empty($phone) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $message);

        if ($stmt->execute()) {
            $success = "Thank you! Your message has been sent successfully.";
        } else {
            $error = "Something went wrong. Please try again.";
        }
        $stmt->close();
    } else {
        $error = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us - FitTrack Gym</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/contact.css">
</head>
<body>
<?php include 'user_header.php'; ?>

<!-- Banner -->
<div class="page-banner d-flex flex-column justify-content-center align-items-center text-center">
  <span style="color:#ff6600; font-size:30px; font-weight:bold;">CONTACT US</span>
  <h2 class="display-5 fw-bold text-white mt-2">GET IN TOUCH</h2>
</div>

<!-- Contact Section -->
<div class="contact-section py-5">
  <div class="container">
    <div class="row">
      <!-- Left Info -->
      <div class="col-md-6 mb-4">
        <h3 style="color: #ff6600;">We’d Love To Hear From You</h3>
        <p class="text-light">
          Have questions, suggestions, or just want to say hello?  
          Fill out the form and we’ll get back to you as soon as possible.
        </p>
        <div class="contact-info mt-4">
          <p><i class="fas fa-map-marker-alt"></i> 333 Middle Winchendon Rd, Fitness Street, Surat</p>
          <p><i class="fas fa-phone"></i> +91 63512 49014 | 125-668-886</p>
          <p><i class="fas fa-envelope"></i> FitTrack_gym@gmail.com</p>
        </div>
      </div>

      <!-- Right Form -->
      <div class="col-md-6">
        <div class="contact-form p-4 rounded-4 shadow-lg">
        
          <form method="POST">
            <div class="mb-3">
              <input type="text" name="name" class="form-control" placeholder="Your Name" required>
            </div>
            <div class="mb-3">
              <input type="email" name="email" class="form-control" placeholder="Your Email" required>
            </div>
            <div class="mb-3">
              <input type="text" name="phone" class="form-control" placeholder="Your Phone No." required>
            </div>
            <div class="mb-3">
              <textarea name="message" class="form-control" placeholder="Your Message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn fw-bold w-100 mb-3">Send Message</button>
          </form>
           <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
          <?php elseif ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'user_footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
