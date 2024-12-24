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
        isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['confirm_password']) &&
        !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])
    ) {

        // Sanitize inputs
        $fullName = $connection->real_escape_string($_POST['name']);
        $email = $connection->real_escape_string($_POST['email']);
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];

        // Validate password length
        if (strlen($password) < 8) {
            echo "Password must be at least 8 characters long.";
            exit();
        }

        // Check if passwords match
        if ($password !== $confirmPassword) {
            echo "Passwords do not match.";
            exit();
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if email already exists in the 'charity' table
        $checkEmail = "SELECT email FROM charity WHERE email = ?";
        $stmt = $connection->prepare($checkEmail);
        if ($stmt === false) {
            die('MySQL prepare error: ' . $connection->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "Email is already taken.";
            $stmt->close();
        } else {
            $stmt->close();

            // Insert user data into the 'charity' table
            $insertUser = "INSERT INTO charity (name, email, password) VALUES (?, ?, ?)";
            $stmt = $connection->prepare($insertUser);
            if ($stmt === false) {
                die('MySQL prepare error: ' . $connection->error);
            }

            $stmt->bind_param("sss", $fullName, $email, $hashedPassword);

            if ($stmt->execute()) {
                echo "Sign-up successful!";
                // Redirect to the login page
                header("Location: login.php");
                exit();
            } else {
                echo "An error occurred. Please try again.";
            }

            $stmt->close();
        }
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
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up - CharityConnect</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }

        .sign-up-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 12px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        .input-field:focus {
            border-color: #2575fc;
            outline: none;
        }

        .sign-up-btn {
            width: 100%;
            padding: 10px;
            background: #2575fc;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
            font-size: 16px;
        }

        .sign-up-btn:hover {
            background: #1d5dc1;
        }

        .footer-links {
            text-align: center;
            margin-top: 15px;
        }

        .footer-links a {
            color: #2575fc;
            text-decoration: none;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="sign-up-container">
        <h2>Sign Up</h2>
        <form action="signup.php" method="POST">
            <input type="text" name="name" class="input-field" placeholder="Full Name" required>
            <input type="email" name="email" class="input-field" placeholder="Email Address" required>
            <input type="password" name="password" class="input-field" placeholder="Password" required>
            <input type="password" name="confirm_password" class="input-field" placeholder="Confirm Password" required>
            <button type="submit" class="sign-up-btn">Sign Up</button>
        </form>
        <div class="footer-links">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>

</html>