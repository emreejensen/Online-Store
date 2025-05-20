<?php
$theme = $_COOKIE['theme'] ?? 'light';
$fontSize = $_COOKIE['font_size'] ?? 'medium';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GGC Online Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="<?= $theme ?>-mode <?= $fontSize ?>-font">
<main>
