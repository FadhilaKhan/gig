<?php
// Include database connection
include 'db_connection.php'; // Ensure this file correctly sets up $conn

// Fetch Customers
$customer_sql = "SELECT c_id, f_name, l_name, email, phone FROM customer";
$customer_result = $conn->query($customer_sql);

// Fetch Service Providers
$sp_sql = "SELECT sp_id, f_name, l_name, email, phone, work_status FROM serviceprovider";
$sp_result = $conn->query($sp_sql);
?>

<div class="user-management">
    <h2>User Management</h2>
    
    <!-- Toggle Buttons -->
    <div class="toggle-buttons">
        <button id="showCustomers" class="toggle-btn active">Customer Profile</button>
        <button id="showServiceProviders" class="toggle-btn">Service Provider Profile</button>
    </div>

    <!-- Customers Table -->
    <div id="customerTable">
        <h2>Customers</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $customer_result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['c_id']) ?></td>
                    <td><?= htmlspecialchars($row['f_name']) ?></td>
                    <td><?= htmlspecialchars($row['l_name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td>
                        <a href="view_user.php?id=<?= $row['c_id'] ?>&type=customer" class="view-btn">View</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Service Providers Table -->
    <div id="serviceProviderTable" style="display: none;">
        <h2>Service Providers</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Work Status</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $sp_result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['sp_id']) ?></td>
                    <td><?= htmlspecialchars($row['f_name']) ?></td>
                    <td><?= htmlspecialchars($row['l_name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= htmlspecialchars($row['work_status']) ?></td>
                    <td>
                        <a href="view_user.php?id=<?= $row['sp_id'] ?>&type=serviceprovider" class="view-btn">View</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<?php
$conn->close();
?>

<!-- JavaScript for Toggle Functionality -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#showCustomers").click(function() {
            $("#customerTable").show();
            $("#serviceProviderTable").hide();
            $("#showCustomers").addClass("active");
            $("#showServiceProviders").removeClass("active");
        });

        $("#showServiceProviders").click(function() {
            $("#serviceProviderTable").show();
            $("#customerTable").hide();
            $("#showServiceProviders").addClass("active");
            $("#showCustomers").removeClass("active");
        });
    });
</script>
