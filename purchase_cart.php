<?php
session_start();
include 'connection.php';

$user_id = $_SESSION['user_id'] ?? null;
$cart = $_SESSION['cart'] ?? [];

if (!$user_id || empty($cart)) {
    header("Location: cart.php");
    exit();
}

if (isset($_POST['checkout'])) {
    foreach ($cart as $item_id) {
        $stmt = $dbc->prepare("UPDATE item SET buyer_id = ?, sold_date = NOW() WHERE item_id = ? AND buyer_id IS NULL");
        $stmt->bind_param("ii", $user_id, $item_id);
        $stmt->execute();
        $stmt->close();
    }

    $_SESSION['cart'] = []; // Clear cart
    header("Location: student_transactions.php?purchased=1");
    exit();
}

if (isset($_POST['remove'])) {
    $remove_id = $_POST['remove'];
    $_SESSION['cart'] = array_filter($cart, fn($id) => $id != $remove_id);
    header("Location: cart.php");
    exit();
}
?>
