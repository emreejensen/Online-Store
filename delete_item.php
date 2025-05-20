<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$item_id = $_GET['id'] ?? null;
if (!$item_id) {
    echo "Invalid item ID.";
    exit();
}

$result = mysqli_query($dbc, "SELECT name FROM item WHERE item_id = $item_id");
$item = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $dbc->prepare("DELETE FROM item WHERE item_id = ?");
    $stmt->bind_param("i", $item_id);
    $stmt->execute();

    header("Location: admin_for_sale.php");
    exit();
}
?>

<?php include 'admin_navbar.php'; 
include 'header.php';?>

<div class="admin-content">
    <h1>Confirm Item Deletion</h1>
    <?php if ($item): ?>
        <p>Are you sure you want to delete the item <strong><?= htmlspecialchars($item['name']) ?></strong>?</p><br><br>
        <form method="post">
            <button type="submit" style="background-color: red;">Yes, Delete Item</button>
            <br><a href="admin_for_sale.php" style="margin-left: 15px;">Cancel</a>
        </form>
    <?php else: ?>
        <p>Item not found.</p>
        <a href="admin_for_sale.php">Back to Items</a>
    <?php endif; ?>
</div>
