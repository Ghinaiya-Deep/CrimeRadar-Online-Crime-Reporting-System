<?php
session_start();
include("config.php");

// Redirect to login if user is not logged in
if (!isset($_SESSION['valid'])) {
  header("Location: login.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Online Crime Reporting System</title>
  <meta name="description" content>
  <meta name="keywords" content>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File -->

  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <h1 class="sitename">Crime Radar</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#services">Services</a></li>
          <li><a href="#gallery">Gallery</a></li>
          <li><a href="#contact">Contact</a></li>
          <li><a href="login.php"><img src="./assets/img/logout.png" alt="logout" style="height:30px;"></a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">
    <section id="hero" class="hero section dark-background">
      <div id="hero-carousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">

        <!-- Slide 1 -->
        <div class="carousel-item active">
          <div class="carousel-container">
            <h2 class="best">Welcome to
              <span>Crime Reporting Portal</span>
            </h2>
            <p class="animate__animated animate__fadeInUp">Welcome to our <b>Online Crime Reporting Management
                System,</b> a secure and efficient platform designed to streamline crime reporting and law enforcement
              processes. Our system empowers citizens to report crimes quickly and conveniently from anywhere, ensuring
              faster response times and improved public safety.</p>
            <p class="animate__animated animate__fadeInUp">With user-friendly features, our portal allows individuals to
              submit complaints, track case progress, and communicate with authorities—all from the comfort of their
              homes. Law enforcement officers can efficiently manage investigations, file charge sheets, and maintain
              comprehensive crime records.
              Together, we aim to build a safer society by bridging the gap between citizens and law enforcement through
              technology.</p>
            <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read
              More</a>
          </div>
        </div>
    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">
      <div class="container section-title aos-init aos-animate" data-aos="fade-up">
        <h2>About</h2>
        <p>Who we are</p>
      </div><!-- End Section Title -->

      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            <p>
              We are a dedicated team committed to modernizing crime reporting and investigation through digital
              innovation. Our platform is designed to enhance transparency, accountability, and efficiency in handling
              criminal cases.
            <p>Our Online Crime Reporting Management System serves as a centralized hub where:
              <br>✅ Citizens can file complaints and track their case status.<br>
              ✅ Police officers can manage investigations, file FIRs, and resolve cases.<br>
              ✅ Administrators oversee and maintain a structured crime database.<br>
            </p>
            <p>By leveraging technology, we strive to support law enforcement agencies in ensuring justice and security
              for all. Our mission is to create a seamless, accessible, and reliable crime reporting system that
              empowers both citizens and officials alike.
            </p>
          </div>

          <div class="col-lg-6" style="text-align: right; width:500px; margin-left:80px;">
            <img src="assets/img/np police.png" alt="Maharashtra Police" class="img-fluid"
              style="margin: 0 auto; height:100%; width:80%;">
          </div>
        </div>
      </div>

      <br><br>
      <!-- Services Section -->
      <section id="services" class="services section">
        <div class="container section-title" data-aos="fade-up">
          <h2>Services</h2>
          <p>What we do offer</p>
        </div><!-- End Section Title -->

        <div class="container">
          <div class="row gy-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="service-item  position-relative">
                <a href="service-details1.php" class="stretched-link">
                  <h3><i class="uil uil-edit"></i> Register Complaints</h3>
                </a>
                <p>File crime reports online quickly and easily.</p>
              </div>
            </div><!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="service-item position-relative">
                <a href="service-details2.php" class="stretched-link">
                  <h3><i class="uil uil-search"></i> Track Status of Complaints</h3>
                </a>
                <p>Monitor real-time updates on complaint progress.</p>
              </div>
            </div><!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="service-item position-relative">
                <a href="service-details3.php" class="stretched-link">
                  <h3><i class="uil uil-file-alt"></i> View Charge Sheet Details</h3>
                </a>
                <p>Access and download charge sheet information.
              </div>
            </div><!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="service-item position-relative">
                <a href="service-details4.php" class="stretched-link">
                  <h3><i class="uil uil-times-circle"></i> Withdraw Complaints</h3>
                </a>
                <p>Cancel a filed complaint if needed.</p>
              </div>
            </div><!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
              <div class="service-item position-relative">
                <a href="service-details5.php" class="stretched-link">
                  <h3><i class="uil uil-chart-bar"></i> Track Status of Withdraw Complaints</h3>
                </a>
                <p>Check Status of Withdraw Complaints (Rejected or Not Rejected)</p>
              </div>
            </div><!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
              <div class="service-item position-relative">
                <a href="service-details6.php" class="stretched-link">
                  <h3><i class="uil uil-comment-dots"></i> Feedback</h3>
                </a>
                <p>Provide insights and suggestions to improve the platform.</p>
              </div>
            </div><!-- End Service Item -->
          </div>
        </div>
      </section><!-- /Services Section -->


      <!-- Gallery Section -->
      <section id="gallery" class="services section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Gallery</h2>
          <p>Awareness Programmes and Activities</p>
        </div><!-- End Section Title -->

        <div class="container">
          <div class="row gy-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="service-item  position-relative">
                <img src="assets/img/g1.jpg" alt="Cyber Crime Awareness Drive" class="img-fluid" style="height:80%;">
                <a href="activity1.html" class="stretched-link">
                  <h3>Cyber Crime Awareness Drive</h3>
                </a>
              </div>
            </div><!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="service-item position-relative">
                <img src="assets/img/g2.jpg" alt="Women’s Safety Campaign" class="img-fluid" style="height:80%;">
                <a href="activity2.html" class="stretched-link">
                  <h3>Women’s Safety Campaign</h3>
                </a>
              </div>
            </div><!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="service-item position-relative">
                <img src="assets/img/g3.avif" alt="Road Safety Initiative" class="img-fluid" style="height:80%;">
                <a href="activity3.html" class="stretched-link">
                  <h3>Road Safety Initiative</h3>
                </a>
              </div>
            </div><!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="service-item position-relative">
                <img src="assets/img/g4.png" alt="Anti-Drug & Substance Abuse Campaign" class="img-fluid"
                  style="height:80%;">
                <a href="activity4.html" class="stretched-link">
                  <h3>Anti-Drug & Substance Abuse Campaign</h3>
                </a>
              </div>
            </div><!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
              <div class="service-item position-relative">
                <img src="assets/img/g5.jpg" alt="Senior Citizen Safety Program" class="img-fluid" style="height:80%;">
                <a href="activity5.html" class="stretched-link">
                  <h3>Senior Citizen Safety Programs</h3>
                </a>
              </div>
            </div><!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
              <div class="service-item position-relative">
                <img src="assets/img/g6.jpg" alt="Financial Fraud Awareness Campaign" class="img-fluid"
                  style="height:80%;">
                <a href="activity6.html" class="stretched-link">
                  <h3>Financial Fraud Awareness Campaign</h3>
                </a>
              </div>
            </div><!-- End Service Item -->
          </div>
        </div>
      </section><!-- Gallery Section -->



      <!-- Contact Section -->
      <section id="contact" class="contact section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Contact</h2>
          <p>Contact Us</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade" data-aos-delay="100">
          <div class="row gy-4">
            <div class="col-lg-4">
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                <div>
                  <h3><b>Address</b></h3>
                  <p>2Q4J+4HH, Gangapur Rd, Opposite K.T.H.M. College, Police Staff Colony, Nashik, Maharashtra 422002,
                    India</p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                <div>
                  <h3><b>Call Us</b></h3>
                  <p>02532305233</p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                <div>
                  <h3><b>Email Us</b></h3>
                  <p>sp.nashik.r@mahapolice.gov.in</p>
                </div>
              </div><!-- End Info Item -->

            </div>
            <div class="col-lg-8" style="padding: 15px;">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14996.305375230142!2d73.781471!3d20.0053103!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bddeba683ec0a31%3A0x84f1257f37c41212!2sPolice%20Commissioner%20Office!5e0!3m2!1sen!2sin!4v1721387730152!5m2!1sen!2sin"
                loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                style="height:150%; width:80%; margin-left: 80px;"></iframe>
            </div>
          </div>
        </div>
  </main>

  <footer id="footer" class="footer dark-background">
    <div class="copyright">
      <span>Copyright</span> <strong class="px-1 sitename">Online Crime Portal</strong> <span>All Rights
        Reserved</span>
    </div>
    <div class="credits">
      Designed by Deep Ghinaiya and Gaurav Kalawadiya</a>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
</body>
</html>