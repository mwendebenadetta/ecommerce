<?php
session_start();
if (isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    if (!empty($_SESSION['cart'])) {
        $_SESSION['cart'] = array_diff($_SESSION['cart'], [$productId]);
    }
}
header("Location: cart.php");
exit();
