<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: ../login.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard - Mutu-ini Hospital</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f0f4f8;
      margin: 0;
      padding: 0;
    }

    .header {
      background-color: #2d6a4f;
      color: white;
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header h1 {
      margin: 0;
      font-size: 24px;
    }

    .logout-btn {
      background-color: #c1121f;
      color: white;
      padding: 8px 12px;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
    }

    .dashboard {
      padding: 40px;
      text-align: center;
    }

    .dashboard a {
      display: inline-block;
      margin: 20px;
      padding: 20px 30px;
      background-color: #40916c;
      color: white;
      text-decoration: none;
      border-radius: 10px;
      font-size: 18px;
      transition: background 0.3s;
    }

    .dashboard a:hover {
      background-color: #1b4332;
    }
  </style>
</head>
<body>

  <div class="header">
    <h1>🛠 Admin Dashboard - Mutu-ini Hospital</h1>
    <a class="logout-btn" href="logout.php">Logout</a>
  </div>

  <div class="dashboard">
    <a href="category_manager.php">📂 Manage Categories</a>
    <a href="add_product.php">🛒 Add Products</a>
    <a href="view_appointments.php">📅 View Appointments</a>
  </div>

</body>
</html>
