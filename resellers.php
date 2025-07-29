<?php
$conn = new mysqli("localhost", "root", "", "ecommerce_db");

// Fetch resellers
$result = $conn->query("SELECT name, location FROM resellers");
?>

<!DOCTYPE html>
<html>
<head>
    <title>📍 Reseller Locations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: #f9f9f9;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 70%;
            margin: auto;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 14px 18px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #28a745;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .back {
            text-align: center;
            margin-top: 30px;
        }

        .back a {
            text-decoration: none;
            background: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
        }

        .back a:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<h2>📍 Our Reseller Locations</h2>

<?php if ($result->num_rows > 0): ?>
    <table>
        <tr>
            <th>Reseller Name</th>
            <th>Location</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['location']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p style="text-align:center;">No resellers found.</p>
<?php endif; ?>

<div class="back">
    <a href="index.php">← Back to Homepage</a>
</div>

</body>
</html>
