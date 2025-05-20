<?php
session_start();
include 'connection.php';  // Including the connection to the database

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch admin details
$admin_id = $_SESSION['user_id'];
$query = "SELECT * FROM ggc_store_users WHERE id = $admin_id";
$result = mysqli_query($dbc, $query);
$admin = mysqli_fetch_assoc($result);
?>

<?php include 'admin_navbar.php'; 
include 'header.php';?> <!-- Include the admin navbar -->

<div class="admin-content">
    <h1>Update Admin Profile</h1>
    <form action="update_profile_process.php" method="POST" enctype="multipart/form-data">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo $admin['first_name']; ?>" required>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo $admin['last_name']; ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $admin['email']; ?>" required>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo $admin['phone']; ?>" required>

        <button type="submit">Update Profile</button>
    </form>
</div>

</body>
</html>
