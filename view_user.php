<?php
include 'db_connection.php';

if (!isset($_GET['id']) || !isset($_GET['type'])) {
    die("Invalid request.");
}

$id = intval($_GET['id']);
$type = $_GET['type'];

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
