<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FixMySpace - Your Trusted Home & Office Service Partner</title>
    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <nav>
            <div class="logo">FixMySpace</div>
            <ul>
<<<<<<<< HEAD:Main.php
                <li><a href="Main.php">Home</a></li>
                <li><a href="AboutUs.html">About Us</a></li>
                <li><a href="contactus.php">Contact Us</a></li>
                <li><a href="Service.php">Services</a></li>
            </ul>
                <button onclick="window.location.href='signup.php'">Get Started</button>
========
                <li><a href="Home.html"></a>Home</a></li>
                <li><a href="AboutUs.html">About Us</a></li>
                <li><a href="contactus.html">Contact Us</a></li>
                <li><a href="Services.html">Services</a></li>
            </ul>
             <div class="nav-actions">
                <div class="notification-bell">
                    <span class="bell-icon">🔔</span>
                    <span class="badge">3</span> <!-- Notification count -->
                </div>
                <button onclick="window.location.href='signup.html'">Get Started</button>
>>>>>>>> 0e6c3e459c89033f52e59e654b64ccc73df3444a:Home.php
            </div>
        </nav>
    </header>

    <!-- Intro Section -->
    <section class="intro">
        <div class="intro-content">
            <h1>Welcome to FixMySpace.lk – Your Trusted Home & Office Service Partner!</h1>
            <p>Find Verified Professionals for All Your Needs</p>
            <p>Struggling to find reliable home and office maintenance experts? FixMySpace.lk connects you with skilled professionals across Sri Lanka for services like masonry, carpentry, plumbing, electrical work, painting, and more.</p>
        </div>
        <img src="image/Home1.png" alt="Home Maintenance" class="intro-image">
    </section>

    <!-- Why Choose Us Section -->
    <section class="why-choose-us">
        <h2>Why Choose Us:</h2>
        <div class="features">
            <div class="feature">
                <img src="image/Home2.1.png" alt="Centralized Directory" class="feature-img">
                <p>Centralized Directory</p>
            </div>
            <div class="feature">
                <img src="image/Home2.2.png" alt="Verified Professionals" class="feature-img">
                <p>Verified Professionals</p>
            </div>
            <div class="feature">
                <img src="image/Home2.3.png" alt="User Reviews & Ratings" class="feature-img">
                <p>User Reviews & Ratings</p>
            </div>
            <div class="feature">
                <img src="image/Home2.4.png" alt="Fast & Easy Booking" class="feature-img">
                <p>Fast & Easy Booking</p>
            </div>
            <div class="feature">
                <img src="image/Home2.5.png" alt="Transparent Pricing" class="feature-img">
                <p>Transparent Pricing</p>
            </div>
        </div>
    </section>

    <!-- Our Services Section -->
    <section class="our-services">
        <h2>Our Services</h2>
        <div class="service-slider">
<<<<<<<< HEAD:Main.php
            <?php
            // Hardcoded image mapping for each service category
            $service_images = [
                1 => "Image/service3.2.jpg", // Electricians
                2 => "Image/service3.3.png", // Painters
                3 => "Image/mason1.5.jpg",   // Contractors
                4 => "Image/mason1.2.jpg",   // Cleaners
                5 => "Image/mason1.8.jpg",   // Movers
                6 => "Image/mason1.3.jpg",   // Vehicle repair specialists
                7 => "Image/mason1.6.jpg",   // Masons
                8 => "Image/mason1.4.jpg",   // Carpenters
                9 => "Image/service3.1.jpg", // Plumbers
            ];

            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "FixMySpacedb";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch latest service providers with service details
            $sql = "SELECT sp.sp_id, sp.f_name, sp.l_name, sp.image, sp.description, s.s_id AS service_id, s.name AS service_name 
                    FROM ServiceProvider sp
                    JOIN Service s ON sp.s_id = s.s_id
                    ORDER BY sp.sp_id DESC
                    LIMIT 3";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Get the hardcoded image for the service category
                    $service_id = $row['service_id'];
                    $image_path = $service_images[$service_id] ?? "Image/default.jpg"; // Use a default image if no mapping exists

                    echo "<div class='service-card'>";
                    echo "<img src='" . $image_path . "' alt='" . $row['service_name'] . "' class='service-img'>";
                    echo "<p class='service-desc'>" . $row['service_name'] . " - " . $row['f_name'] . " " . $row['l_name'] . "</p>";
                    echo "<p class='service-description'>" . $row['description'] . "</p>";
                    echo "<a href='view.php?id=" . $row['sp_id'] . "'><button class='view-btn'>View</button></a>";
                    echo "</div>";
                }
            } else {
                echo "<p>No service providers available right now.</p>";
            }

            $conn->close();
            ?>
========
            <button class="slider-btn">&lt;</button>
            <div class="service-card">
                <img src="image/service3.1.jpg" alt="Plumbing Services" class="service-img">
                <p class="service-desc">Plumbing Services</p>
                <button class="view-btn">View</button>
            </div>
            <div class="service-card">
                <img src="image/service3.2.jpg" alt="Electrical Repairs" class="service-img">
                <p class="service-desc">Electrical Repairs</p>
                <button class="view-btn">View</button>
            </div>
            <div class="service-card">
                <img src="image/service3.3.png" alt="Painting & Renovation" class="service-img">
                <p class="service-desc">Painting & Renovation</p>
                <button class="view-btn">View</button>
            </div>
            <button class="slider-btn">&gt;</button>
>>>>>>>> 0e6c3e459c89033f52e59e654b64ccc73df3444a:Home.php
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
<<<<<<<< HEAD:Main.php
                    <li><a href="Services.php">Our Services</a></li>
                    <li><a href="contactus.php">Contact Us</a></li>
========
                    <li><a href="#">Our Services</a></li>
                    <li><a href="#">Feedback</a></li>
                    <li><a href="contactus.html">Contact Us</a></li>
>>>>>>>> 0e6c3e459c89033f52e59e654b64ccc73df3444a:Home.php
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