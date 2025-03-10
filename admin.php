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
        <div class="search-container">
            <input type="text" class="search-bar" placeholder="Search...">
        </div>  
    </nav>

    <div class="container">
        <aside class="sidebar">
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#" id="userManagement">User Management</a></li>
                <li><a href="#">Post Management</a></li>
                <li><a href="#">Comment Management</a></li>
                <li><a href="#">Review Management</a></li>
                <li><a href="#">Requests</a></li>
                <li><a href="#" class="logout">Logout</a></li>
            </ul>
        </aside>

        <main class="content" id="content">
            <h1>Welcome to the Admin Panel</h1>
            <p>Select an option from the sidebar to manage the system.</p>

            
        </main>
    </div>

    <script>
        $(document).ready(function() {
            $('#userManagement').click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'fetch_users.php',
                    type: 'GET',
                    success: function(data) {
                        $('#content').html(data);
                    },
                    error: function() {
                        alert('Failed to fetch user data.');
                    }
                });
            });
        });
    </script>

</body>
</html>
