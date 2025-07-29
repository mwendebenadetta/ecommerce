<?php
session_start();
$conn = new mysqli("localhost", "root", "", "ecommerce_db");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password FROM resellers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($reseller_id, $reseller_name, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['reseller_id'] = $reseller_id;
            $_SESSION['reseller_name'] = $reseller_name;
            header("Location: reseller_dashboard.php");
            exit();
        } else {
            $error = "❌ Incorrect password.";
        }
    } else {
        $error = "❌ Reseller not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reseller Login</title>
    <style>
        body { font-family: Arial; background: #f9f9f9; padding: 40px; text-align: center; }
        form { display: inline-block; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
        input[type="text"], input[type="password"] {
            padding: 10px;
            margin: 10px 0;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            padding: 10px 30px;
            background: #28a745;
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

    <h2>🔐 Reseller Login</h2>

    <form method="POST" action="">
        <input type="text" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
    </form>

</body>
</html>
