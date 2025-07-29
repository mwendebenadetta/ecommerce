<?php
session_start();
$conn = new mysqli("localhost", "root", "", "ecommerce_db");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo "<h3 style='text-align:center;'>❌ Cart is empty</h3>";
        exit();
    }

    foreach ($_SESSION['cart'] as $product_id) {
        $stmt = $conn->prepare("INSERT INTO orders (customer_name, phone, address, product_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $phone, $address, $product_id);
        $stmt->execute();
    }

    $_SESSION['cart'] = []; // Clear cart
    echo "<h3 style='text-align:center;'>✅ Thank you for your order!<br>Your order has been placed successfully. We will contact you soon.</h3>";
    echo "<p style='text-align:center;'><a href='view_products.php'>🛍️ Continue Shopping</a></p>";
    exit();
}

// Fetch product info for display
$products = [];
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_map('intval', $_SESSION['cart']));
    $result = $conn->query("SELECT * FROM products WHERE id IN ($ids)");
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background: #f1f1f1;
    }

    .checkout-box {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #333;
    }

    input, textarea {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 15px;
    }

    button {
      width: 100%;
      background: #28a745;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
    }

    button:hover {
      background: #218838;
    }

    .cart-summary {
      margin-top: 20px;
      padding: 10px;
      background: #f8f9fa;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    .cart-summary ul {
      padding: 0;
      list-style: none;
    }

    .cart-summary li {
      padding: 5px 0;
    }

    .back-link {
      text-align: center;
      margin-top: 20px;
    }

    .back-link a {
      color: #007bff;
      text-decoration: none;
    }

    .back-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="checkout-box">
  <h2>🧾 Checkout</h2>

  <?php if (empty($products)): ?>
    <p style="text-align:center;">Your cart is empty. <a href="view_products.php">Browse Products</a></p>
  <?php else: ?>
    <form method="POST">
      <input type="text" name="name" placeholder="Full Name" required>
      <input type="tel" name="phone" placeholder="Phone Number" required>
      <textarea name="address" placeholder="Delivery Address" rows="4" required></textarea>

      <div class="cart-summary">
        <h4>🛍️ Cart Summary:</h4>
        <ul>
          <?php foreach ($products as $product): ?>
            <li>✅ <?= htmlspecialchars($product['name']) ?> - KES <?= number_format($product['price']) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <button type="submit">✅ Confirm Order</button>
    </form>
  <?php endif; ?>

  <div class="back-link">
    <a href="cart.php">← Back to Cart</a>
  </div>
</div>

</body>
</html>
