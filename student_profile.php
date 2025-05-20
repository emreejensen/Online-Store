<?php
session_start(); // Must be at the VERY TOP — no spaces above this line!
include 'nav_student.php';
include 'header.php';
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch current user info
$query = "SELECT first_name, last_name, phone, email, profile_pic FROM ggc_store_users WHERE id = ?";
$stmt = $dbc->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $phone, $email, $profile_pic);
$stmt->fetch();
$stmt->close();
?>

<link rel="stylesheet" href="student_style.css">

<h2>Update My Profile</h2>

<?php if (isset($_GET['success'])): ?>
    <p style="color: green;">Profile updated successfully!</p>
<?php endif; ?>

<form method="post" action="update_profile_process.php" enctype="multipart/form-data">
    <label>First Name:</label><br>
    <input type="text" name="first_name" value="<?= htmlspecialchars($first_name ?? '') ?>" required><br>

    <label>Last Name:</label><br>
    <input type="text" name="last_name" value="<?= htmlspecialchars($last_name ?? '') ?>" required><br>

    <label>Phone:</label><br>
    <input type="text" name="phone" value="<?= htmlspecialchars($phone ?? '') ?>" required><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required><br>

    <label>Profile Picture:</label><br>
    <input type="file" name="profile_pic" accept="image/*"><br>

    <label>New Password:</label><br>
    <input type="password" name="new_password"><br>

    <label>Confirm New Password:</label><br>
    <input type="password" name="confirm_password"><br><br>

    <button type="submit">Update Profile</button>
</form>

<?php include 'footer.php'; ?>
