<?php
require_once 'config.php'; // Database connection

$status = null;
$show_form = true;
$bg_class = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $crime_id = mysqli_real_escape_string($con, $_POST['crime_id']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);

    $query = "SELECT status FROM complaint_withdrawals  WHERE crime_id = '$crime_id'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $status = $row['status']; // Normalize status text
        $show_form = false; // Hide the form when data is displayed

        // Determine background class based on status
        if ($status == 'Pending') {
            $bg_class = 'table-danger';
        } elseif ($status == 'Rejected') {
            $bg_class = 'table-success';
        } elseif ($status == 'Not Rejected') {
            $bg_class = 'table-danger';
        }
    } else {
        $bg_class = 'table-warning';
    }
} else {
    $status = "No withdrawn complaint found for the given Crime ID and Mobile Number.";
    $show_form = true;
}
mysqli_close($con);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Crime Analytical</title>
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <h1>Check Status of Withdraw Complaints</h1>
            </div>
        </div><!-- End Page Title -->
        <div class="container mt-5">
            <?php if ($show_form) { ?>
                <form action="" method="post" class="w-50 mx-auto p-4 border rounded shadow-sm bg-white">
                    <div class="mb-3">
                        <label for="crime_id" class="form-label fw-bold">Crime ID:</label>
                        <input type="text" id="crime_id" name="crime_id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="mobile" class="form-label fw-bold">Mobile Number:</label>
                        <input type="text" id="mobile" name="mobile" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Check Status</button>
                </form>
            <?php } ?>

            <?php if (!$show_form) { ?>
                <div class="mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Crime ID</th>
                                <th>Mobile Number</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="<?php echo $bg_class; ?>">
                                <td><?php echo htmlspecialchars($crime_id); ?></td>
                                <td><?php echo htmlspecialchars($mobile); ?></td>
                                <td><?php echo htmlspecialchars($status); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
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