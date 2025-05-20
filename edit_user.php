<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$user_id = $_GET['id'] ?? null;
if (!$user_id) {
    echo "Invalid user ID.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $user_type = $_POST['user_type'];

    $query = "UPDATE ggc_store_users SET first_name=?, last_name=?, email=?, phone=?, user_type=? WHERE id=?";
    $stmt = $dbc->prepare($query);
    $stmt->bind_param("sssssi", $first, $last, $email, $phone, $user_type, $user_id);
    $stmt->execute();

    header("Location: admin_manage_users.php");
    exit();
}

$result = mysqli_query($dbc, "SELECT * FROM ggc_store_users WHERE id = $user_id");
$user = mysqli_fetch_assoc($result);
?>

<?php include 'admin_navbar.php'; 
include 'header.php';?>

<div class="admin-content">
    <h1>Edit User</h1>
    <form method="post">
        <label>First Name:</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>

        <label>Last Name:</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Phone:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>

        <label>User Type:</label>
        <select name="user_type" required>
            <option value="student" <?= $user['user_type'] === 'student' ? 'selected' : '' ?>>Student</option>
            <option value="admin" <?= $user['user_type'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>

        <button type="submit">Update User</button>
    </form>
</div>
