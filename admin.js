// Load dashboard when clicking "Dashboard"
$('#dashboard').click(function (e) {
    e.preventDefault();
    
    $('#content').html(`
        <h1>Admin Dashboard</h1>
        <div class="dashboard-container">
            <div class="dashboard-card" id="totalCustomers">Loading...</div>
            <div class="dashboard-card" id="totalProviders">Loading...</div>
            <div class="dashboard-card" id="avgRating">Loading...</div>
        </div>
        
    `);

    fetchDashboardStats();
});


// Fetch dashboard statistics
function fetchDashboardStats() {
    $.ajax({
        url: 'fetch_dashboard_stats.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            // Update stats in the dashboard
            $('#totalCustomers').html(`<h3>Total Customers</h3><p>${data.total_customers}</p>`);
            $('#totalProviders').html(`<h3>Total Service Providers</h3><p>${data.total_providers}</p>`);
            $('#avgRating').html(`<h3>Average Rating</h3><p>${data.avg_rating}</p>`);


            // Populate upcoming schedules table
            var schedulesTable = $('#upcomingSchedulesTable');
            schedulesTable.find("tr:gt(0)").remove(); // Clear existing rows

            
        },
        error: function () {
            alert('Failed to load dashboard stats.');
        }
    });
}

// DASHBOARD ENDS 

$(document).ready(function() {
    // Event listener for "Contact Requests" button
    $('#contactRequest').click(function(e) {
        e.preventDefault();
        
        // Fetch contact requests and display in the content section
        $.ajax({
            url: 'fetch_contact_requests.php',
            type: 'GET',
            success: function(data) {
                $('#content').html(`
                    <h1>Contact Requests</h1>
                    <div id="contactTableContainer">${data}</div>
                `);
            },
            error: function() {
                alert('Failed to fetch contact requests.');
            }
        });
    });

    // Event listener for delete button (using event delegation)
    $(document).on('click', '.delete-btn', function() {
        var contactId = $(this).data('id');

        if (confirm('Are you sure you want to delete this contact request?')) {
            $.ajax({
                url: 'delete_contact_request.php',
                type: 'POST',
                data: { id: contactId },
                success: function(response) {
                    alert(response);
                    $('#contactRequest').click(); // Refresh the contact requests
                },
                error: function() {
                    alert('Failed to delete contact request.');
                }
            });
        }
    });
});


    
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
            url: 'fetch_service_providers_details.php',
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
    // Fetch all service providers first
    $.ajax({
        url: 'fetch_service_providers.php', // Backend script to fetch service providers
        type: 'GET',
        success: function (data) {
            // Display the list of service providers with a "View" button
            $('#reviewTable').html(`
                <h2>Service Providers</h2>
                <table border="1">
                    <tr>
                        <th>Service Provider ID</th>
                        <th>Name</th>
                        <th>Service</th>
                        <th>Action</th>
                    </tr>
                    ${data}
                </table>
            `);
        },
        error: function () {
            alert('Failed to fetch service providers.');
        }
    });
}

    // Event listener for "View" button to fetch reviews for a specific service provider
    $(document).on('click', '.view-reviews-btn', function () {
        var spId = $(this).data('id'); // Get the service provider ID

        // Fetch reviews for the selected service provider
        $.ajax({
            url: 'fetch_reviews_by_provider.php', // Backend script to fetch reviews by provider
            type: 'GET',
            data: { sp_id: spId },
            success: function (data) {
                // Display the reviews for the selected service provider
                $('#reviewTable').html(`
                    <h2>Reviews for Service Provider</h2>
                    <table border="1">
                        <tr>
                            <th>Review ID</th>
                            <th>Customer</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        ${data}
                    </table>
                `);
            },
            error: function () {
                alert('Failed to fetch reviews for this service provider.');
            }
        });
    });


    
// JavaScript to handle the "Add Service" sidebar option
$('#addService').click(function(e) {
    e.preventDefault(); // Prevent default link behavior
    
    // Dynamically load the add_service.php content into the #content div
    $('#content').html('<h1>Loading Add Service...</h1>'); // Optionally show loading text while fetching

    $.ajax({
        url: 'add_service.php', // Path to your PHP page
        type: 'GET',
        success: function(response) {
            $('#content').html(response); // Insert the response (HTML content) into the #content div
        },
        error: function() {
            $('#content').html('<p style="color: red;">Failed to load the page. Please try again.</p>');
        }
    });
});


// Event listener for logout click
$('.logout').click(function(e) {
e.preventDefault();  // Prevent default link behavior
window.location.href = 'logout.php';  // Redirect to logout.php
});
    