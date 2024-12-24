<?php
// Start the session
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "Ahmad2005?";
$dbname = "mydb";

// Create connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Database connection failed: " . $connection->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form fields are set and not empty
    if (
        isset($_POST['username']) && isset($_POST['password']) &&
        !empty($_POST['username']) && !empty($_POST['password'])
    ) {

        // Sanitize inputs
        $username = $connection->real_escape_string($_POST['username']);
        $password = $_POST['password'];

        // Check if username (email) exists in the 'charity' table
        $checkUser = "SELECT email, password FROM charity WHERE email = ?";
        $stmt = $connection->prepare($checkUser);
        if ($stmt === false) {
            die('MySQL prepare error: ' . $connection->error);
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // User exists, fetch the password
            $stmt->bind_result($dbEmail, $dbPassword);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $dbPassword)) {
                // Password is correct, start session
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $dbEmail;
                header("Location: home2.php"); // Redirect to home page
                exit();
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "Username (email) not found.";
        }

        $stmt->close();
    } else {
        echo "All fields are required.";
    }
}

// Close connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Majestic Login Page</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 450px;
            backdrop-filter: blur(10px);
            transform: translateY(0);
            animation: slideIn 0.5s ease-out forwards;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #333;
            font-weight: bold;
            text-transform: uppercase;
        }

        .input-field {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 18px;
            transition: 0.3s ease-in-out;
        }

        .input-field:focus {
            border-color: #2575fc;
            box-shadow: 0 0 8px rgba(37, 117, 252, 0.7);
            outline: none;
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(45deg, #ff6f61, #d15d4f);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .login-btn:hover {
            background: linear-gradient(45deg, #d15d4f, #ff6f61);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
            transform: translateY(-2px);
        }

        .footer-links {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 16px;
        }

        .footer-links a {
            color: #2575fc;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #ff6f61;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h2>Login</h2>
        <!-- Form action is now 'login.php' which will handle the POST data -->
        <form action="login.php" method="POST">
            <input type="text" class="input-field" placeholder="Email" name="username" required>
            <input type="password" class="input-field" placeholder="Password" name="password" required>
            <button type="submit" class="login-btn">Login</button>
        </form>
        <div class="footer-links">
            <a href="./forgot-password.html">Forgot Password?</a>
            <a href="signup.php">Sign Up</a> <!-- Link to sign-up page -->
        </div>
    </div>

</body>

</html>