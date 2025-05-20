<?php
// This file should be included on the pages that require the admin navbar
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_styles.css"> <!-- Link to the CSS file -->
</head>
<body>

<!-- Admin Navbar -->
<nav class="admin-navbar">
    <div class="navbar-logo">
        <a href="admin_dashboard.php">Admin Panel</a>  <!-- Link to admin dashboard -->
    </div>
    <ul class="navbar-links">
		<li><a href="admin_featured_items.php">Featured Items</a></li>
        <li><a href="admin_for_sale.php">Items For Sale</a></li>
        <li><a href="admin_sold_items.php">Sold Items</a></li>
        <li><a href="admin_manage_users.php">Manage Users</a></li>
        <li><a href="admin_create_announcement.php">Create Announcement</a></li>
		<li><a href="remove_old_items.php">Remove Old Sold Items</a></li>
        <li><a href="admin_profile.php">Profile</a></li>
		<li><a href="preferences_admin.php">Preferences</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<!-- Admin content goes here -->
<div class="admin-content">
    <!-- Content based on the page -->
</div>

</body>
</html>
