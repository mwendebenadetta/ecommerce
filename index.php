<?php
// Handle location selection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['location'])) {
    setcookie('user_location', $_POST['location'], time() + (86400 * 30), "/"); // 30 days
    $_COOKIE['user_location'] = $_POST['location']; // Immediate use
}

$selected_location = $_COOKIE['user_location'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome to Mutu-ini Hospital</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-image: url('images/hospital_bg.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      min-height: 100vh;
      font-family: Arial, sans-serif;
      color: white;
      text-align: center;
      display: flex;
      flex-direction: column;
    }

    .content {
      flex: 1;
      padding: 20px;
      padding-top: 5%; /* Moved heading slightly higher */
    }

    h1 {
      font-size: 45px;
      font-weight: bold;
      margin-bottom: 20px;
      letter-spacing: 2px;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
    }

    .buttons {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
      justify-content: center;
      padding: 0 20px;
      max-width: 800px;
      margin: auto;
    }

    .buttons a {
      display: block;
      text-decoration: none;
      background-color: #28a745;
      color: white;
      padding: 15px;
      border-radius: 8px;
      font-size: 18px;
      font-weight: bold;
      box-shadow: 2px 2px 5px rgba(0,0,0,0.3);
      transition: background 0.3s ease;
    }

    .buttons a:hover {
      background-color: #218838;
    }

    footer {
      text-align: center;
      font-size: 14px;
      padding: 20px 10px;
      background: rgba(0, 0, 0, 0.4);
      color: white;
    }
  </style>
</head>
<body>

  <div class="content">
    <h1>WELCOME TO MUTU-INI HOSPITAL</h1>

    <!-- Buttons Section -->
    <div class="buttons">
      <a href="services.php">🛠️ Our Services</a>
      <a href="appointment.php">📅 Book Appointment</a>
      <a href="login_selector.php">🔐 Login (Admin / Reseller)</a>
      <a href="view_products.php">🛒 View Products</a>
      <a href="checkout.php">✅ Checkout</a>
      <a href="reseller_orders.php">📋 Reseller Orders</a>
      <a href="export_orders.php">📄 Export Orders (PDF)</a>
    </div>
  </div>

  <footer>
    © <?= date("Y"); ?> Mutu-ini Hospital | All rights reserved
  </footer>

</body>
</html>
