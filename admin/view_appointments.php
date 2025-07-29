<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit();
}

$conn = new mysqli("localhost", "root", "", "ecommerce_db");
$result = $conn->query("SELECT * FROM appointments ORDER BY appointment_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>View Appointments - Mutu-ini Hospital</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f2f2f2;
      padding: 30px;
    }

    h1 {
      text-align: center;
      color: #2d6a4f;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 15px;
      border-bottom: 1px solid #ccc;
      text-align: left;
    }

    th {
      background: #2d6a4f;
      color: white;
    }

    tr:hover {
      background: #e9f5ec;
    }
  </style>
</head>
<body>

  <h1>📅 View Appointments - Mutu-ini Hospital</h1>

  <table>
    <tr>
      <th>ID</th>
      <th>Full Name</th>
      <th>Phone</th>
      <th>Service</th>
      <th>Date</th>
      <th>Message</th>
      <th>Booked On</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= $row['full_name'] ?></td>
      <td><?= $row['phone'] ?></td>
      <td><?= $row['product_id'] ?></td>
      <td><?= $row['appointment_date'] ?></td>
      <td><?= $row['message'] ?></td>
      <td><?= $row['created_at'] ?></td>
    </tr>
    <?php endwhile; ?>

  </table>

</body>
</html>
