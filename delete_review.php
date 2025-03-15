<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reviewId = $_POST['id'];

    $query = "DELETE FROM Review WHERE r_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $reviewId);

    if ($stmt->execute()) {
        echo "Review deleted successfully!";
    } else {
        echo "Error deleting review: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
