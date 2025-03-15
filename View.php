<?php
session_start();
// It's optional to require login to view provider details; here we allow anyone to view details.
// But the booking action will check login.

if (!isset($_GET['id'])) {
    echo "<p>Invalid request.</p>";
    exit;
}
$sp_id = intval($_GET['id']);

include('db_connection.php'); // Ensure this sets up $conn

// Fetch the service provider's details
$query = "SELECT * FROM ServiceProvider WHERE sp_id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("<p>Database query preparation failed. Please try again later.</p>");
}
$stmt->bind_param("i", $sp_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Provider Details - FixMySpace</title>
    <link rel="stylesheet" href="Home.css">
    <link rel="stylesheet" href="Services.css">
    <link rel="stylesheet" href="View.css">
    <link rel="stylesheet" href="book-service.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
        // Pass PHP login status to JavaScript
        var isLoggedIn = <?php echo (isset($_SESSION['user_id']) && isset($_SESSION['user_type']) && $_SESSION['user_type']=='customer') ? 'true' : 'false'; ?>;
        function checkLoginBeforeAction(url) {
            if (isLoggedIn) {
                window.location.href = url;
                return true;
            } else {
                alert("Registration Successful");
                window.location.href = "signup.php";
                return false;
            }
        }
    </script>
</head>
<body>
    <header>
        <nav>
            <div class="logo">FixMySpace</div>
            <ul>
                <li><a href="Home.php">Home</a></li>
                <li><a href="AboutUs.html">About Us</a></li>
                <li><a href="contactus.php">Contact Us</a></li>
                <li><a href="Services.php">Services</a></li>
            </ul>
        </nav>
    </header>
    <section class="service-details">
        <?php
        if ($row = $result->fetch_assoc()) {
            echo '
            <div class="service-info">
                <div class="image-placeholder"><img src="' . htmlspecialchars($row['image']) . '" alt="Service Provider Image"></div>
                <div class="details">
                    <h2>' . htmlspecialchars($row['f_name']) . ' ' . htmlspecialchars($row['l_name']) . '</h2>
                    <p><strong>Working Hours:</strong> 9 AM - 5 PM</p>
                    <p><strong>Contact Number:</strong> ' . htmlspecialchars($row['phone']) . '</p>
                    <p><strong>Work:</strong> ' . htmlspecialchars($row['work_status']) . '</p>
                    <p><strong>Location:</strong> ' . htmlspecialchars($row['address']) . '</p>
                    <p><strong>Description:</strong> ' . htmlspecialchars($row['description'] ?? 'No description available') . '</p>
                    <button class="book-service-btn" onclick="checkLoginBeforeAction(\'book-service.php?id=' . $sp_id . '\')">Book Service</button>
                </div>
            </div>';
        } else {
            echo "<p>Service provider not found.</p>";
        }
        $stmt->close();
        ?>
    </section>
    <!-- Ratings & Reviews Section -->
    <section class="ratings-reviews">
        <h2>Ratings & Reviews</h2>
        <?php
        $review_query = "SELECT r.rating, r.comment, r.r_date, c.f_name, c.l_name 
                         FROM Review r 
                         JOIN Customer c ON r.c_id = c.c_id 
                         WHERE r.sp_id = ? 
                         ORDER BY r.r_date DESC";
        $review_stmt = $conn->prepare($review_query);
        if (!$review_stmt) {
            die("<p>Database query preparation failed. Please try again later.</p>");
        }
        $review_stmt->bind_param("i", $sp_id);
        $review_stmt->execute();
        $review_result = $review_stmt->get_result();
        if ($review_result->num_rows > 0) {
            while ($review_row = $review_result->fetch_assoc()) {
                echo '
                <div class="review">
                    <div class="user-info">
                        <span class="username">' . htmlspecialchars($review_row['f_name']) . ' ' . htmlspecialchars($review_row['l_name']) . '</span>
                        <span class="stars">' . str_repeat('★', $review_row['rating']) . str_repeat('☆', 5 - $review_row['rating']) . '</span>
                    </div>
                    <p class="comment">' . htmlspecialchars($review_row['comment']) . '</p>
                    <p class="review-date">' . htmlspecialchars($review_row['r_date']) . '</p>
                </div>';
            }
        } else {
            echo "<p>No reviews found for this service provider.</p>";
        }
        $review_stmt->close();
        $conn->close();
        ?>
    </section>
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
