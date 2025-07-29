<?php
$conn = new mysqli("localhost", "root", "", "ecommerce_db");
$orders = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("
        SELECT o.customer_name, o.address, o.order_date,
               p.name AS product_name,
               (SELECT image_path FROM product_images WHERE product_id = p.id LIMIT 1) AS image
        FROM orders o
        JOIN products p ON o.product_id = p.id
        WHERE o.phone = ?
        ORDER BY o.order_date DESC
    ");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $orders = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Track Order</title>
    <style>
        body {
            font-family: Arial;
            background: #f9f9f9;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 15px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
        }
        .order {
            background: white;
            margin: 20px auto;
            padding: 15px;
            max-width: 600px;
            border-radius: 10px;
            box-shadow: 0 0 10px #bbb;
        }
        img {
            max-height: 80px;
            float: right;
            margin-left: 15px;
        }
        .order p {
            margin: 6px 0;
        }
    </style>
</head>
<body>

<h2>📦 Track Your Order</h2>

<form method="POST" action="track_order.php">
    <input type="text" name="phone" placeholder="Enter your phone number" required>
    <input type="submit" value="Search Orders">
</form>

<?php if (isset($_POST['phone'])): ?>
    <?php if ($orders->num_rows > 0): ?>
        <?php while ($row = $orders->fetch_assoc()): ?>
            <div class="order">
                <img src="<?php echo $row['image']; ?>" alt="Product">
                <p><strong>Product:</strong> <?php echo $row['product_name']; ?></p>
                <p><strong>Name:</strong> <?php echo $row['customer_name']; ?></p>
                <p><strong>Address:</strong> <?php echo $row['address']; ?></p>
                <p><strong>Order Date:</strong> <?php echo $row['order_date']; ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center; color:red;">❌ No orders found for that phone number.</p>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>
