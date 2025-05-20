<?php
session_start();
include 'nav_student.php';
include 'header.php';
include 'connection.php'; // Connects using $dbc
?>

<!-- Link to Student-Specific CSS File -->
<link rel="stylesheet" href="student_style.css">

<h2>Transaction History</h2>

<?php
if (isset($_GET['purchased'])) {
    echo "<p style='color: green;'>Purchase completed successfully!</p>";
}

$user_id = $_SESSION['user_id'];

// Fetch bought items
$boughtQuery = "SELECT i.*, u.first_name AS seller_name 
                FROM item i 
                JOIN ggc_store_users u ON i.seller_id = u.id
                WHERE i.buyer_id = ?";
$boughtStmt = $dbc->prepare($boughtQuery);
$boughtStmt->bind_param("i", $user_id);
$boughtStmt->execute();
$boughtItems = $boughtStmt->get_result();

// Fetch sold items
$soldQuery = "SELECT i.*, u.first_name AS buyer_name 
              FROM item i 
              JOIN ggc_store_users u ON i.buyer_id = u.id
              WHERE i.seller_id = ? AND i.buyer_id IS NOT NULL";
$soldStmt = $dbc->prepare($soldQuery);
$soldStmt->bind_param("i", $user_id);
$soldStmt->execute();
$soldItems = $soldStmt->get_result();
?>

<h3>Items You Bought</h3>
<div class="transaction-list">
<?php
if ($boughtItems->num_rows > 0) {
    while ($row = $boughtItems->fetch_assoc()) {
        echo "<div class='transaction-item'>";
        echo "<img src='{$row['image_path']}' width='100'>";
        echo "<p><strong>{$row['name']}</strong> - \${$row['price']}</p>";
        echo "<p>Seller: {$row['seller_name']}</p>";
        echo "<p>Purchased on: {$row['sold_date']}</p>";
        echo "</div>";
    }
} else {
    echo "<p>You haven’t bought any items yet.</p>";
}
?>
</div>

<h3>Items You Sold</h3>
<div class="transaction-list">
<?php
if ($soldItems->num_rows > 0) {
    while ($row = $soldItems->fetch_assoc()) {
        echo "<div class='transaction-item'>";
        echo "<img src='{$row['image_path']}' width='100'>";
        echo "<p><strong>{$row['name']}</strong> - \${$row['price']}</p>";
        echo "<p>Buyer: {$row['buyer_name']}</p>";
        echo "<p>Sold on: {$row['sold_date']}</p>";
        echo "</div>";
    }
} else {
    echo "<p>You haven’t sold any items yet.</p>";
}
?>
</div>

<?php 
$dbc->close();
include 'footer.php'; 
?>
