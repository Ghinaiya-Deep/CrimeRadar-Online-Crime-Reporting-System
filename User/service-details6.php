<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Feedback</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Selecao
  * Template URL: https://bootstrapmade.com/selecao-bootstrap-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="service-details-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="index.html" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <h1 class="sitename">Crime Radar</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#about">About</a></li>


                    <li><a href="index.php#gallery">Gallery</a></li>
                    <li class="dropdown"><a href="#"><span>Services</span>
                            <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="service-details1.php">Register
                                    Complaints</a></li>
                            <li><a href="service-details2.php">Track Status
                                    of Complaints</a></li>
                            <li><a href="service-details3.php">Check Charge
                                    Sheet Details</a></li>
                            <li><a href="service-details4.php">Withdraw
                                    Complaints</a></li>
                            <li><a href="service-details5.php">Track Status
                                    of Withdraw Complaints</a></li>
                            <li><a href="service-details6.php">Feedback</a></li>
                        </ul>
                    </li>
                    <li><a href="index.php#contact">Contact</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </header>

    <main class="main">

        <!-- Page Title -->
        <div class="page-title dark-background">
            <div class="container position-relative">
                <h1>Citizen Feedback</h1>
            </div>
        </div><!-- End Page Title --> <br>

        <?php
        require_once 'config.php'; // Database connection

        $message = ""; // Store success/error message

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $citizen_name = mysqli_real_escape_string($con, $_POST['name']);
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $police_station = intval($_POST['police_station_id']);
            $feedback = mysqli_real_escape_string($con, $_POST['feedback']);
            $rating = mysqli_real_escape_string($con, $_POST['rating']);

            $query = "INSERT INTO feedback (name, email,police_station_id, feedback, rating) VALUES ('$citizen_name', '$email','$police_station', '$feedback', '$rating')";

            if (mysqli_query($con, $query)) {
                $message = "<div class='alert alert-success'>Feedback Submitted Successfully.</div>";
            } else {
                $message = "<div class='alert alert-danger'>Error submitting feedback. Please try again.</div>";
            }
        }
        ?>



        <div class="center form">
            <h2 class="text-center mb-4"><b>Give Your Feedback</b></h2>
            <?= $message ?>
            <form action="#" method="post" class="w-50 mx-auto p-4 border rounded shadow-sm bg-white">
                <div class="row">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-bold">Full Name:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-bold">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="police_station_id" class="form-label fw-bold">Police Station:</label>
                            <select id="police_station_id" name="police_station_id" class="form-select" required>
                                <option value="">Select Police Station</option>
                                <option value="1">Adgaon</option>
                                <option value="2">Ambad</option>
                                <option value="3">Bhadrakali</option>
                                <option value="4">Deolali Camp</option>
                                <option value="5">Gangapur</option>
                                <option value="6">Indiranagar</option>
                                <option value="7">Mhasrul</option>
                                <option value="8">Mumbai Naka</option>
                                <option value="9">Nashik Road</option>
                                <option value="10">Panchvati</option>
                                <option value="11">Sarkarwada</option>
                                <option value="12">Satpur</option>
                                <option value="13">Upnagar</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="feedback" class="form-label fw-bold">Feedback:</label>
                            <textarea id="feedback" name="feedback" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="rating" class="form-label fw-bold">Rating:</label>
                            <select id="rating" name="rating" class="form-control" required>
                                <option value="">Select Rating</option>
                                <option value="1">⭐ - Poor</option>
                                <option value="2">⭐⭐ - Fair</option>
                                <option value="3">⭐⭐⭐ - Good</option>
                                <option value="4">⭐⭐⭐⭐ - Very Good</option>
                                <option value="5">⭐⭐⭐⭐⭐ - Excellent</option>
                            </select>
                        </div>
                    </div>


                    <div class="row mt-4">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Submit Feedback</button>
                        </div>
                    </div>
            </form>


        </div>

        <br><br>
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
        <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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