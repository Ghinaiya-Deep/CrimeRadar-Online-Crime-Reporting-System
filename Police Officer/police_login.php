<?php
session_start();
include 'config.php'; // Database connection
$error_message = ""; // Initialize error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, password, police_station_id FROM police WHERE username = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $db_password, $police_station_id);
        $stmt->fetch();

        if ($password === $db_password) {
            $_SESSION['police_id'] = $id;
            $_SESSION['police_station_id'] = $police_station_id;

            $redirects = [
                1 => 'Police Stations/Adgaon.php',
                2 => 'Police Stations/Ambad.php',
                3 => 'Police Stations/Bhadrakali.php',
                4 => 'Police Stations/DeolaliCamp.php',
                5 => 'Police Stations/Gangapur.php',
                6 => 'Police Stations/Indiranagar.php',
                7 => 'Police Stations/Mhasrul.php',
                8 => 'Police Stations/MumbaiNaka.php',
                9 => 'Police Stations/NashikRoad.php',
                10 => 'Police Stations/Panchvati.php',
                11 => 'Police Stations/Sarkarwada.php',
                12 => 'Police Stations/Satpur.php',
                13 => 'Police Stations/Upnagar.php'
            ];

            if ($police_station_id > 0 && isset($redirects[$police_station_id])) {
                header("Location: " . $redirects[$police_station_id]);
                exit();
            } else {
                $error_message = "Invalid police station mapping.";
            }
        } else {
            $error_message = "Invalid credentials.";
        }
    } else {
        $error_message = "User not found.";
    }

    $stmt->close();
}
$con->close();

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Police Officer Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #74ebd5 0%, #acb6e5 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('Images/police.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 25px;
            color: #333;
            font-size: 28px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group input:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.4);
            outline: none;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background: linear-gradient(135deg, #0056b3 0%, #004080 100%);
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .error {
            color: #ffc107;
            font-weight: bold;
            text-align: center;
            margin-top: 15px;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.9);
            border: 2px solid #ffc107;
            border-radius: 8px;
            font-size: 16px;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Police Officer Login</h2>

        <?php if (!empty($error_message)) { ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php } ?>
        <br>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">
            </div>
            <button type="submit" name="login" class="btn">Login</button>

        </form>
    </div>
</body>

</html>