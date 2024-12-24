<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

    <!-- Updated EmailJS Script -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/emailjs-com@3.3.0/dist/email.min.js"></script>

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
            color: #004080;
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
            transition: color 0.3s ease;
        }

        nav .nav-links li a:hover {
            color: #ff9933;
        }

        /* Contact Form Section */
        #contact {
            text-align: center;
            padding: 50px 20px;
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
            transition: all 0.3s ease;
        }

        form button:hover {
            background: #003060;
            box-shadow: 0 6px 20px rgba(0, 64, 128, 0.7);
            transform: scale(1.05);
        }

        /* Footer */
        footer {
            background: #f0f8ff;
            color: #004080;
            text-align: center;
            padding: 20px;
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="logo">CharityConnect</div>
            <ul class="nav-links">
                <li><a href="home2.php">Home</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="contact">
            <h2>Contact Us</h2>
            <form id="contact-form">
                <label for="contact-name">Your Name</label>
                <input type="text" id="contact-name" name="contact-name" required>

                <label for="contact-email">Your Email</label>
                <input type="email" id="contact-email" name="contact-email" required>

                <label for="message">Your Message</label>
                <textarea id="message" name="message" rows="5" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2024 CharityConnect. All rights reserved.</p>
    </footer>

    <!-- Initialize EmailJS (with your User ID) -->
    <script type="text/javascript">
        // Initialize EmailJS with your User ID
        emailjs.init("N5GvIHxt6YLkwQn7i"); // Replace with your actual EmailJS User ID

        // Send email function
        document.getElementById('contact-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Collect form data
            var formData = new FormData(this);

            var templateParams = {
                from_name: formData.get('contact-name'),
                from_email: formData.get('contact-email'),
                message: formData.get('message')
            };

            // Send email through EmailJS
            emailjs.send('service_ipbkeah', 'template_9v2z8ic', templateParams)
                .then(function(response) {
                    alert('Message sent successfully!');
                    document.getElementById('contact-form').reset(); // Reset form after submission
                }, function(error) {
                    alert('Message failed to send: ' + error.text);
                });
        });
    </script>
</body>

</html>