<?php
session_start();
if (!isset($_SESSION['reseller_id'])) {
    echo "Access denied. Please login as a reseller.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reseller Dashboard</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #d4fc79, #96e6a1);
      color: #333;
    }

    .dashboard {
      max-width: 1000px;
      margin: 60px auto;
      padding: 30px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }

    h1 {
      text-align: center;
      color: #28a745;
      margin-bottom: 40px;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    .card-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 25px;
    }

    .card {
      background-color: #f9f9f9;
      width: 200px;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }

    .card a {
      text-decoration: none;
      color: #28a745;
      font-weight: bold;
      font-size: 16px;
      display: block;
      margin-top: 10px;
    }

    .icon {
      font-size: 40px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

  <div class="dashboard">
    <h1>🛒 Reseller Dashboard</h1>

    <div class="card-container">
      <div class="card">
        <div class="icon">➕</div>
        <a href="add_product.php">Add Product</a>
      </div>

      <div class="card">
        <div class="icon">📦</div>
        <a href="view_products.php">View Products</a>
      </div>

      <div class="card">
        <div class="icon">📑</div>
        <a href="reseller_orders.php">View My Orders</a>
      </div>

      <div class="card">
        <div class="icon">📤</div>
        <a href="reseller_export_orders.php">Export Orders</a>
      </div>

      <div class="card">
        <div class="icon">🔐</div>
        <a href="logout.php" style="color: red;">Logout</a>
      </div>
    </div>
  </div>

</body>
</html>
