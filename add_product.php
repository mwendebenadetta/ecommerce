<?php
session_start();
$conn = new mysqli("localhost", "root", "", "ecommerce_db");

// Redirect if not logged in
if (!isset($_SESSION['reseller_id'])) {
    echo "<p style='text-align:center; color:red;'>Please login as a reseller first.</p>";
    exit();
}

$reseller_id = $_SESSION['reseller_id'];

// Get categories
$cat_result = $conn->query("SELECT * FROM categories");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    // Upload main image
    $mainImagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir);
        }
        $mainImagePath = $targetDir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $mainImagePath);
    }

    // Insert main product into product table
    $stmt = $conn->prepare("INSERT INTO product (name, price, image, category_id, reseller_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdssi", $name, $price, $mainImagePath, $category_id, $reseller_id);
    $stmt->execute();
    $product_id = $stmt->insert_id; // Get ID of inserted product

    // Upload additional images
    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['images']['error'][$key] === 0) {
                $imgName = basename($_FILES['images']['name'][$key]);
                $imgPath = $targetDir . $imgName;
                move_uploaded_file($tmp_name, $imgPath);

                // Save into product_images table
                $imgStmt = $conn->prepare("INSERT INTO product_images (product_id, image_path) VALUES (?, ?)");
                $imgStmt->bind_param("is", $product_id, $imgPath);
                $imgStmt->execute();
            }
        }
    }

    echo "<p style='color:green;text-align:center;'>✅ Product added successfully with images!</p>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>
<body>
    <h2 style="text-align:center;">➕ Add Product</h2>

    <form method="POST" enctype="multipart/form-data" style="max-width:400px; margin:auto;">
        <label>Product Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Price (Ksh):</label><br>
        <input type="number" step="0.01" name="price" required><br><br>

        <label>Main Image:</label><br>
        <input type="file" name="image" accept="image/*" required><br><br>

        <label>Upload Additional Images:</label><br>
        <input type="file" name="images[]" accept="image/*" multiple><br><br>

        <label>Category:</label><br>
        <select name="category_id" required>
            <option value="">-- Select Category --</option>
            <?php while($cat = $cat_result->fetch_assoc()): ?>
                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
            <?php endwhile; ?>
        </select>
        <br><br>

        <button type="submit">Add Product</button>
    </form>

    <p style="text-align:center; margin-top:20px;">
        <a href="view_products.php">← Back to Products</a>
    </p>
</body>
</html>
