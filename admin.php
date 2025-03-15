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
                <li><a href="#">Dashboard</a></li>
                <li><a href="#" id="userManagement">User Management</a></li>
                <li><a href="#"id="reviewManagement">Review Management</a></li>
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


<script>

    
$(document).ready(function() {
    // Event listener for "View" button
    $(document).on('click', '.view-btn', function() {
        var userId = $(this).data('id');
        var userType = $(this).data('type');
        
        // Fetch user details based on type (customer or service provider)
        $.ajax({
            url: 'fetch_user_details.php',
            type: 'GET',
            data: { id: userId, type: userType },
            success: function(data) {
                $('#userDetails').html(data);
                $('#userModal').show(); // Show the modal
            },
            error: function() {
                alert('Failed to fetch user details.');
            }
        });
    });

    // Event listener for the "Edit" button
    $(document).on('click', '#editBtn', function() {
        // Show the edit form
        $('#editForm').show();
        $('#editBtn').hide(); // Hide the "Edit" button
    });

    // Submit the edit form to update user details
    $('#updateUserForm').submit(function(e) {
        e.preventDefault();

        var userId = $('#editBtn').data('id');
        var userType = $('#editBtn').data('type');
        
        // Collect the form data
        var formData = $(this).serialize();
        formData += '&id=' + userId + '&type=' + userType;

        $.ajax({
            url: 'update_user_details.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                alert(response);
                // Close the modal and refresh the data
                $('#userModal').hide();
                location.reload();
            },
            error: function() {
                alert('Failed to update user details.');
            }
        });
    });

    // Close the modal when the "X" is clicked
    $('.close-btn').click(function() {
        $('#userModal').hide();
    });
    });

    $(document).on('click', '#deleteBtn', function () {
    var userId = $(this).data('id');
    var userType = $(this).data('type');

    if (confirm('Are you sure you want to delete this user?')) {
        $.ajax({
            url: 'delete_user.php',  // Backend script to delete the user
            type: 'POST',
            data: { id: userId, type: userType },
            success: function (response) {
                alert(response); // Show success message
                $('#userModal').hide(); // Hide the modal
                location.reload(); // Refresh the page to reflect deletion
            },
            error: function () {
                alert('Failed to delete user.');
            }
            });
        }
    });

    
    $('#userManagement').click(function (e) {
        e.preventDefault();
        
        $('#content').html(`
            <h1>User Management</h1>
            <div class="toggle-buttons">
                <button id="customerProfileBtn" class="toggle-btn">Customer Profile</button>
                <button id="serviceProviderProfileBtn" class="toggle-btn">Service Provider Profile</button>
            </div>
            <div id="userTable"></div>
        `);
    });


    // Use event delegation to handle dynamically added buttons
    $(document).on('click', '#customerProfileBtn', function () {
        fetchCustomers();
    });

    $(document).on('click', '#serviceProviderProfileBtn', function () {
        fetchServiceProviders();
    });

    // Function to fetch Customer Data
    function fetchCustomers() {
        $.ajax({
            url: 'fetch_customers.php',
            type: 'GET',
            success: function (data) {
                $('#userTable').html(data);
            },
            error: function () {
                alert('Failed to fetch customer data.');
            }
        });
    }

    // Function to fetch Service Provider Data
    function fetchServiceProviders() {
        $.ajax({
            url: 'fetch_service_providers.php',
            type: 'GET',
            success: function (data) {
                $('#userTable').html(data);
            },
            error: function () {
                alert('Failed to fetch service provider data.');
            }
        });
    }

    $('#reviewManagement').click(function (e) {
    e.preventDefault();
    
    $('#content').html('<h1>Review Management</h1><div id="reviewTable"></div>');

        fetchReviews();
    });

    // Function to fetch reviews
    function fetchReviews() {
        $.ajax({
            url: 'view.php',
            type: 'GET',
            success: function (data) {
                $('#reviewTable').html(data);
            },
            error: function () {
                alert('Failed to fetch reviews.');
            }
        });
    }

    $(document).on('click', '.delete-review', function () {
    var reviewId = $(this).data('id');
        if (confirm('Are you sure you want to delete this review?')) {
            $.ajax({
                url: 'delete_review.php',
                type: 'POST',
                data: { id: reviewId },
                success: function (response) {
                    alert(response);
                    fetchReviews(); // Refresh the review list
                },
                error: function () {
                    alert('Failed to delete review.');
                }
            });
            }
    });


        // Event listener for logout click
        $('.logout').click(function(e) {
                e.preventDefault();  // Prevent default link behavior
                window.location.href = 'logout.php';  // Redirect to logout.php
        });
</script>

</body>
</html>