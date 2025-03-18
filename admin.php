<?php
// Start the session
session_start();

// Check if the user is logged in and if the user is an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    // Redirect to login page if not logged in as admin
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="admin.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
</head>
<body>

    <nav class="navbar">
        <div class="admin">ADMIN</div>
    </nav>

    <div class="container">
        <aside class="sidebar">
            <ul>
                <li><a href="#" id="dashboard">Dashboard</a></li>
                <li><a href="#" id="userManagement">User Management</a></li>
                <li><a href="#" id="reviewManagement">Review Management</a></li>
                <li><a href="#" id="contactRequest">Contact Request</a></li>
                <li><a href="#" id="addService">Service Management</a></li>
                <li><a href="#" class="logout">Logout</a></li>
            </ul>
        </aside>
    </div>

    <div id="content"></div>

    <!-- The Modal for displaying user details -->
    <div id="userModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>User Details</h2>
            <div id="userDetails"></div>
        </div>
    </div>


<script src="admin.js"></script>
</body>
</html>