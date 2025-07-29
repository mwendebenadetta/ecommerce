<?php
session_start();
$conn = new mysqli("localhost", "root", "", "ecommerce_db");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        $message = "❌ Cart is empty.";
    } else {
        foreach ($_SESSION['cart'] as $product_id) {
            $stmt = $conn->prepare("INSERT INTO orders (customer_name, phone, address, product_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $name, $phone, $address, $product_id);
            $stmt->execute();
        }
        $_SESSION['cart'] = []; // Clear cart after saving
        $message = "✅ Order placed successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>🧾 Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f3;
            padding: 40px;
            text-align: center;
        }
        h2 {
            color: #007bff;
        }
        form {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            display: inline-block;
            text-align: left;
            max-width: 400px;
            width: 100%;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background-color: #218838;
        }
        .message {
            margin-top: 20px;
            font-weight: bold;
            color: #333;
        }
        a.back-link {
            display: block;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>

    <h2>🧾 Checkout</h2>

    <form method="POST" action="">
        <label>Full Name</label>
        <input type="text" name="name" required>

        <label>Phone Number</label>
        <input type="text" name="phone" required>

        <label>Delivery Address</label>
        <textarea name="address" rows="4" required></textarea>

        <button type="submit">✔️ Place Order</button>
    </form>

    <?php if (isset($message)): ?>
        <div class="message"><?= $message ?></div>
        <a class="back-link" href="view_products.php">← Back to Products</a>
    <?php endif; ?>

</body>
</html>
