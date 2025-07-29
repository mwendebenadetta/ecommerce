<?php
session_start();
$conn = new mysqli("localhost", "root", "", "ecommerce_db");

if (!isset($_SESSION['reseller_id'])) {
    echo "Access denied. Please login as a reseller.";
    exit();
}

$reseller_id = $_SESSION['reseller_id'];
$success = "";
$error = "";

// Fetch current profile data
$stmt = $conn->prepare("SELECT name, email FROM resellers WHERE id = ?");
$stmt->bind_param("i", $reseller_id);
$stmt->execute();
$stmt->bind_result($name, $email);
$stmt->fetch();
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = $_POST["name"];
    $new_email = $_POST["email"];
    $new_password = $_POST["password"];

    if (!empty($new_password)) {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE resellers SET name=?, email=?, password=? WHERE id=?");
        $update->bind_param("sssi", $new_name, $new_email, $hashed, $reseller_id);
    } else {
        $update = $conn->prepare("UPDATE resellers SET name=?, email=? WHERE id=?");
        $update->bind_param("ssi", $new_name, $new_email, $reseller_id);
    }

    if ($update->execute()) {
        $success = "✅ Profile updated successfully!";
        $_SESSION['reseller_name'] = $new_name;
    } else {
        $error = "❌ Failed to update profile.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reseller Profile</title>
    <style>
        body { font-family: Arial; padding: 40px; text-align: center; background: #f4f4f4; }
        form {
            background: white;
            display: inline-block;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            padding: 10px;
            margin: 10px 0;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            padding: 10px 25px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }
        .msg { margin: 15px; font-weight: bold; }
    </style>
</head>
<body>

<h2>👤 Update Reseller Profile</h2>

<?php if ($success): ?><div class="msg" style="color:green;"><?= $success ?></div><?php endif; ?>
<?php if ($error): ?><div class="msg" style="color:red;"><?= $error ?></div><?php endif; ?>

<form method="POST">
    <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" required><br>
    <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required><br>
    <input type="password" name="password" placeholder="New Password (leave blank to keep current)"><br>
    <button type="submit">Update Profile</button>
</form>

<p><a href="reseller_dashboard.php">⬅ Back to Dashboard</a></p>

</body>
</html>
