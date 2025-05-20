<?php 
session_start(); // Add this if it’s not already at the top
include 'nav.php'; 
include 'header.php'; 
?>

<!-- Link to your shared CSS if it's not already in header.php -->
<link rel="stylesheet" href="style.css"> 

<h1>Welcome to GGC Online Store</h1>
<p>This is your campus marketplace for books, electronics, furniture, and more.</p>
<p>Browse available items freely. To buy or sell, please <a href="login.php">login</a> or <a href="register.php">register</a>.</p>

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


<!-- Optional: Show the 5 most recently listed items (Bonus feature) -->
<h3>Newest Listings</h3>
<div class="products-list">
<?php
include 'connection.php';
$query = "SELECT i.*, u.first_name FROM item i 
          JOIN ggc_store_users u ON i.seller_id = u.id 
          WHERE i.buyer_id IS NULL 
          ORDER BY i.upload_date DESC 
          LIMIT 5";
$result = $dbc->query($query);

if ($result->num_rows > 0) {
    while ($item = $result->fetch_assoc()) {
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

