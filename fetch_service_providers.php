<?php
include 'db_connection.php';

$query = "
    SELECT 
        sp.sp_id, 
        sp.f_name, 
        sp.l_name, 
        s.name AS service_name 
    FROM ServiceProvider sp
    JOIN Service s ON sp.s_id = s.s_id
    ORDER BY sp.sp_id ASC
";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    $output = '';
    while ($row = $result->fetch_assoc()) {
        $output .= "
            <tr>
                <td>{$row['sp_id']}</td>
                <td>{$row['f_name']} {$row['l_name']}</td>
                <td>{$row['service_name']}</td>
                <td>
                    <button class='view-reviews-btn' data-id='{$row['sp_id']}'>View Reviews</button>
                </td>
            </tr>
        ";
    }
    echo $output;
} else {
    echo "<tr><td colspan='4'>No service providers found.</td></tr>";
}

$conn->close();
?>