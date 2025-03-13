<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
	    <link rel="stylesheet" href="Home.css">

    <link rel="stylesheet" href="contactus.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- Header Section -->
<header>
        <nav>
            <div class="logo">FixMySpace</div>
           <ul>
                <li><a href="Home.php">Home</a></li>
                <li><a href="AboutUs.html">About Us</a></li>
                <li><a href="contactus.php">Contact Us</a></li>
                <li><a href="Services.php">Services</a></li>
            </ul>
                <button onclick="window.location.href='signup.php'">Get Started</button>
            
        </nav>
    </header>

    <!-- Contact Us Section -->
    <section class="contact-container">
        <div class="contact-info">
            <h2>Contact Us</h2>
            <p>Get in touch with FixMySpace.lk</p>
            <p>We are here to help!</p>
            <ul>
                <li class="email"><strong>Email:</strong> <span>support@example.com</span></li>
                <li class="phone"><strong>Phone:</strong> <span>+1 234 567 890</span></li>
                <li class="address"><strong>Address:</strong> <span>123 Main St, City, Country</span></li>
            </ul>
        </div>        
        
        <div class="contact-form">
            <h3>Send Us a Message</h3>
            <form action="contactus.php" method="post">
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="message">Your Message</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>

                <button type="submit" name="submit">Send Message</button>
            </form>

            <?php
            // PHP script to handle form submission
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
                // Include the database connection file
                include 'ServerConnection.php';

                // Get form data
                $name = $_POST['name'];
                $email = $_POST['email'];
                $message = $_POST['message'];

                // Insert data into the database
                $query = "INSERT INTO contact_us (user_email, message) VALUES (?, ?)";
                $stmt = $conn->prepare($query);

                if ($stmt) {
                    $stmt->bind_param("ss", $email, $message);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        echo "<p class='success-message'>Your message has been sent successfully!</p>";
                    } else {
                        echo "<p class='error-message'>Failed to send your message. Please try again.</p>";
                    }

                    $stmt->close();
                } else {
                    echo "<p class='error-message'>Database error. Please try again later.</p>";
                }

                $conn->close();
            }
            ?>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <div class="footer-container">
            <div class="footer-logo-section">
                <div class="footer-logo">FixMySpace</div>
                <div class="social-media">
                    <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <nav class="footer-nav">
                <ul>
                    <li><a href="AboutUs.html">About Us</a></li>
                    <li><a href="Services.php">Our Services</a></li>
                    <li><a href="contactus.php">Contact Us</a></li>
                    <li><a href="termsandconditions.html">Terms & Conditions</a></li>
                    <li><a href="privacyandpolicy.html">Privacy Policy</a></li>
                </ul>
            </nav>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 FixMySpace. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>