<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$query = "SELECT i.*, u.first_name FROM item i 
          JOIN ggc_store_users u ON i.seller_id = u.id 
          WHERE i.buyer_id IS NULL 
          ORDER BY i.upload_date DESC";

$result = mysqli_query($dbc, $query);
?>

<?php include 'admin_navbar.php'; 
include 'header.php';?>

<div class="admin-content">
    <h1>Items For Sale</h1>
    <table>
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Seller</th>
                <th>Price</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['first_name']) ?></td>
                <td>$<?= number_format($row['price'], 2) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td>
                    <a href="edit_item.php?id=<?= $row['item_id'] ?>">Edit</a> |
                    <a href="delete_item.php?id=<?= $row['item_id'] ?>">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
