<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $type = $_POST['type'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    if ($type == 'customer') {
        $query = "UPDATE customer SET f_name = '$firstName', l_name = '$lastName', email = '$email', phone = '$phone', address = '$address' WHERE c_id = $id";
    } else if ($type == 'service_provider') {
        $query = "UPDATE serviceprovider SET f_name = '$firstName', l_name = '$lastName', email = '$email', phone = '$phone', address = '$address' WHERE sp_id = $id";
    }

    if ($conn->query($query) === TRUE) {
        echo "User details updated successfully.";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
