<?php
$conn = new mysqli("localhost", "root", "", "ecommerce_db");

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = null;

if ($product_id > 0) {
    $stmt = $conn->prepare("SELECT products.*, categories.name AS category_name 
                            FROM products 
                            JOIN categories ON products.category_id = categories.id 
                            WHERE products.id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
}

// Store in cookie
if ($product) {
    $viewed = [];

    if (isset($_COOKIE['viewed_products'])) {
        $viewed = json_decode($_COOKIE['viewed_products'], true);
        if (!is_array($viewed)) $viewed = [];
    }

    // Remove duplicate
    $viewed = array_filter($viewed, fn($id) => $id != $product_id);

    array_unshift($viewed, $product_id); // add to front
    $viewed = array_slice($viewed, 0, 5); // limit to 5 items

    setcookie('viewed_products', json_encode($viewed), time() + (86400 * 30), "/");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Product Details</title>
  <style>
    body { font-family: Arial; padding: 30px; background: #f9f9f9; }
    .product-box { max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    img { max-width: 100%; height: auto; border-radius: 8px; }
    h2 { color: #28a745; }
    .price { color: #28a745; font-weight: bold; }
    a.button { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; }
  </style>
</head>
<body>

<?php if ($product): ?>
  <div class="product-box">
    <img src="uploads/<?= htmlspecialchars($product['image']) ?>" alt="">
    <h2><?= htmlspecialchars($product['name']) ?></h2>
    <p><?= htmlspecialchars($product['description']) ?></p>
    <p class="price">KES <?= number_format($product['price'], 2) ?></p>
    <p><strong>Category:</strong> <?= htmlspecialchars($product['category_name']) ?></p>
    <a href="view_products.php" class="button">← Back to Products</a>
  </div>
<?php else: ?>
  <p>Product not found.</p>
<?php endif; ?>

</body>
</html>
