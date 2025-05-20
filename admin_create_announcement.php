<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($dbc, $_POST['title']);
    $body = mysqli_real_escape_string($dbc, $_POST['message']);

    $query = "INSERT INTO announcements (title, message) VALUES ('$title', '$body')";
    if (mysqli_query($dbc, $query)) {
        $message = "Announcement posted successfully!";
    } else {
        $message = "Error: " . mysqli_error($dbc);
    }
}
?>

<?php include 'admin_navbar.php'; 
include 'header.php';?>

<div class="admin-content">
    <h1>Create Announcement</h1>
    <?php if ($message): ?>
        <p><?= $message ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>

        <label for="message">Message:</label>
        <textarea name="message" id="message" rows="5" required></textarea>

        <button type="submit">Post Announcement</button>
    </form>
</div>
