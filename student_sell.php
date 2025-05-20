<?php 
session_start();
include 'nav_student.php';
include 'header.php';
include 'connection.php'; // Make sure this file connects to your DB
?>

<!-- Link to Student-Specific CSS File -->
<link rel="stylesheet" href="student_style.css">

<h2>I Want to Sell</h2>

<?php
$user_id = $_SESSION['user_id'];

// Check how many items user has listed that aren't sold
$stmt = $dbc->prepare("SELECT COUNT(*) AS count FROM item WHERE seller_id = ? AND buyer_id IS NULL");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($itemCount);
$stmt->fetch();
$stmt->close();

// Only allow listing if under 5
if ($itemCount < 5):
?>

<!-- Form for listing items -->
<form method="post" action="list_item_process.php" enctype="multipart/form-data">
    <label>Item Name:</label><br>
    <input type="text" name="item_name" required><br>
    <label>Description:</label><br>
    <textarea name="item_description" required></textarea><br>
    <label>Price ($):</label><br>
    <input type="number" name="price" step="0.01" required><br>
    <label>Upload Image:</label><br>
    <input type="file" name="item_image" accept="image/*" required><br>
    <button type="submit">List Item for Sale</button>
</form>

<?php else: ?>
<p>You have reached the limit of 5 active items. Please wait until some items are sold or remove one.</p>
<?php endif; ?>

<hr>
<h3>Your Listed Items</h3>

<?php
// Fetch user's items
$stmt = $dbc->prepare("SELECT * FROM item WHERE seller_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<div class='item-card'>";
    echo "<img src='{$row['image_path']}' width='100'>";
    echo "<p><strong>{$row['name']}</strong></p>";
    echo "<p>\${$row['price']}</p>";
    echo "<p>Status: " . ($row['buyer_id'] ? "Sold" : "Available") . "</p>";
    echo "</div>";
}

$stmt->close();
$dbc->close();
?>

<?php include 'footer.php'; ?>