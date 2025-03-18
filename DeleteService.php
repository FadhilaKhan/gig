<?php


include 'db_connection.php';

if (isset($_GET['s_id'])) {
    $service_id = intval($_GET['s_id']); 

    // Delete the service from the database
    $deleteQuery = "DELETE FROM service WHERE s_id = ?";
    $stmt = mysqli_prepare($conn, $deleteQuery);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $service_id);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Service deleted successfully!"; 
        } else {
            $_SESSION['message'] = "Error deleting service: " . mysqli_error($conn); 
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['message'] = "Error preparing delete statement: " . mysqli_error($conn); 
    }
} else {
    $_SESSION['message'] = "Invalid request! No service ID provided."; 
}

header("Location: admin.php");
exit();
?>