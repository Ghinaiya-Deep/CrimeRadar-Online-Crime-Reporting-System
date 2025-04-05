<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Crime Register Form</title>
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
  <link href="assets/css/style.css" rel="stylesheet">



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


    </div>
  </header>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background">
      <div class="container position-relative">
        <h1>Crime Registration Form</h1>
      </div>
    </div><!-- End Page Title -->

    <?php
    session_start();
    require_once 'config.php';

    // Initialize success message and error messages
    $success_message = "";
    $error_messages = [];
    $show_form = true;
    $submitted_data = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      require_once 'config.php'; // Ensure database connection is established

      // Function to generate a unique 5-digit crime ID
      function generateUniqueCrimeID($con)
      {
        do {
          $crime_id = rand(10000, 99999); // Generate a random 5-digit number
          $result = $con->query("SELECT id FROM crime_reports WHERE id = '$crime_id'");
        } while ($result->num_rows > 0); // Keep generating until a unique ID is found

        return $crime_id;
      }

      $crime_id = generateUniqueCrimeID($con); // Get a unique crime ID

      // Sanitize and validate inputs
      $name = trim($_POST["name"]);
      $email = trim($_POST["email"]);
      $mobile = trim($_POST["mobile"]);
      $crime_type = trim($_POST["crime_type"]);
      $police_station_id = intval($_POST["police_station_id"]); // Ensure it's an integer
      $address = trim($_POST["address"]);
      $description = trim($_POST["description"]);
      $status = "Unsolved"; // Default status

      // Email validation
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_messages[] = "Invalid email format.";
      }

      // Mobile number validation (only digits and must be 10 digits)
      if (!preg_match("/^[0-9]{10}$/", $mobile)) {
        $error_messages[] = "Invalid mobile number. It should be 10 digits long.";
      }

      // Name validation (only letters and spaces allowed)
      if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $error_messages[] = "Invalid name. Only letters and spaces are allowed.";
      }

      // Address validation (must be at least 5 characters long)
      if (strlen($address) < 5) {
        $error_messages[] = "Address must be at least 5 characters long.";
      }

      // Crime description validation (must be at least 10 characters long)
      if (strlen($description) < 10) {
        $error_messages[] = "Crime description must be at least 10 characters long.";
      }

      // Date of report validation (optional, ensuring a valid date is entered)
      if (isset($_POST["date_of_report"]) && !empty($_POST["date_of_report"])) {
        $date_of_report = $_POST["date_of_report"];
        $date_regex = "/^\d{4}-\d{2}-\d{2}$/"; // Format YYYY-MM-DD
        if (!preg_match($date_regex, $date_of_report)) {
          $error_messages[] = "Invalid date format.";
        }
      } else {
        $date_of_report = date("Y-m-d H:i:s"); // Default to current timestamp
      }

      // File upload handling
      $evidence = "";
      if (isset($_FILES["evidence"]) && $_FILES["evidence"]["size"] > 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
        if (!in_array($_FILES["evidence"]["type"], $allowed_types)) {
          $error_messages[] = "Invalid file type. Only JPG, PNG, and PDF are allowed.";
        } else {
          $evidence = basename($_FILES["evidence"]["name"]);
          move_uploaded_file($_FILES["evidence"]["tmp_name"], "uploads/" . $evidence);
        }
      }

      // If no errors, insert into the database
      if (empty($error_messages)) {
        $sql = "INSERT INTO crime_reports (id, name, email, mobile, address, crime_type, police_station_id, description, evidence, date_of_report, status) 
                VALUES ('$crime_id', '$name', '$email', '$mobile', '$address', '$crime_type', '$police_station_id', '$description', '$evidence', '$date_of_report', '$status')";

        if ($con->query($sql) === TRUE) {
          $success_message = "Your complaint has been registered successfully.";
          $submitted_data = [
            'id' => $crime_id,
            'name' => $name,
            'mobile' => $mobile,
            'address' => $address,
            'crime_type' => $crime_type
          ];
        } else {
          $error_messages[] = "Database error: " . $con->error;
        }
      }

      $con->close();
    }
    ?>

    <style>
      .submitted-data-table {
        width: 80%;
        /* Reducing width to add space on sides */
        margin: 20px auto;
        /* Centers table with top and bottom spacing */
        border-collapse: collapse;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      }

      .submitted-data-table th,
      .submitted-data-table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
        /* Align text to left for readability */
        font-size: 16px;
      }

      .submitted-data-table th {
        background-color: #f4f4f4;
        /* Soft light gray background */
        color: #333;
        /* Dark gray text */
        text-transform: uppercase;
        font-weight: bold;
        text-align: center;
      }

      .submitted-data-table td {
        background-color: #ffffff;
        /* White background */
      }

      .submitted-data-table tr:nth-child(even) {
        background-color: #f9f9f9;
        /* Very light gray */
      }

      .submitted-data-table tr:hover {
        background-color: #eaf2ff;
        /* Soft blue hover effect */
        transition: 0.3s ease-in-out;
      }

      .submitted-data-table th:first-child,
      .submitted-data-table td:first-child {
        padding-left: 20px;
      }

      .submitted-data-table th:last-child,
      .submitted-data-table td:last-child {
        padding-right: 20px;
      }
    </style>

    <br><br>

    <!-- Display error messages -->
    <?php if (!empty($error_messages)) { ?>
      <div class="alert alert-danger">
        <ul>
          <?php foreach ($error_messages as $error) { ?>
            <li><?php echo $error; ?></li>
          <?php } ?>
        </ul>
      </div>
    <?php } ?>

    <!-- Display success message and submitted data -->
    <?php if ($success_message != "") { ?>
      <div class="alert alert-success">
        <strong>Success!</strong> <?php echo $success_message; ?>
      </div>

      <?php if (!empty($submitted_data)) { ?>
        <table class="submitted-data-table">
          <thead>
            <tr>
              <th>Crime ID</th>
              <th>Name</th>
              <th>Mobile</th>
              <th>Crime Type</th>
              <th>Address</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php echo $submitted_data['id']; ?></td>
              <td><?php echo $submitted_data['name']; ?></td>
              <td><?php echo $submitted_data['mobile']; ?></td>
              <td><?php echo $submitted_data['address']; ?></td>
              <td><?php echo $submitted_data['crime_type']; ?></td>
            </tr>
          </tbody>
        </table>
      <?php } ?>
    <?php } ?>

    <!-- Crime Registration Form -->
    <?php if ($success_message == "" || empty($submitted_data)) { ?>
      <div class="center form">
        <!-- <h2 class="text-center">Crime Registration Form</h2> -->
        <form action="#" method="post" enctype="multipart/form-data" class="w-100 mx-auto p-4 border rounded shadow-sm bg-white">
          <div class="row">
            <div class="col-md-6">
              <label for="name" class="form-label fw-bold">Full Name:</label>
              <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label fw-bold">Email:</label>
              <input type="email" id="email" name="email" class="form-control" required>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <label for="mobile" class="form-label fw-bold">Mobile Number:</label>
              <input type="tel" id="mobile" name="mobile" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="crime_type" class="form-label fw-bold">Crime Type:</label>
              <select id="crime_type" name="crime_type" class="form-select" required>
                <option value="">Select Crime Type</option>
                <option value="Theft">Theft</option>
                <option value="Robbery">Robbery</option>
                <option value="Assault">Assault</option>
                <option value="Fraud">Fraud</option>
                <option value="Cyber Crime">Cyber Crime</option>
                <option value="Domestic Violence">Domestic Violence</option>
                <option value="Murder">Murder</option>
              </select>
            </div>
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
            <div class="row">
              <div class="col-md-12">
                <label for="address" class="form-label fw-bold">Address:</label>
                <textarea id="address" name="address" class="form-control" required></textarea>
              </div>
            </div>

            <div class="col-md-6">
              <label for="description" class="form-label fw-bold">Crime Description:</label>
              <textarea id="description" name="description" class="form-control" required></textarea>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <label for="evidence" class="form-label fw-bold">Upload Evidence:</label>
              <input type="file" id="evidence" name="evidence" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="date_of_report" class="form-label fw-bold">Date of Crime:</label>
              <input type="date" id="date_of_report" name="date_of_report" class="form-control" required>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 text-center mt-4">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div>
    <?php } ?>


    <br><Br><br><br>

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