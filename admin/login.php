<?php
session_start();
$conn = new mysqli("localhost", "root", "", "ecommerce_db");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = sha1($_POST['password']);

  $query = $conn->prepare("SELECT * FROM admin_users WHERE username = ? AND password = ?");
  $query->bind_param("ss", $username, $password);
  $query->execute();
  $result = $query->get_result();

  if ($result->num_rows === 1) {
    $_SESSION['admin_logged_in'] = true;
    header("Location: dashboard.php");
    exit();
  } else {
    $error = "❌ Invalid login details.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <style>
    body {
      font-family: Arial;
      background: #e0f7fa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    form {
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 300px;
    }

    h2 {
      text-align: center;
      color: #00796b;
    }

    input {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      margin-bottom: 15px;
    }

    button {
      background: #00796b;
      color: white;
      border: none;
      padding: 10px;
      width: 100%;
      cursor: pointer;
    }

    .error {
      color: red;
      text-align: center;
    }
  </style>
</head>
<body>

  <form method="POST">
    <h2>🔐 Admin Login</h2>
    <?php if ($error): ?>
      <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <input type="text" name="username" placeholder="Username" required />
    <input type="password" name="password" placeholder="Password" required />
    <button type="submit">Login</button>
  </form>

</body>
</html>
