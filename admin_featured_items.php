<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle'])) {
    $itemId = $_POST['item_id'];
    $isFeatured = $_POST['current'] === '1' ? 0 : 1;

    $stmt = $dbc->prepare("UPDATE item SET featured = ? WHERE item_id = ?");
    $stmt->bind_param("ii", $isFeatured, $itemId);
    $stmt->execute();
}

$result = $dbc->query("SELECT i.*, u.first_name FROM item i JOIN ggc_store_users u ON i.seller_id = u.id ORDER BY i.upload_date DESC");
?>

<?php include 'admin_navbar.php'; include 'header.php';?>

<div class="admin-content">
    <h1>Manage Featured Items</h1>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Seller</th>
                <th>Price</th>
                <th>Featured?</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($item = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= htmlspecialchars($item['first_name']) ?></td>
                    <td>$<?= number_format($item['price'], 2) ?></td>
                    <td><?= $item['featured'] ? '✅ Yes' : '❌ No' ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">
                            <input type="hidden" name="current" value="<?= $item['featured'] ?>">
                            <button type="submit" name="toggle">Toggle</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
