<?php
$conn = new mysqli("localhost", "root", "", "ecommerce_db");
$result = $conn->query("SELECT * FROM categories");
?>

<h2 style="text-align:center;">📂 All Product Categories</h2>
<table border="1" cellpadding="10" cellspacing="0" align="center">
    <tr>
        <th>ID</th>
        <th>Name</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
    </tr>
    <?php endwhile; ?>
</table>
