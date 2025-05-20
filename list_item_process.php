<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];
$item_name = trim($_POST['item_name']);
$description = trim($_POST['item_description']);
$price = floatval($_POST['price']);

// Check for duplicate listing (same name + seller)
$checkStmt = $dbc->prepare("SELECT * FROM item WHERE seller_id = ? AND name = ?");
$checkStmt->bind_param("is", $seller_id, $item_name);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    echo "<p style='color:red;'>❌ You’ve already listed an item with this name.</p>";
    echo "<a href='student_sell.php'>Back to Sell Page</a>";
    exit();
}
$checkStmt->close();

// Handle image upload
$imagePath = '';
if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'images/';
    $imageName = time() . '_' . basename($_FILES['item_image']['name']);
    $targetFile = $uploadDir . $imageName;

    if (move_uploaded_file($_FILES['item_image']['tmp_name'], $targetFile)) {
        $imagePath = $targetFile;
    } else {
        echo "<p style='color:red;'>❌ Failed to upload image. Please try again.</p>";
        echo "<a href='student_sell.php'>Back to Sell Page</a>";
        exit();
    }
} else {
    echo "<p style='color:red;'>❌ Please select an image file to upload.</p>";
    echo "<a href='student_sell.php'>Back to Sell Page</a>";
    exit();
}

// Insert into database
$insertStmt = $dbc->prepare("INSERT INTO item (name, description, price, image_path, seller_id) VALUES (?, ?, ?, ?, ?)");
$insertStmt->bind_param("ssdsi", $item_name, $description, $price, $imagePath, $seller_id);

if ($insertStmt->execute()) {
    echo "<p style='color:green;'>✅ Your item has been successfully listed for sale!</p>";
    echo "<a href='student_sell.php'>Back to Sell Page</a> | <a href='student_home.php'>Go to Dashboard</a>";
} else {
    echo "<p style='color:red;'>❌ Error adding item: " . $dbc->error . "</p>";
}

$insertStmt->close();
$dbc->close();
?>
