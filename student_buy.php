<?php
session_start();
include 'nav_student.php';
include 'header.php';
include 'connection.php';

$user_id = $_SESSION['user_id'] ?? null;

// Capture filter values from URL
$search = $_GET['search'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';
?>

<link rel="stylesheet" href="student_style.css">

<h2>I Want to Buy</h2>

<!-- Filter/Search Form -->
<form method="get" action="student_buy.php">
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
    <a href="student_buy.php" class="btn" style="margin-left: 15px;">Clear</a>
    <a href="cart.php" class="btn" style="margin-left: 15px;">View Cart</a>
</form>

<br>

<div class="products-list">
<?php
// Build dynamic SQL query
$query = "SELECT i.*, u.first_name 
          FROM item i 
          JOIN ggc_store_users u ON i.seller_id = u.id 
          WHERE i.buyer_id IS NULL AND i.seller_id != ?";

$params = [$user_id];
$types = "i";

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
$stmt = $dbc->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>No items match your search criteria.</p>";
} else {
    while ($item = $result->fetch_assoc()) {
        echo "<div class='product-card'>";
        echo "<img src='{$item['image_path']}' alt='{$item['name']}' width='120'><br>";
        echo "<h4>{$item['name']}</h4>";
        echo "<p>{$item['description']}</p>";
        echo "<p class='price'>\${$item['price']}</p>";
        echo "<p><em>Seller: {$item['first_name']}</em></p>";
        echo "<form method='post' action='add_to_cart.php'>";
        echo "<input type='hidden' name='item_id' value='{$item['item_id']}'>";
        echo "<button type='submit'>Add to Cart</button>";
        echo "</form>";
        echo "</div>";
    }
}

$stmt->close();
$dbc->close();
?>
</div>

<?php include 'footer.php'; ?>
