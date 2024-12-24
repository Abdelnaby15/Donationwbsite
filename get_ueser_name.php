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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>
        hi
    </h1>
    
</body>
</html>