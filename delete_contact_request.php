<?php
include 'db_connection.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Prepare the SQL DELETE statement
    $query = "DELETE FROM contact_us WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Contact request deleted successfully.";
    } else {
        echo "Failed to delete contact request.";
    }

    $stmt->close();
    $conn->close();
}
?>
