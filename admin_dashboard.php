<?php
session_start();
include 'connection.php';  // Including the connection to the database

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Your admin-specific logic here (e.g., fetching data to display)
?>

<?php include 'admin_navbar.php'; 
include 'header.php';?> <!-- Include the admin navbar -->

<div class="admin-content">
    <h1>Welcome to the Admin Dashboard</h1>
    <p>Here you can manage all aspects of the site, including users, items for sale, and more.</p>
</div>

</body>
</html>
