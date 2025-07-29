<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "ecommerce_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = trim($_POST["category_name"]);

    if (!empty($category_name)) {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $category_name);
        if ($stmt->execute()) {
            $message = "<p style='color: green;'>Category added successfully!</p>";
        } else {
            $message = "<p style='color: red;'>Error: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        $message = "<p style='color: red;'>Please enter a category name.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f7f7f7;
        }
        h2 {
            color: #333;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px #ccc;
            width: 300px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-top: 8px;
            margin-bottom: 12px;
            border: 1px solid #aaa;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: green;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        p {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Add New Category</h2>
    <?php echo $message; ?>
    <form method="POST" action="">
        <label for="category_name">Category Name:</label>
        <input type="text" name="category_name" id="category_name" required>
        <input type="submit" value="Add Category">
    </form>
</body>
</html>
