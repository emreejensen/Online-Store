<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['item_id'])) {
    $item_id = $_POST['item_id'];
    if (!in_array($item_id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $item_id;
    }
}

header("Location: student_buy.php");
exit();
?>
