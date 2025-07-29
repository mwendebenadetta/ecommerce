<?php
$conn = new mysqli("localhost", "root", "", "ecommerce_db");

// Fetch all products with their categories
$sql = "SELECT products.*, categories.name AS category_name 
        FROM products 
        JOIN categories ON products.category_id = categories.id 
        ORDER BY products.id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>All Products - Mutu-ini Hospital</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      padding: 30px;
    }

    h2 {
      text-align: center;
      color: #28a745;
      margin-bottom: 30px;
    }

    .products {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 25px;
      max-width: 1000px;
      margin: auto;
    }

    .product {
      background: white;
      border-radius: 10px;
      padding: 15px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
    }

    .product img {
      max-width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 8px;
    }

    .product h3 {
      margin-top: 10px;
    }

    .product h3 a {
      color: #007bff;
      text-decoration: none;
    }

    .product p {
      margin: 5px 0;
      color: #555;
    }

    .price {
      font-weight: bold;
      color: #28a745;
    }
  </style>
</head>
<body>

  <h2>🛍️ Available Services at Mutu-ini Hospital</h2>

  <div class="products">
    <?php while($row = $result->fetch_assoc()): ?>
      <div class="product">
        <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="Product Image">
        <h3>
          <a href="product_details.php?id=<?= $row['id'] ?>">
            <?= htmlspecialchars($row['name']) ?>
          </a>
        </h3>
        <p><?= htmlspecialchars($row['description']) ?></p>
        <p class="price">KES <?= number_format($row['price'], 2) ?></p>
        <p><strong>Category:</strong> <?= htmlspecialchars($row['category_name']) ?></p>
      </div>
    <?php endwhile; ?>
  </div>

</body>
</html>
