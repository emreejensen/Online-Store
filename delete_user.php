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

// Fetch user info to display
$result = mysqli_query($dbc, "SELECT first_name, last_name FROM ggc_store_users WHERE id = $user_id");
$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Confirm delete
    $stmt = $dbc->prepare("DELETE FROM ggc_store_users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    header("Location: admin_manage_users.php");
    exit();
}
?>

<?php include 'admin_navbar.php'; 
include 'header.php';?>

<div class="admin-content">
    <h1>Confirm Deletion</h1>
    <?php if ($user): ?>
        <p>Are you sure you want to delete the user <strong><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></strong>?</p><br><br>


        <form method="post">
            <button type="submit" style="background-color: red;">Yes, Delete User</button>
			<br>
            <a href="admin_manage_users.php" style="margin-left: 15px;">Cancel</a>
        </form>
    <?php else: ?>
        <p>User not found.</p>
        <a href="admin_manage_users.php">Back to Users</a>
    <?php endif; ?>
</div>
