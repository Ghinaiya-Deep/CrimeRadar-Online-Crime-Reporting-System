<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Users Details</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="responsive.css">
    
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<style>
    .main-container {
        display: flex;
        justify-content: center;
        /* Centers the container horizontally */
    }

    .container {
        max-width: 80%;
        margin: 20px auto;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        overflow-x: auto;
        border: 1px solid #ccc;
    }

    th,
    td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ccc;
        /* Added border for separation */
    }

    th {
        background-color: #cadcfc;
        color: black;
        border: 1px solid #ccc;
        /* Ensure headers have a border */
    }

    tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    tr:nth-child(odd) {
        background-color: #ffffff;
    }

    tr:hover {
        background-color: #e9ecef;
    }

    /* Edit Button - Green */
    .edit-btn {
        background-color: #27ae60;
        /* Green */
        color: white;
        padding: 8px 12px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        display: inline-block;
        transition: 0.3s ease-in-out;
        border: none;
    }

    .edit-btn:hover {
        background-color: #219150;
        /* Darker Green */
    }

    .delete-btn {
        background-color: #e74c3c;
        color: white;
        padding: 8px 12px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        display: inline-block;
        transition: 0.3s ease-in-out;
        border: none;
    }

    .delete-btn:hover {
        background-color: #c0392b;
    }

    td a {
        margin: 3px;
    }
</style>

<body>

    <!-- for header part -->
    <header>


        <div class="logo">E-Report Hub
            <img src="img/cs.png" alt="Logo" class="main-logo">
        </div>


        <div class="searchbar">
            <h2>Welcome to Admin Dashboard</h2>
        </div>


        <div class="message">
            <div class="dp">
                <a href="logout.php">
                    <img src="img/logout.png" class="dpicn" alt="dp">
                </a>
            </div>

    </header>

    <div class="main-container">
        <div class="navcontainer">
            <nav class="nav">
                <div class="nav-upper-options">
                    <a href="admin_dashboard.php">
                        <div class="nav-option option1">
                            <img
                                src="https://media.geeksforgeeks.org/wp-content/uploads/20221210182148/Untitled-design-(29).png"
                                class="nav-img"
                                alt="dashboard">
                            <h3>Dashboard</h3>
                        </div>
                    </a>

                    <a href="cases.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/police-handcuffs.png" class="nav-img" alt="Crimes">
                            <h3>Crimes</h3>
                        </div>
                    </a>

                    <a href="fir.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/fir.png" class="nav-img" alt="FIR">
                            <h3>FIR</h3>
                        </div>
                    </a>
                    <a href="chargesheet.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/chargesheet.png" class="nav-img" alt="Chargesheet">
                            <h3>Chargesheet</h3>
                        </div>
                    </a>
                    <a href="report.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/report.png" class="nav-img" alt="Report">
                            <h3>Report</h3>
                        </div>
                    </a>

                    <a href="case_tracking.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/track.png" class="nav-img" alt="Case Tracking">
                            <h3>Case Tracking</h3>
                        </div>
                    </a>

                    <a href="police_station.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/police-station.png" class="nav-img" alt="Police Station">
                            <h3>Police Station</h3>
                        </div>
                    </a>

                    <a href="feedback.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/feedback.png" class="nav-img" alt="Feedback">
                            <h3>Feedback</h3>
                        </div>
                    </a>

                    <a href="user_details.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/group.png" class="nav-img" alt="Users">
                            <h3>Users</h3>
                        </div>
                    </a>

                    <a href="police_officer.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/avatar.png" class="nav-img" alt="Police Officer">
                            <h3>Police Officer</h3>
                        </div>
                    </a>
                </div>
            </nav>
        </div>


        <br><br>
        <div class="container">
            <h2>Total Users</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Age</th>
                        <th>Password</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'config.php'; // Database connection

                    $sql = "SELECT * FROM users"; // Assuming table name is 'users'
                    $result = mysqli_query($con, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                        <td>{$row['Id']}</td>
                        <td>{$row['Username']}</td>
                        <td>{$row['Email']}</td>
                        <td>{$row['Age']}</td>
                        <td>{$row['Mobile']}</td>
                        <td>{$row['Password']}</td>
                        <td>
                            <a href='edit_user.php?id={$row['Id']}' class='edit-btn'>Edit</a>
                            <a href='delete_user.php?id={$row['Id']}' class='delete-btn' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                        </td>
                    </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No users found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>


        </div>

        </section>

    </div>
    </div>

    <script src="./index.js"></script>
</body>

</html>