<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['item_ids']) && is_array($_POST['item_ids'])) {
    $item_ids = $_POST['item_ids'];

    foreach ($item_ids as $item_id) {
        // Double check it's not already sold
        $checkStmt = $dbc->prepare("SELECT buyer_id FROM item WHERE item_id = ?");
        $checkStmt->bind_param("i", $item_id);
        $checkStmt->execute();
        $checkStmt->bind_result($buyer_id);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($buyer_id === null) {
            $updateStmt = $dbc->prepare("UPDATE item SET buyer_id = ?, sold_date = NOW() WHERE item_id = ?");
            $updateStmt->bind_param("ii", $user_id, $item_id);
            $updateStmt->execute();
            $updateStmt->close();
        }
    }

    header("Location: student_transactions.php?purchased=1");
    exit();
} else {
    echo "No items selected for purchase.";
}
?>
