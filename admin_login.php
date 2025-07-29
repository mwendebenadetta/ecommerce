<?php
session_start();
$conn = new mysqli("localhost", "root", "", "ecommerce_db");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $admin = $res->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "❌ Incorrect password.";
        }
    } else {
        $error = "❌ Admin user not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body { font-family: Arial; background: #f9f9f9; padding: 40px; text-align: center; }
        form { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px #ccc; display: inline-block; }
        input[type="text"], input[type="password"] {
            padding: 10px;
            margin: 10px 0;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            padding: 10px 30px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }
        .error { color: red; margin-top: 10px; }
    </style>
</head>
<body>

    <h2>🔐 Admin Login</h2>

    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
    </form>

</body>
</html>
