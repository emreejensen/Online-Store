<?php
session_start();
include 'header.php';
include 'nav_student.php';
include 'connection.php';

$cart = $_SESSION['cart'] ?? [];
?>

<h2>Your Cart</h2>

<?php if (empty($cart)): ?>
    <p>Your cart is empty.</p>
<?php else: ?>
    <form method="post" action="purchase_cart.php">
        <div class="products-list">
            <?php
            $placeholders = implode(',', array_fill(0, count($cart), '?'));
            $types = str_repeat('i', count($cart));
            $stmt = $dbc->prepare("SELECT i.*, u.first_name FROM item i JOIN ggc_store_users u ON i.seller_id = u.id WHERE i.item_id IN ($placeholders)");
            $stmt->bind_param($types, ...$cart);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($item = $result->fetch_assoc()) {
                echo "<div class='product-card'>";
                echo "<img src='{$item['image_path']}' width='100'><br>";
                echo "<h4>{$item['name']}</h4>";
                echo "<p>\${$item['price']}</p>";
                echo "<p>Seller: {$item['first_name']}</p>";
                echo "<button type='submit' name='remove' value='{$item['item_id']}'>Remove</button>";
                echo "</div>";
            }

            $stmt->close();
            ?>
        </div>
        <br>
        <button type="submit" name="checkout">Purchase All Items</button>
    </form>
<?php endif; ?>

<?php include 'footer.php'; ?>
