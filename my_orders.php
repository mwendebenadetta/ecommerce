<?php
$conn = new mysqli("localhost", "root", "", "ecommerce_db");

$orders = [];
$searched = false;
$phone = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = trim($_POST['phone']);
    $searched = true;

    $stmt = $conn->prepare("
        SELECT o.*, p.name AS product_name, r.name AS reseller_name
        FROM orders o
        JOIN products p ON o.product_id = p.id
        LEFT JOIN resellers r ON p.reseller_id = r.id
        WHERE o.phone = ?
        ORDER BY o.created_at DESC
    ");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>📦 My Orders</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f8;
      padding: 20px;
    }

    .container {
      max-width: 800px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 5px 10px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #2c3e50;
    }

    form {
      margin-bottom: 25px;
      text-align: center;
    }

    input[type="tel"] {
      width: 70%;
      padding: 10px;
      font-size: 16px;
      border-radius: 8px;
      border: 1px solid #ccc;
      margin-right: 10px;
    }

    button {
      padding: 10px 20px;
      font-size: 16px;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    th, td {
      padding: 10px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }

    th {
      background: #007bff;
      color: white;
    }

    .no-orders {
      text-align: center;
      color: #777;
      margin-top: 20px;
    }
  </style>
</head>
<body>
<div class="container">
  <h2>📦 My Orders</h2>
  <form method="POST">
    <input type="tel" name="phone" placeholder="Enter your phone number" value="<?= htmlspecialchars($phone) ?>" required>
    <button type="submit">Search</button>
  </form>

  <?php if ($searched): ?>
    <?php if (empty($orders)): ?>
      <p class="no-orders">No orders found for <strong><?= htmlspecialchars($phone) ?></strong>.</p>
    <?php else: ?>
      <table>
        <tr>
          <th>Product</th>
          <th>Address</th>
          <th>Reseller</th>
          <th>Date</th>
        </tr>
        <?php foreach ($orders as $order): ?>
          <tr>
            <td><?= htmlspecialchars($order['product_name']) ?></td>
            <td><?= htmlspecialchars($order['address']) ?></td>
            <td><?= $order['reseller_name'] ?? '—' ?></td>
            <td><?= date('M d, Y H:i', strtotime($order['created_at'])) ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    <?php endif; ?>
  <?php endif; ?>
</div>
</body>
</html>
