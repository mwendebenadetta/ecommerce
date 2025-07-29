<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #e0f7fa, #80deea);
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #00796b;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 30px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .dashboard {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 30px;
            gap: 20px;
        }

        .card {
            background-color: white;
            width: 250px;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            text-align: center;
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            margin-bottom: 15px;
            font-size: 20px;
            color: #333;
        }

        .card a {
            text-decoration: none;
            background-color: #00796b;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            display: inline-block;
            margin-top: 10px;
        }

        .logout {
            text-align: right;
            padding: 15px 25px;
        }

        .logout a {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }

        @media screen and (max-width: 768px) {
            .dashboard {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>

<div class="header">WELCOME ADMIN</div>

<div class="logout">
    <a href="logout.php">🔓 Logout</a>
</div>

<div class="dashboard">
    <div class="card">
        <h3>🛍️ View Products</h3>
        <a href="view_products.php">View</a>
    </div>

    <div class="card">
        <h3➕ Add Product</h3>
        <a href="add_product.php">Add</a>
    </div>

    <div class="card">
        <h3>📦 All Orders</h3>
        <a href="admin_orders.php">Orders</a>
    </div>

    <div class="card">
        <h3>📁 Manage Categories</h3>
        <a href="add_category.php">Categories</a>
    </div>

    <div class="card">
        <h3>🧑‍💻 Manage Resellers</h3>
        <a href="resellers.php">Resellers</a>
    </div>
</div>

</body>
</html>
