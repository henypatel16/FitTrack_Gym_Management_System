<?php
session_start();
include '../config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FitTrack gym - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/home.css">
</head>

<body>
    <?php include 'user_header.php'; ?>

    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="hs-slider owl-carousel">
            <div class="hs-item set-bg" data-setbg="../img/home1.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-6">
                            <div class="hi-text" style="margin-top: -100px;">
                                <span>Shape your body</span>
                                <h1>Be <strong>strong</strong> training hard</h1>
                                <a href="about.php" class="primary-btn" >Get info</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hs-item set-bg" data-setbg="../img/home2.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-6">
                            <div class="hi-text" style="margin-top: -100px;">
                                <span>Shape your body</span>
                                <h1>Push <strong>limits</strong> stay fit</h1>
                                <a href="about.php" class="primary-btn">Get info</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Classes Section Begin -->
    <section class="classes-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Our Classes</span>
                        <h2>WHAT WE CAN OFFER</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                $class_query = mysqli_query($conn, "SELECT * FROM classes ORDER BY id DESC LIMIT 3");
                while ($class = mysqli_fetch_assoc($class_query)) {
                ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="class-item">
                            <div class="ci-pic">
                                <img src="../uploads/<?php echo $class['image']; ?>" alt="">
                            </div>
                            <div class="ci-text">
                                <span><?php echo htmlspecialchars($class['trainer']); ?></span>
                                <h5><?php echo htmlspecialchars($class['title']); ?></h5>
                                <p><?php echo date("d M Y", strtotime($class['date'])) . " - " . date("h:i A", strtotime($class['time'])); ?></p>
                                <a href="classes.php?id=<?php echo $class['id']; ?>"><i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- Classes Section End -->

    <!-- membership Section Begin -->
    <section class="pricing-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Our Plan</span>
                        <h2>Choose your pricing plan</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <?php
                $membership_query = mysqli_query($conn, "SELECT * FROM memberships ORDER BY id DESC LIMIT 3");
                while ($m = mysqli_fetch_assoc($membership_query)) {
                ?>
                    <div class="col-lg-4 col-md-8">
                        <div class="ps-item">
                            <h3><?php echo htmlspecialchars($m['title']); ?></h3>
                            <div class="pi-price">
                                <h2>₹ <?php echo htmlspecialchars($m['price']); ?></h2>
                                <span><?php echo htmlspecialchars($m['description']); ?></span>
                            </div>
                            <a href="membership.php?id=<?php echo $m['id']; ?>" class="primary-btn pricing-btn">Enroll now</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- membership Section End -->

    <!-- Team Section Begin -->
    <section class="team-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="team-title d-flex justify-content-between align-items-center">
                        <div class="section-title">
                            <span>Our Team</span>
                            <h2>TRAIN WITH EXPERTS</h2>
                        </div>
                        <a href="contact.php" class="primary-btn btn-normal appoinment-btn">Appointment</a>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <?php
                $trainer_query = mysqli_query($conn, "SELECT * FROM trainers ORDER BY id DESC LIMIT 3");
                while ($trainer = mysqli_fetch_assoc($trainer_query)) {
                ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a href="trainer.php?id=<?php echo $trainer['id']; ?>" style="text-decoration: none;">
                        <div class="card text-center bg-dark text-light p-3">
                            <img src="../uploads/<?php echo $trainer['profile_pic']; ?>"
                                 alt="<?php echo htmlspecialchars($trainer['name']); ?>"
                                 class="rounded-circle mx-auto d-block"
                                 style="width: 200px; height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-3" style="color: #ff6600;"><?php echo htmlspecialchars($trainer['name']); ?></h5>
                                <p class="card-text">Specialization: <?php echo htmlspecialchars($trainer['specialization']); ?></p>
                                <p class="card-text">Experience: <?php echo htmlspecialchars($trainer['experience']); ?> years</p>
                            </div>
                        </div></a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- Team Section End -->

    <?php include 'user_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>
    <script>
        // set-bg function
        $('.set-bg').each(function() {
            var bg = $(this).data('setbg');
            $(this).css('background-image', 'url(' + bg + ')');
        });

        // Hero slider
        $(".hs-slider").owlCarousel({
            items: 1,
            autoplay: true,
            loop: true,
            nav: true,
            dots: true
        });
    </script>
</body>
</html>
