<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Selection</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #eaf2f8;
      text-align: center;
      padding: 50px;
    }
    h2 {
      color: #2c3e50;
    }
    .login-buttons a {
      display: inline-block;
      padding: 15px 30px;
      margin: 20px;
      background-color: #007bff;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-size: 18px;
    }
    .login-buttons a:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <h2>🔐 Please select your login type</h2>
  <div class="login-buttons">
    <a href="admin_login.php">Admin Login</a>
    <a href="reseller_login.php">Reseller Login</a>
  </div>
  <a href="index.php" style="display:block; margin-top:30px;">← Back to Home</a>
</body>
</html>
