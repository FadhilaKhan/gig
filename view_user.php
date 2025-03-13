<?php

include 'db_connection.php';

// Check if an ID and user type are provided
if (!isset($_GET['id']) || !isset($_GET['type'])) {
    die("Invalid request.");
}

$id = intval($_GET['id']);
$type = $_GET['type'];
$type = $_GET['type']; // Can be 'customer' or 'serviceprovider'

// Fetch user details based on the type
if ($type === "customer") {
    $sql = "SELECT c_id AS id, f_name, l_name, email, phone FROM customer WHERE c_id = ?";
} else {
    $sql = "SELECT sp_id AS id, f_name, l_name, email, phone, work_status FROM serviceprovider WHERE sp_id = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User not found.");
}
?>

<form id="userForm" method="POST">
    <input type="hidden" name="user_id" value="<?= $id ?>">
    <input type="hidden" name="user_type" value="<?= $type ?>">

    <label>First Name:</label>
    <input type="text" name="f_name" value="<?= htmlspecialchars($user['f_name']) ?>" required><br>

    <label>Last Name:</label>
    <input type="text" name="l_name" value="<?= htmlspecialchars($user['l_name']) ?>" required><br>

    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br>

    <label>Phone:</label>
    <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required><br>

    <?php if ($type === "serviceprovider"): ?>
        <label>Work Status:</label>
        <select name="work_status">
            <option value="Active" <?= $user['work_status'] === "Active" ? "selected" : "" ?>>Active</option>
            <option value="Inactive" <?= $user['work_status'] === "Inactive" ? "selected" : "" ?>>Inactive</option>
        </select><br>
    <?php endif; ?>

    <button type="button" class="update-btn" onclick="updateUser()">Update</button>
    <button type="button" class="delete-btn" onclick="deleteUser()">Delete</button>
</form>

<script>
function updateUser() {
    $.ajax({
        url: "update_user.php",
        type: "POST",
        data: $("#userForm").serialize(),
        success: function(response) {
            alert(response);
            $("#userModal").fadeOut();
        }
    });
}

function deleteUser() {
    if (confirm("Are you sure you want to delete this user?")) {
        $.ajax({
            url: "delete_user.php",
            type: "POST",
            data: $("#userForm").serialize(),
            success: function(response) {
                alert(response);
                $("#userModal").fadeOut();
            }
        });
    }
}
</script>

// Handle DELETE Request
if (isset($_POST['delete'])) {
    if ($type === "customer") {
        $delete_sql = "DELETE FROM customer WHERE c_id = ?";
    } else {
        $delete_sql = "DELETE FROM serviceprovider WHERE sp_id = ?";
    }
    
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $id);
    
    if ($delete_stmt->execute()) {
        header("Location: fetch_users.php?message=User Deleted");
        exit();
    } else {
        echo "Error deleting user.";
    }
}

// Handle UPDATE Request
if (isset($_POST['update'])) {
    $f_name = $_POST['f_name'];
    $l_name = $_POST['l_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    if ($type === "customer") {
        $update_sql = "UPDATE customer SET f_name = ?, l_name = ?, email = ?, phone = ? WHERE c_id = ?";
    } else {
        $work_status = $_POST['work_status'];
        $update_sql = "UPDATE serviceprovider SET f_name = ?, l_name = ?, email = ?, phone = ?, work_status = ? WHERE sp_id = ?";
    }

    $update_stmt = $conn->prepare($update_sql);

    if ($type === "customer") {
        $update_stmt->bind_param("ssssi", $f_name, $l_name, $email, $phone, $id);
    } else {
        $update_stmt->bind_param("sssssi", $f_name, $l_name, $email, $phone, $work_status, $id);
    }

    if ($update_stmt->execute()) {
        echo "<script>alert('User updated successfully!'); window.location.href = 'fetch_users.php';</script>";
    } else {
        echo "Error updating user.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

    <div class="navbar">
        <div class="admin">Admin Panel</div>
    </div>

    <div class="content">
        <h2>User Profile</h2>
        <form method="POST">
            <label>First Name:</label>
            <input type="text" name="f_name" value="<?= htmlspecialchars($user['f_name']) ?>" required><br>

            <label>Last Name:</label>
            <input type="text" name="l_name" value="<?= htmlspecialchars($user['l_name']) ?>" required><br>

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br>

            <label>Phone:</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required><br>

            <?php if ($type === "serviceprovider"): ?>
                <label>Work Status:</label>
                <select name="work_status">
                    <option value="Active" <?= $user['work_status'] === "Active" ? "selected" : "" ?>>Active</option>
                    <option value="Inactive" <?= $user['work_status'] === "Inactive" ? "selected" : "" ?>>Inactive</option>
                </select><br>
            <?php endif; ?>

            <button type="submit" name="update" class="update-btn">Update</button>
            <button type="submit" name="delete" class="delete-btn" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
        </form>
    </div>

</body>
</html>

