<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_type'] == 'student') {
        header("Location: student_home.php");
    } elseif ($_SESSION['user_type'] == 'admin') {
        header("Location: admin_dashboard.php");
    }
    exit();
}

include 'nav.php';
include 'header.php';
?>

<h2>Login</h2>

<?php
// Show login error if it exists
if (isset($_SESSION['error'])) {
    echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}
?>

<form method="post" action="login_process.php">
    <!-- Email -->
    <label>Email:</label><br>
    <input type="email" name="email" value="<?= $_COOKIE['remember_email'] ?? '' ?>" required><br>

    <!-- Password -->
    <label>Password:</label><br>
    <input type="password" name="password" required><br>

    <!-- Remember Me -->
    <label>
        <input type="checkbox" name="remember_me" <?= isset($_COOKIE['remember_email']) ? 'checked' : '' ?>>
        Remember Me
    </label><br><br>

    <button type="submit">Login</button>
</form>

<p><a href="forgot_password.php">Forgot Password?</a></p>

<?php include 'footer.php'; ?>
