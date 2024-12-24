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
            echo "<p><strong>welcome</strong> " . $username . "</p>";
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
    <title>Charity Website</title>
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
            /* White background */
            color: #004080;
            /* Blue text */
            overflow-x: hidden;
        }

        /* Navigation Bar */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 40px;
            background-color: #fff;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        nav .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: #004080;
        }

        nav .nav-links {
            display: flex;
            gap: 20px;
            margin-left: auto;
        }

        nav .nav-links li {
            list-style: none;
        }

        nav .nav-links li a {
            color: #004080;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
            position: relative;
            transition: color 0.3s ease;
        }

        nav .nav-links li a:hover {
            color: #ff9933;
            /* Orange on hover */
        }

        /* Login Button Glow */
        .login-btn {
            padding: 10px 20px;
            background: linear-gradient(45deg, #004080, #ff9933);
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(255, 153, 51, 0.8), 0 0 20px rgba(0, 64, 128, 0.8);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .login-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(255, 153, 51, 1), 0 0 30px rgba(0, 64, 128, 1);
        }

        /* Navigation Button */
        .nav-btn {
            background: none;
            /* No background initially */
            color: #004080;
            /* Blue text */
            padding: 10px 20px;
            font-size: 1.1rem;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-btn:hover {
            background: #ff9933;
            /* Orange background on hover */
            color: white;
            /* White text on hover */
        }

        /* Hero Section */
        #hero {
            text-align: center;
            background: linear-gradient(45deg, rgba(0, 64, 128, 0.8), rgba(255, 153, 51, 0.7)), url('background-image.jpg');
            color: white;
            padding: 100px 20px;
            border-radius: 10px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            margin: 30px auto;
            width: 90%;
            max-width: 1200px;
            animation: fadeIn 1s ease-in-out;
        }

        #hero h1 {
            font-size: 3rem;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        #hero p {
            font-size: 1.2rem;
            margin-bottom: 40px;
        }

        .btn {
            background: #004080;
            /* Blue button */
            color: white;
            padding: 15px 30px;
            font-size: 1.2rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 64, 128, 0.6);

        }

        .btn:hover {
            background: #003060;
            /* Darker blue on hover */
            /* Remove transform to prevent text hiding */
            box-shadow: 0 6px 25px rgba(0, 64, 128, 0.8);
        }

        #about {
            text-align: center;
            background: url('./images/african.jpeg') no-repeat center/cover;
            /* Set the image as background */
            padding: 80px 20px;
            margin: 40px 0;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
            position: relative;
            color: white;
            /* Make text white for better contrast */
        }

        #about::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 64, 128, 0.5);
            /* Add semi-transparent overlay */
            z-index: -1;
            border-radius: 15px;
        }

        #about h2,
        #about p {
            position: relative;
            /* Ensure text is on top of the overlay */
        }

        #about h2 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 30px;
        }

        #about p {
            font-size: 1.2rem;
            line-height: 1.8;
            font-weight: bold;
        }


        /* Causes Section */
        #causes {
            background: #fff;
            padding: 50px 20px;
            text-align: center;
            border-radius: 15px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15);
            margin: 40px 0;
            animation: fadeIn 1s ease-in-out;
        }

        .cause {
            background: #f0f8ff;
            /* Light blue background */
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }

        .cause:hover {
            transform: translateY(-10px);
        }

        .cause h3 {
            color: #004080;
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .cause p {
            font-size: 1.1rem;
            margin-bottom: 20px;
            color: #003060;
            /* Darker blue */
        }

        /* Donate Section */
        #donate {
            background: #f9f9f9;
            padding: 50px 20px;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 50px;
            animation: fadeIn 1s ease-in-out;
        }

        #donate h2 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #004080;
            text-align: center;
            margin-bottom: 40px;
        }

        form {
            max-width: 700px;
            margin: 0 auto;
            background: #fff;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        form input,
        form select,
        form textarea {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 1rem;
            background: #f9f9f9;
            color: #004080;
        }

        form button {
            background: #004080;
            color: white;
            padding: 15px 25px;
            border: none;
            border-radius: 30px;
            font-size: 1.2rem;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 64, 128, 0.5);
            transition: all 0.3s ease;
        }

        form button:hover {
            background: #003060;
            box-shadow: 0 6px 20px rgba(0, 64, 128, 0.7);
            transform: scale(1.05);
        }

        /* Footer */
        footer {
            background: #004080;
            color: white;
            text-align: center;
            padding: 30px;
            font-size: 1rem;
            box-shadow: 0 -10px 15px rgba(0, 0, 0, 0.1);

        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>

</head>

<body>
    <header>

        <body>
            <script>
                // Function to fetch user data from get_user_name.php
                function fetchUserData() {
                    fetch('get_user_name.php')
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                document.getElementById('user-info').innerHTML = data.error;
                            } else {
                                document.getElementById('user-info').innerHTML = `
                            <p>Name: ${data.name}</p>
                            <p>Email: ${data.email}</p>
                        `;
                            }
                        })
                        .catch(error => {
                            document.getElementById('user-info').innerHTML = 'Error fetching data';
                        });
                }

                // Call the function when the page loads
                window.onload = fetchUserData;
            </script>


            <div class="profile-container">






                </form>
            </div>



        </body>
        <nav>
            <div class="logo">CharityConnect</div>
            <ul class="nav-links">
                <li><a href="#about" class="scroll-link">About Us</a></li>
                <li><a href="#causes" class="scroll-link">Donate</a></li>
                <li><a href="./contact.php" class="scroll-link">Contact</a></li>
                <li><a href="./profile.php" class="scroll-link">profile</a></li>
                <li id="user-name" class="user-info" onclick="toggleMenu()"></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Hero Section -->




        <section id="hero">
            <h1>Support the Causes You Care About</h1>
            <p>Join us in making a difference in the world by supporting various charities and community initiatives.</p>
            <a href="#causes" class="btn scroll-link">Donate Now</a>
        </section>

        <!-- About Section -->
        <section id="about">
            <h2>About Us</h2>
            <p>At CharityConnect, our mission is to bridge the gap between those who want to make a difference and the communities in need. We believe that everyone has the power to contribute to a better world, whether it's by supporting education for underprivileged children, providing healthcare assistance, or offering shelter to the homeless. We strive to create a platform where individuals, organizations, and businesses can come together to donate, volunteer, and take action for the causes they care about. Every donation, no matter how small, has the potential to create lasting change and impact lives for the better. Join us in our mission to make the world a kinder, more compassionate place for all.</p>
        </section>

        <!-- Causes Section -->
        <section id="causes">
            <h2 style="padding-bottom: 4%; font-size: 40px;">Our Causes</h2>
            <div class="cause">
                <h3>Education for All</h3>
                <p>Provide resources and support for underprivileged children to receive quality education.</p>
                <a href="./donation.html" class="btn scroll-link">Support Education</a>
            </div>
            <div class="cause">
                <h3>Healthcare Assistance</h3>
                <p>Help us provide medical care and essential supplies to those in need.</p>
                <a href="./donation.html" class="btn scroll-link">Support Healthcare</a>
            </div>
            <div class="cause">
                <h3>Environmental Conservation</h3>
                <p>Join us in protecting the planet through reforestation, clean-up drives, and awareness campaigns.</p>
                <a href="./donation.html" class="btn scroll-link">Support Environment</a>
            </div>
        </section>

        <footer>
            <p>&copy; 2024 CharityConnect. All rights reserved.</p>
        </footer>

        <script>
            document.addEventListener('DOMContentLoaded', async () => {
                const userNameDisplay = document.getElementById('user-name');

                try {
                    // Fetch the user's name from the server
                    const response = await fetch('./get_user_name.php');
                    const data = await response.json();

                    // Display the user's name if available
                    if (data.user_name) {
                        userNameDisplay.style.display = 'block';
                        userNameDisplay.textContent = data.user_name;
                    } else {
                        console.error(data.error);
                    }
                } catch (error) {
                    console.error('Error fetching user name:', error);
                }
            });

            // Toggle account options menu
            function toggleMenu() {
                const menu = document.createElement('div');
                menu.classList.add('account-menu');
                menu.innerHTML = `
        <ul>
            <li><a href="edit_account.html">Edit Account Info</a></li>
            <li><a href="logout.php">Sign Out</a></li>
        </ul>
    `;
                document.body.appendChild(menu);
            }

            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.user-info') && !event.target.closest('.account-menu')) {
                    const menu = document.querySelector('.account-menu');
                    if (menu) {
                        menu.remove();
                    }
                }
            });

            document.addEventListener('DOMContentLoaded', () => {
                // Check if the user is logged in
                const userName = sessionStorage.getItem('user_name');
                const signUpBtn = document.getElementById('sign-up-btn');
                const userNameDisplay = document.getElementById('user-name');

                // If the user is logged in, hide the sign-up button and show the user's name
                if (userName) {
                    signUpBtn.style.display = 'none';
                    userNameDisplay.style.display = 'block';
                    userNameDisplay.textContent = userName;
                }
            });

            // Toggle account options menu
            function toggleMenu() {
                const menu = document.createElement('div');
                menu.classList.add('account-menu');
                menu.innerHTML = `
                <ul>
                    <li><a href="edit_account.html">Edit Account Info</a></li>
                    <li><a href="logout.php">Sign Out</a></li>
                </ul>
            `;
                document.body.appendChild(menu);
            }

            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.user-info') && !event.target.closest('.account-menu')) {
                    const menu = document.querySelector('.account-menu');
                    if (menu) {
                        menu.remove();
                    }
                }
            });
        </script>
</body>

</html>