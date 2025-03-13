<?php
// Assuming you already have your database connection set up
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user data from the POST request
    $userId = $_POST['userId'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Update the user data in the database
    $sql = "UPDATE Customer SET f_name = ?, l_name = ?, email = ?, phone = ? WHERE c_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $firstName, $lastName, $email, $phone, $userId);
    
    if ($stmt->execute()) {
        echo "User details updated successfully";
    } else {
        echo "Error updating user details";
    }

    $stmt->close();
    $conn->close();
}
?>
