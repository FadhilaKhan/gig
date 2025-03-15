<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php';

// Check database connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

// Fetch total customers
$customerQuery = "SELECT COUNT(*) AS total_customers FROM Customer";
$customerResult = $conn->query($customerQuery);
if (!$customerResult) {
    die(json_encode(["error" => "Customer Query Failed: " . $conn->error]));
}
$totalCustomers = $customerResult->fetch_assoc()['total_customers'];

// Fetch total service providers
$serviceQuery = "SELECT COUNT(*) AS total_providers FROM ServiceProvider";
$serviceResult = $conn->query($serviceQuery);
if (!$serviceResult) {
    die(json_encode(["error" => "Service Provider Query Failed: " . $conn->error]));
}
$totalProviders = $serviceResult->fetch_assoc()['total_providers'];

// Fetch total reviews
$reviewQuery = "SELECT COUNT(*) AS total_reviews FROM Review";
$reviewResult = $conn->query($reviewQuery);
if (!$reviewResult) {
    die(json_encode(["error" => "Review Query Failed: " . $conn->error]));
}
$totalReviews = $reviewResult->fetch_assoc()['total_reviews'];

// Fetch recent reviews
$recentReviewsQuery = "
    SELECT r.r_id, c.f_name AS customer, s.name AS service, r.rating, r.comment, r.r_date 
    FROM Review r
    JOIN Customer c ON r.c_id = c.c_id
    JOIN Service s ON r.s_id = s.s_id
    ORDER BY r.r_date DESC LIMIT 5";
$recentReviewsResult = $conn->query($recentReviewsQuery);

if (!$recentReviewsResult) {
    die(json_encode(["error" => "Recent Reviews Query Failed: " . $conn->error]));
}

$recentReviews = [];
while ($row = $recentReviewsResult->fetch_assoc()) {
    $recentReviews[] = $row;
}

// Return JSON response
echo json_encode([
    'totalCustomers' => $totalCustomers,
    'totalProviders' => $totalProviders,
    'totalReviews' => $totalReviews,
    'recentReviews' => $recentReviews
]);

$conn->close();
?>
