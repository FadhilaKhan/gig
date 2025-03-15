<?php
include 'db_connection.php';

$query = "
    SELECT 
        r.r_id, 
        c.f_name AS customer_name, 
        s.s_name AS service_name, 
        r.rating, 
        r.comment, 
        r.r_date 
    FROM Review r
    JOIN Customer c ON r.c_id = c.c_id
    JOIN Service s ON r.s_id = s.s_id
    ORDER BY r.r_date DESC
";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Review ID</th>
                <th>Customer</th>
                <th>Service</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Date</th>
                <th>Action</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['r_id']}</td>
                <td>{$row['customer_name']}</td>
                <td>{$row['service_name']}</td>
                <td>{$row['rating']}</td>
                <td>{$row['comment']}</td>
                <td>{$row['r_date']}</td>
                <td>
                    <button class='delete-review' data-id='{$row['r_id']}'>Delete</button>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No reviews found.";
}

$conn->close();
?>
