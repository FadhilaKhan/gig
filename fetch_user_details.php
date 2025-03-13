<?php
include 'db_connection.php';

$id = $_GET['id'];
$type = $_GET['type'];

if ($type == 'customer') {
    $query = "SELECT * FROM customer WHERE c_id = $id";
} else if ($type == 'service_provider') {
    $query = "SELECT * FROM serviceprovider WHERE sp_id = $id";
}

$result = $conn->query($query);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<strong>First Name:</strong> <span id='firstName'>" . $row['f_name'] . "</span><br>";
    echo "<strong>Last Name:</strong> <span id='lastName'>" . $row['l_name'] . "</span><br>";
    echo "<strong>Email:</strong> <span id='email'>" . $row['email'] . "</span><br>";
    echo "<strong>Phone:</strong> <span id='phone'>" . $row['phone'] . "</span><br>";
    echo "<strong>Address:</strong> <span id='address'>" . $row['address'] . "</span><br>";
    echo "<strong>Image:</strong> <img src='" . $row['image'] . "' alt='User Image' style='max-width: 100px;'><br>";
    if ($type == 'service_provider') {
        echo "<strong>Description:</strong> <span id='description'>" . $row['description'] . "</span><br>";
        echo "<strong>Work Status:</strong> <span id='workStatus'>" . $row['work_status'] . "</span><br>";
    }
    echo "<button id='editBtn' class='edit-btn' data-id='$id' data-type='$type'>Edit</button>";
    echo "<button id='deleteBtn' class='delete-btn' data-id='$id' data-type='$type'>Delete</button>";

    // Add the edit form (hidden by default)
    echo "
    <div id='editForm' style='display:none;'>
        <form id='updateUserForm'>
            <label for='firstName'>First Name</label>
            <input type='text' id='editFirstName' name='firstName' value='" . $row['f_name'] . "' required>
            <label for='lastName'>Last Name</label>
            <input type='text' id='editLastName' name='lastName' value='" . $row['l_name'] . "' required>
            <label for='email'>Email</label>
            <input type='email' id='editEmail' name='email' value='" . $row['email'] . "' required>
            <label for='phone'>Phone</label>
            <input type='text' id='editPhone' name='phone' value='" . $row['phone'] . "' required>
            <label for='address'>Address</label>
            <input type='text' id='editAddress' name='address' value='" . $row['address'] . "' required>
            <button type='submit'>Save Changes</button>
        </form>
    </div>";
} else {
    echo "No details found.";
}

$conn->close();
?>
