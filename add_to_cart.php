<?php
session_start();
$id = $_GET['id'] ?? null;

if (!$id) {
    die("Invalid product ID.");
}

// Initialize cart if not already
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add to cart
if (!in_array($id, $_SESSION['cart'])) {
    $_SESSION['cart'][] = $id;
}

header("Location: cart.php");
exit();
