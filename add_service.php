<?php


include 'db_connection.php';

// Initialize variables
$message = "";

// Check for messages from DeleteService.php
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Clear the message after displaying it
}

// Handle form submission for adding a new service
if (isset($_POST['add_service'])) {
    $service_name = trim($_POST['service_name']);

    if (!empty($service_name)) {
        // Insert the new service into the database
        $insertQuery = "INSERT INTO service (name) VALUES (?)";
        $stmt = mysqli_prepare($conn, $insertQuery);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $service_name);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $message = "Service added successfully!";
        } else {
            $message = "Error adding service: " . mysqli_error($conn);
        }
    } else {
        $message = "Service name cannot be empty!";
    }
}

// Fetch all services to display below the form
$serviceQuery = "SELECT * FROM service";
$serviceResult = mysqli_query($conn, $serviceQuery);
$services = [];
while ($row = mysqli_fetch_assoc($serviceResult)) {
    $services[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Service</title>
    <link rel="stylesheet" href="AddService.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="add-service-container">
        <h2>Add a New Service</h2>
        <?php if (!empty($message)): ?>
            <p style="color: green; text-align: center;"><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="" method="POST" class="add-service-form">
            <input type="text" name="service_name" placeholder="Enter service name (e.g., Painting)" required>
            <button type="submit" name="add_service">Add Service</button>
        </form>

        <!-- Display Existing Services -->
        <div class="service-list">
            <h3>Existing Services</h3>
            <ul>
                <?php if (empty($services)): ?>
                    <li>No services available.</li>
                <?php else: ?>
                    <?php foreach ($services as $service): ?>
                        <li>
                            <span><?php echo htmlspecialchars($service['name']); ?></span>
                            <button onclick="deleteService(<?php echo $service['s_id']; ?>)">Delete</button>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <script>
        function deleteService(serviceId) {
            if (confirm("Are you sure you want to delete this service?")) {
                window.location.href = `DeleteService.php?s_id=${serviceId}`;
            }
        }
    </script>
</body>
</html>