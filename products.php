<?php
session_start();
include 'nav.php';
include 'header.php';
include 'connection.php';

$search = $_GET['search'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';
?>

<link rel="stylesheet" href="style.css">

<h2>Marketplace - Browse All Items</h2>

<!-- Search Form -->
<form method="get" action="products.php">
    <label>Search by Name:</label>
    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>">

    <label>Min Price:</label>
    <input type="number" name="min_price" step="0.01" value="<?= htmlspecialchars($min_price) ?>">

    <label>Max Price:</label>
    <input type="number" name="max_price" step="0.01" value="<?= htmlspecialchars($max_price) ?>">

    <label>From Date:</label>
    <input type="date" name="start_date" value="<?= htmlspecialchars($start_date) ?>">

    <label>To Date:</label>
    <input type="date" name="end_date" value="<?= htmlspecialchars($end_date) ?>">

    <br><br>
    <button type="submit">Search</button>
    <a href="products.php" class="btn" style="margin-left: 15px;">Clear</a>
</form>

<br>

<div class="products-list">
<?php
$query = "SELECT i.*, u.first_name 
          FROM item i 
          JOIN ggc_store_users u ON i.seller_id = u.id 
          WHERE i.buyer_id IS NULL";

$params = [];
$types = "";

if (!empty($search)) {
    $query .= " AND i.name LIKE ?";
    $params[] = "%" . $search . "%";
    $types .= "s";
}

if (!empty($min_price)) {
    $query .= " AND i.price >= ?";
    $params[] = $min_price;
    $types .= "d";
}

if (!empty($max_price)) {
    $query .= " AND i.price <= ?";
    $params[] = $max_price;
    $types .= "d";
}

if (!empty($start_date)) {
    $query .= " AND i.upload_date >= ?";
    $params[] = $start_date;
    $types .= "s";
}

if (!empty($end_date)) {
    $query .= " AND i.upload_date <= ?";
    $params[] = $end_date;
    $types .= "s";
}

$query .= " ORDER BY i.upload_date DESC";

// Prepare and execute
if (!empty($params)) {
    $stmt = $dbc->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $dbc->query($query);
}

// Display results
if ($result->num_rows === 0) {
    echo "<p>No items found.</p>";
} else {
    while ($item = $result->fetch_assoc()) {
        echo "<div class='product-card'>";
        echo "<img src='{$item['image_path']}' alt='{$item['name']}' width='120'><br>";
        echo "<h4>{$item['name']}</h4>";
        echo "<p>{$item['description']}</p>";
        echo "<p class='price'>\${$item['price']}</p>";
        echo "<p><em>Listed: {$item['upload_date']} | Seller: {$item['first_name']}</em></p>";
        echo "</div>";
    }
}

$dbc->close();
?>
</div>

<?php include 'footer.php'; ?>
