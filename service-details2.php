<?php
require_once 'config.php'; // include the config file for database connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Check Status For Register Complaints</title>
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
                <h1>Check Status For Register Complaints</h1>
            </div>
        </div><!-- End Page Title -->

        <style>
            .table-responsive {
                margin: 20px auto;
                /* Adds space from left and right */
                width: 70%;
                /* Adjust width to avoid full-screen stretch */
            }

            .table {
                background-color: #f9f9f9;
                /* Light background */
                border-radius: 10px;
                /* Rounded corners */
                overflow: hidden;
                /* Ensures proper layout */
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
                /* Soft shadow */
                text-align: center;
                /* Centers text */
            }

            .table th {
                background-color: #e0e0e0;
                /* Light grey background for headers */
                color: #333;
                /* Dark text for contrast */
                font-weight: bold;
                padding: 12px;
            }

            .table td {
                padding: 10px;
                color: #444;
                /* Dark grey for readability */
                font-size: 16px;
            }

            .table-bordered th,
            .table-bordered td {
                border: 1px solid #ddd;
                /* Light border */
            }

            @media (max-width: 768px) {
                .table-responsive {
                    width: 90%;
                    /* Adjust width for smaller screens */
                }
            }

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
        </style>
        </style>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $crime_id = $_POST['crime-id'];
            $mobile = $_POST['mobile'];
            $error_message = ""; // Initialize error message variable

            // Validate Crime ID (Must be exactly 5 digits)
            if (!preg_match('/^\d{5}$/', $crime_id)) {
                $error_message = "Crime ID must be exactly 5 digits.";
            }

            // Validate Mobile Number (Must be exactly 10 digits)
            elseif (!preg_match('/^\d{10}$/', $mobile)) {
                $error_message = "Mobile Number must be exactly 10 digits.";
            }

            // Display error if validation fails
            if (!empty($error_message)) {
                echo "<br><br><div class='error-message'>$error_message</div>";
                exit;
            }

            // Query to fetch crime details based on user input
            $query = "SELECT * FROM crime_reports WHERE id = '$crime_id' AND mobile = '$mobile'";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $status = $row['status'] ?: "Pending"; // Default status is "Pending" if empty
        ?>
                <div class="table-responsive">
                    <table class="table table-bordered mt-4">
                        <tr>
                            <th class="bg-light">Crime ID</th>
                            <td><?php echo $row['id']; ?></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Name</th>
                            <td><?php echo $row['name']; ?></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Mobile</th>
                            <td><?php echo $row['mobile']; ?></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Crime Type</th>
                            <td><?php echo $row['crime_type']; ?></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Status</th>
                            <td><?php echo $status; ?></td>
                        </tr>
                        <?php
                        if (strtolower($status) == "solved") {
                        ?>
                            <tr>
                                <th class="bg-light text-danger" colspan="2">
                                    <i class="bi bi-exclamation-circle"></i>
                                    Your case has been solved. You can download the charge sheet from the <a href="service-details4.php" class="text-primary fw-bold">Charge Sheet</a> menu.
                                </th>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            <?php
            } else {
                echo "<p class='text-danger text-center'>No record found with the given Crime ID and Mobile Number.</p>";
            }
        } else {
            ?>
            <form action="" method="post" class="w-50 mx-auto p-4 border rounded shadow-sm bg-white">
                <div class="mb-3">
                    <label for="crime-id" class="form-label fw-bold">Crime ID:</label>
                    <input type="text" id="crime-id" name="crime-id" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="mobile" class="form-label fw-bold">Mobile Number:</label>
                    <input type="text" id="mobile" name="mobile" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Check Status</button>
            </form>
        <?php
        }
        ?>



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