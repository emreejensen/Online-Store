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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $query = "UPDATE item SET name=?, description=?, price=? WHERE item_id=?";
    $stmt = $dbc->prepare($query);
    $stmt->bind_param("ssdi", $name, $description, $price, $item_id);
    $stmt->execute();

    header("Location: admin_for_sale.php");
    exit();
}

$result = mysqli_query($dbc, "SELECT * FROM item WHERE item_id = $item_id");
$item = mysqli_fetch_assoc($result);
?>

<?php include 'admin_navbar.php'; 
include 'header.php';?>

<div class="admin-content">
    <h1>Edit Item</h1>
    <form method="post">
        <label>Item Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($item['name']) ?>" required>

        <label>Description:</label>
        <textarea name="description" required><?= htmlspecialchars($item['description']) ?></textarea>

        <label>Price:</label>
        <input type="number" name="price" step="0.01" value="<?= htmlspecialchars($item['price']) ?>" required>

        <button type="submit">Update Item</button>
    </form>
</div
