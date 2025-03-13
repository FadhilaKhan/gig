<?php
// Include database connection
include('db_connection.php');

// Query to fetch all reviews
$sql = "SELECT r.r_id, r.rating, r.comment, r.r_date, 
               c.full_name AS customer_name, s.service_name AS service_name 
        FROM Review r
        JOIN Customer c ON r.c_id = c.c_id
        JOIN Service s ON r.s_id = s.s_id
        ORDER BY r.r_date DESC";

$result = $conn->query($sql);

// Check if there are any reviews
if ($result->num_rows > 0) {
    // Display the reviews in a table
    echo '<table border="1">
            <thead>
                <tr>
                    <th>Review ID</th>
                    <th>Customer Name</th>
                    <th>Service Name</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Review Date</th>
                </tr>
            </thead>
            <tbody>';
    
    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>' . $row['r_id'] . '</td>
                <td>' . $row['customer_name'] . '</td>
                <td>' . $row['service_name'] . '</td>
                <td>' . $row['rating'] . '</td>
                <td>' . $row['comment'] . '</td>
                <td>' . $row['r_date'] . '</td>
              </tr>';
    }

    echo '</tbody>
          </table>';
} else {
    echo 'No reviews found.';
}

$conn->close();
?>
