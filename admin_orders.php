<?php
$conn = new mysqli("localhost", "root", "", "ecommerce_db");

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$sql = "
    SELECT 
        o.id,
        o.customer_name,
        o.phone,
        o.address,
        p.name AS product_name,
        r.name AS reseller_name,
        r.location,
        o.created_at
    FROM orders o
    LEFT JOIN product p ON o.product_id = p.id
    LEFT JOIN resellers r ON p.reseller_id = r.id
    WHERE 
        o.customer_name LIKE '%$search%' OR 
        p.name LIKE '%$search%' OR 
        r.name LIKE '%$search%'
    ORDER BY o.created_at DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Customer Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background: #f4f4f4;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .top-controls {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            align-items: center;
            margin-bottom: 20px;
        }

        .top-controls form {
            display: flex;
            gap: 10px;
        }

        .top-controls input[type="text"] {
            padding: 8px;
            width: 230px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .top-controls button,
        .top-controls a {
            padding: 8px 14px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            color: white;
            border: none;
        }

        .top-controls button {
            background: #28a745;
        }

        .top-controls .reset {
            background: #dc3545;
        }

        .export-btn a {
            background: #28a745;
        }

        .print-btn a {
            background: #007bff;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 12px 14px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background: #28a745;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .no-orders {
            text-align: center;
            color: #888;
            font-style: italic;
            margin-top: 40px;
        }

        @media print {
            .top-controls {
                display: none;
            }
        }
    </style>
</head>
<body>

<h2>📋 All Customer Orders</h2>

<div class="top-controls">
    <!-- Search -->
    <form method="GET" action="admin_orders.php">
        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="🔍 Search orders...">
        <button type="submit">Search</button>
        <a href="admin_orders.php" class="reset">Reset</a>
    </form>

    <!-- Export and Print -->
    <div class="export-btn">
        <a href="admin_export_orders.php">📄 Export PDF</a>
    </div>
    <div class="print-btn">
        <a href="#" onclick="window.print();">🖨️ Print Orders</a>
    </div>
</div>

<?php if ($result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Product</th>
                <th>Reseller</th>
                <th>Location</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 1; ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= htmlspecialchars($row['customer_name']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= htmlspecialchars($row['address']) ?></td>
                    <td><?= htmlspecialchars($row['product_name']) ?></td>
                    <td><?= htmlspecialchars($row['reseller_name']) ?></td>
                    <td><?= htmlspecialchars($row['location']) ?></td>
                    <td><?= $row['created_at'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="no-orders">No orders found.</div>
<?php endif; ?>

</body>
</html>
