<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $type = $_POST['type'];

    // Determine the correct table
    if ($type == 'customer') {
        $query = "DELETE FROM customer WHERE c_id = ?";
    } else if ($type == 'service_provider') {
        $query = "DELETE FROM serviceprovider WHERE sp_id = ?";
    } else {
        echo "Invalid user type.";
        exit();
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "User deleted successfully!";
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
