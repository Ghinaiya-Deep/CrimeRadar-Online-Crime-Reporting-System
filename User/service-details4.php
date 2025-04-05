<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Withdraw Complaint</title>
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
    <style>
        .error-message {
            color: #fff;
            background-color: #d9534f;
            /* Bootstrap danger color */
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .success-message {
            color: #fff;
            background-color: #28a745;
            /* Bootstrap success color */
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }
    </style>
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
                <h1>Withdraw Complaint</h1>
            </div>
        </div><!-- End Page Title --> <br>


        <h2 class="text-center mb-4"><b></b></h2>
        <?php $message ?>
        <form action="" method="POST" class="w-50 mx-auto p-4 border rounded shadow-sm bg-white">
            <div class="mb-4 row align-items-center">
                <div class="col-md-4">
                    <label for="crime_id" class="form-label fw-bold">Crime ID</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control form-control-lg" name="crime_id" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 d-flex align-items-center">
                    <label for="police_station_id" class="form-label fw-bold">Police Station</label>
                    <span class="mx-3 fw-bold"></span>
                </div>
                <div class="col-md-8">
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

            <div class="mb-4 row align-items-center">
                <div class="col-md-4">
                    <label for="reason" class="form-label fw-bold">Reason for Withdrawal</label>
                </div>
                <div class="col-md-8">
                    <textarea class="form-control form-control-lg" name="reason" rows="3" required></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit Request</button>
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