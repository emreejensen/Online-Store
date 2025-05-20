<?php
session_start();
include 'connection.php';

// Ensure only admin can access
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Delete sold items older than 100 days
$query = "DELETE FROM item WHERE sold_date IS NOT NULL AND sold_date < (NOW() - INTERVAL 100 DAY)";
$result = mysqli_query($dbc, $query);

if ($result) {
    $count = mysqli_affected_rows($dbc);
    $message = "$count item(s) removed that were sold more than 100 days ago.";
} else {
    $message = "Error: " . mysqli_error($dbc);
}

?>

<?php include 'admin_navbar.php'; 
include 'header.php';?>

<div class="admin-content">
    <h1>Remove Old Sold Items</h1>
    <p><?= $message ?></p>
	<br>
    <a href="admin_dashboard.php" class="btn">Back to Dashboard</a>
</div>
