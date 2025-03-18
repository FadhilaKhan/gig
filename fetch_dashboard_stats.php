<?php
header('Content-Type: application/json');
require 'db_connection.php'; // Include the database connection

// Fetch total customers
$total_customers = $conn->query("SELECT COUNT(*) AS total FROM customer")->fetch_assoc()['total'];

// Fetch total service providers
$total_providers = $conn->query("SELECT COUNT(*) AS total FROM serviceprovider")->fetch_assoc()['total'];

// Fetch total service requests
$total_requests = $conn->query("SELECT COUNT(*) AS total FROM service_requests")->fetch_assoc()['total'];

// Fetch pending service requests
$pending_requests = $conn->query("SELECT COUNT(*) AS total FROM service_requests WHERE status = 'pending'")->fetch_assoc()['total'];

// Fetch completed services
$completed_services = $conn->query("SELECT COUNT(*) AS total FROM schedule WHERE status = 'Completed'")->fetch_assoc()['total'];

// Fetch average rating of service providers
$avg_rating_result = $conn->query("SELECT AVG(rating) AS avg_rating FROM review");
$avg_rating = $avg_rating_result->num_rows > 0 ? round($avg_rating_result->fetch_assoc()['avg_rating'], 2) : 0;

// Fetch recent messages
$messages_query = $conn->query("SELECT user_email, message, created_at FROM contact_us ORDER BY created_at DESC LIMIT 5");
$messages = [];
while ($row = $messages_query->fetch_assoc()) {
    $messages[] = $row;
}

// Fetch upcoming schedules
$schedules_query = $conn->query("SELECT * FROM schedule WHERE scheduled_date >= CURDATE() ORDER BY scheduled_date ASC LIMIT 5");
$schedules = [];
while ($row = $schedules_query->fetch_assoc()) {
    $schedules[] = $row;
}

// Return JSON response
$response = [
    "total_customers" => $total_customers,
    "total_providers" => $total_providers,
    "total_requests" => $total_requests,
    "pending_requests" => $pending_requests,
    "completed_services" => $completed_services,
    "avg_rating" => $avg_rating,
    "recent_messages" => $messages,
    "upcoming_schedules" => $schedules
];

echo json_encode($response);

// Close the database connection
$conn->close();
?>
