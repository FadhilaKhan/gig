<?php
include 'db_connection.php';

// Fetch all customers
$query = "SELECT * FROM customer";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Customer ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Action</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['c_id']}</td>
                <td>{$row['f_name']}</td>
                <td>{$row['l_name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['address']}</td>
                <td>
                    <button class='view-btn' data-id='{$row['c_id']}' data-type='customer'>View</button>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No customers found.";
}

$conn->close();
?>
