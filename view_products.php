<?php
session_start();
$conn = new mysqli("localhost", "root", "", "ecommerce_db");

$result = $conn->query("
    SELECT p.id, p.name, p.price, r.name AS reseller_name 
    FROM products p 
    LEFT JOIN resellers r ON p.reseller_id = r.id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>🛍️ All Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        .product-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }
        .product-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            width: 280px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            text-align: left;
        }
        .product-card h3 {
            margin-top: 0;
            color: #007bff;
        }
        .product-card p {
            margin: 10px 0;
            color: #555;
        }
        .btn {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
        .btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>

    <h2>🛍️ All Products</h2>

    <div class="product-grid">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="product-card">
                    <h3><?= htmlspecialchars($row['name']) ?></h3>
                    <p><strong>Price:</strong> KES <?= number_format($row['price']) ?></p>
                    <?php if ($row['reseller_name']): ?>
                        <p><strong>Reseller:</strong> <?= htmlspecialchars($row['reseller_name']) ?></p>
                    <?php endif; ?>
                    <a class="btn" href="add_to_cart.php?id=<?= $row['id'] ?>">➕ Add to Cart</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>

</body>
</html>
