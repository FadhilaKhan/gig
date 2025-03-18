<?php
include 'db_connection.php'; // Include your database connection

$query = "SELECT id, c_id, user_email, message, created_at FROM contact_us ORDER BY created_at DESC";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table  class=contact border='1'>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Email</th>
                <th>Message</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['c_id']}</td>
                <td>{$row['user_email']}</td>
                <td>{$row['message']}</td>
                <td>{$row['created_at']}</td>
                <td>
                    <button class='delete-btn' data-id='{$row['id']}'>Delete</button>
                </td>
              </tr>";
    }
    
    echo "</table>";
} else {
    echo "No contact requests found.";
}

$conn->close();
?>
