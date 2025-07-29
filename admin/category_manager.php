<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit();
}

include('../config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
  $stmt->bind_param("s", $name);
  $stmt->execute();
}

$result = $conn->query("SELECT * FROM categories ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Categories</title>
  <style>
    body { font-family: Arial; padding: 30px; background: #f0f8ff; }
    form, table { margin-bottom: 30px; }
    input, button { padding: 8px; margin-top: 10px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 12px; border: 1px solid #ccc; }
    th { background-color: #ddd; }
  </style>
</head>
<body>
  <h2>🛒 Add Product Category</h2>
  <form method="POST">
    <label>Enter Category Name</label><br>
    <input type="text" name="name" required>
    <button type="submit">Add Category</button>
  </form>

  <h3>📋 Existing Categories</h3>
  <table>
    <tr><th>ID</th><th>Category Name</th><th>Created At</th></tr>
    <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['created_at'] ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
