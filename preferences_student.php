<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'student') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    setcookie("theme", $_POST['theme'], time() + (86400 * 30), "/");
    setcookie("font_size", $_POST['font_size'], time() + (86400 * 30), "/");
    header("Location: student_home.php");
    exit();
}

$theme = $_COOKIE['theme'] ?? 'light';
$fontSize = $_COOKIE['font_size'] ?? 'medium';

include 'nav_student.php';
include 'header.php';

?>

<div class="container">
    <h2>Customize Your Display</h2>
    <form method="post">
        <label for="theme">Theme:</label>
        <select name="theme" id="theme">
            <option value="light" <?= $theme === 'light' ? 'selected' : '' ?>>Light</option>
            <option value="dark" <?= $theme === 'dark' ? 'selected' : '' ?>>Dark</option>
        </select>

        <label for="font_size">Font Size:</label>
        <select name="font_size" id="font_size">
            <option value="small" <?= $fontSize === 'small' ? 'selected' : '' ?>>Small</option>
            <option value="medium" <?= $fontSize === 'medium' ? 'selected' : '' ?>>Medium</option>
            <option value="large" <?= $fontSize === 'large' ? 'selected' : '' ?>>Large</option>
        </select>

        <br><br>
        <button type="submit">Save Preferences</button>
    </form>
</div>

<?php include 'footer.php'; ?>
