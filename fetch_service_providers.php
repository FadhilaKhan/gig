<?php
include 'db_connection.php';

$query = "SELECT sp_id, f_name, l_name, email FROM serviceprovider";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Action</th> <!-- Action Column for View -->
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['sp_id']}</td>
                <td>{$row['f_name']}</td>
                <td>{$row['l_name']}</td>
                <td>{$row['email']}</td>
                <td><button class='view-btn' data-id='{$row['sp_id']}' data-type='service_provider'>View</button></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No service provider records found.";
}

$conn->close();
?>
