<?php
session_start();
include 'connection.php';  // DB connection

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch sold items from the last month
$query = "
    SELECT i.*, 
           seller.first_name AS seller_name, 
           buyer.first_name AS buyer_name
    FROM item i
    JOIN ggc_store_users seller ON i.seller_id = seller.id
    JOIN ggc_store_users buyer ON i.buyer_id = buyer.id
    WHERE i.buyer_id IS NOT NULL 
      AND i.sold_date >= NOW() - INTERVAL 1 MONTH
    ORDER BY i.sold_date DESC
";

$result = mysqli_query($dbc, $query);
?>

<?php include 'admin_navbar.php'; 
include 'header.php';?>

<div class="admin-content">
    <h1>Sold Items (Past Month)</h1>

    <table>
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Seller</th>
                <th>Buyer</th>
                <th>Price</th>
                <th>Description</th>
                <th>Sold Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['seller_name']) ?></td>
                <td><?= htmlspecialchars($row['buyer_name']) ?></td>
                <td>$<?= number_format($row['price'], 2) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= date("M j, Y", strtotime($row['sold_date'])) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
