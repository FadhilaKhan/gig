<?php
include 'db_connection.php';

if (isset($_GET['sp_id'])) {
    $spId = $_GET['sp_id'];

    $query = "
        SELECT 
            r.r_id, 
            c.f_name AS customer_name, 
            r.rating, 
            r.comment, 
            r.r_date 
        FROM Review r
        JOIN Customer c ON r.c_id = c.c_id
        WHERE r.sp_id = $spId
        ORDER BY r.r_date DESC
    ";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $output = '';
        while ($row = $result->fetch_assoc()) {
            $output .= "
                <tr>
                    <td>{$row['r_id']}</td>
                    <td>{$row['customer_name']}</td>
                    <td>{$row['rating']}</td>
                    <td>{$row['comment']}</td>
                    <td>{$row['r_date']}</td>
                    <td>
                        <button class='delete-review' data-id='{$row['r_id']}'>Delete</button>
                    </td>
                </tr>
            ";
        }
        echo $output;
    } else {
        echo "<tr><td colspan='6'>No reviews found for this service provider.</td></tr>";
    }
} else {
    echo "<tr><td colspan='6'>Invalid request.</td></tr>";
}

$conn->close();
?>