<?php
session_start();
$conn = new mysqli("localhost", "root", "", "ecommerce_db");

// Only allow access if reseller is logged in
if (!isset($_SESSION['reseller_id'])) {
    echo "<h3 style='text-align:center;color:red;'>Please login as a reseller first.</h3>";
    exit();
}

$reseller_id = $_SESSION['reseller_id'];

// Fetch orders for products belonging to this reseller
$sql = "
    SELECT o.id, o.customer_name, o.phone, o.address, p.name AS product_name
    FROM orders o
    JOIN product p ON o.product_id = p.id
    WHERE p.reseller_id = ?
    ORDER BY o.id DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $reseller_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>📋 Reseller Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #28a745;
            color: white;
        }

        .actions {
            margin: 20px 0;
            text-align: center;
        }

        .actions a, .actions button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .actions a:hover, .actions button:hover {
            background-color: #218838;
        }

        .no-orders {
            text-align: center;
            color: #666;
            font-size: 18px;
        }
    </style>
</head>
<body>

<h2>📋 Orders for Your Products</h2>

<div class="actions">
    <a href="https://wa.me/254759539487" target="_blank">💬 Chat on WhatsApp</a>
    <button onclick="window.print()">🖨️ Print Orders</button>
    <a href="export_orders.php">📄 Export to PDF</a>
</div>

<?php if ($result->num_rows > 0): ?>
    <table>
        <tr>
            <th>#</th>
            <th>Product</th>
            <th>Customer Name</th>
            <th>Phone</th>
            <th>Address</th>
        </tr>
        <?php
        $count = 1;
        while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?= $count++ ?></td>
            <td><?= htmlspecialchars($row['product_name']) ?></td>
            <td><?= htmlspecialchars($row['customer_name']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['address']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p class="no-orders">❌ No orders found for your products.</p>
<?php endif; ?>

</body>
</html>
