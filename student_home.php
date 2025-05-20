<?php
session_start();
include 'nav_student.php';
include 'header.php';
include 'connection.php';  // Needed for announcements and item queries
?>

<!-- Link to Student-Specific CSS File -->
<link rel="stylesheet" href="student_style.css">

<h2>Welcome to Your Dashboard!</h2>
<p>Welcome back, <?php echo $_SESSION['user_first_name']; ?>! Here’s a quick overview of what you can do:</p>
<ul>
    <li><a href="student_sell.php">I Want to Sell</a> - List items you want to sell.</li>
    <li><a href="student_buy.php">I Want to Buy</a> - Browse items for sale and add them to your shopping cart.</li>
    <li><a href="student_transactions.php">Transaction History</a> - View all items you have sold or purchased.</li>
    <li><a href="student_profile.php">Update My Profile</a> - Update your contact info and profile picture.</li>
</ul>

<!-- ✅ New: Latest Announcements -->
<h3>Latest Announcements</h3>
<?php
$announcementQuery = "SELECT * FROM announcements ORDER BY created_at DESC LIMIT 5";
$announcementResult = mysqli_query($dbc, $announcementQuery);

if (mysqli_num_rows($announcementResult) > 0): ?>
    <ul>
        <?php while ($row = mysqli_fetch_assoc($announcementResult)): ?>
            <li><strong><?= htmlspecialchars($row['title']) ?>:</strong> <?= htmlspecialchars($row['message']) ?></li>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>No announcements at this time.</p>
<?php endif; ?>

<h3>Featured Items</h3>
<div class="products-list">
<?php
include 'connection.php';
$featured = $dbc->query("SELECT * FROM item WHERE featured = 1 AND buyer_id IS NULL ORDER BY upload_date DESC LIMIT 5");

while ($item = $featured->fetch_assoc()) {
    echo "<div class='product-card'>";
    echo "<img src='{$item['image_path']}' alt='Item Image' width='120'><br>";
    echo "<strong>{$item['name']}</strong><br>";
    echo "<p>\${$item['price']}</p>";
    echo "</div>";
}
?>
</div>

<!-- ✅ Bonus: Show the 5 most recently listed items -->
<h3>Newest Listings</h3>
<div class="products-list">
<?php
$itemQuery = "SELECT i.*, u.first_name FROM item i 
              JOIN ggc_store_users u ON i.seller_id = u.id 
              WHERE i.buyer_id IS NULL 
              ORDER BY i.upload_date DESC 
              LIMIT 5";
$itemResult = $dbc->query($itemQuery);

if ($itemResult->num_rows > 0) {
    while ($item = $itemResult->fetch_assoc()) {
        echo "<div class='product-card'>";
        echo "<img src='{$item['image_path']}' width='100'><br>";
        echo "<strong>{$item['name']}</strong><br>";
        echo "<p>\${$item['price']}<br>Seller: {$item['first_name']}</p>";
        echo "</div>";
    }
} else {
    echo "<p>No recent items listed yet.</p>";
}

$dbc->close();
?>
</div>

<?php include 'footer.php'; ?>
