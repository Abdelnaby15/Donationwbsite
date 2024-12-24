<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - CharityConnect</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f0f8ff, #e6f7ff);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            overflow-x: hidden;
        }

        header {
            width: 100%;
            padding: 20px;
            background-color: #004080;
            color: white;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        header .logo {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .profile-container {
            background: linear-gradient(135deg, #ffffff, #e6f7ff);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
            margin-top: 120px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-container:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
        }

        .profile-container h1 {
            font-size: 32px;
            color: #004080;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .profile-container p {
            font-size: 20px;
            color: #333;
            margin: 10px 0;
        }

        .profile-container .btn {
            background-color: #004080;
            color: white;
            padding: 15px 30px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .profile-container .btn:hover {
            background-color: #003060;
            transform: scale(1.1);
            box-shadow: 0 6px 15px rgba(0, 64, 128, 0.6);
        }

        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 20px;
            background-color: #004080;
            color: white;
            text-align: center;
        }

        footer p {
            font-size: 16px;
            margin: 0;
        }
    </style>
</head>

<body>

    <header>
        <div class="logo">CharityConnect</div>
    </header>

    <div class="profile-container">
        <h1>Your Profile</h1>
        <?php
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

        // Ensure the user is logged in (e.g., their email is stored in the session)
        if (isset($_SESSION['email'])) {
            $user_email = $_SESSION['email']; // Retrieve the user's email from the session

            // Query to fetch the name (username) and email from the `charity` table
            $sql = "SELECT name, email FROM charity WHERE email = ?";
            $stmt = $connection->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("s", $user_email); // Bind the session email to the query
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $username = htmlspecialchars($row['name']);
                    $email = htmlspecialchars($row['email']);

                    // Display the user's name and email
                    echo "<p><strong>Name:</strong> " . $username . "</p>";
                    echo "<p><strong>Email:</strong> " . $email . "</p>";
                } else {
                    echo "<p>User not found in the database.</p>";
                }

                $stmt->close();
            } else {
                echo "<p>Error preparing the statement: " . $connection->error . "</p>";
            }
        } else {
            echo "<p>You are not logged in.</p>";
        }

        // Close the database connection
        $connection->close();
        ?>

        <a href="home2.html" class="btn">Go to Home</a>
        <form action="logout.php" method="post">
            <button type="submit" class="btn">Sign Out</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 CharityConnect. All rights reserved.</p>
    </footer>

</body>

</html>