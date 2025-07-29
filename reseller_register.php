<!DOCTYPE html>
<html>
<head>
    <title>Reseller Registration</title>
</head>
<body>
    <h2>Reseller Registration</h2>
    <form method="POST" action="reseller_register.php">
        <input type="text" name="name" placeholder="Full Name" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <input type="text" name="phone" placeholder="Phone Number"><br><br>
        <input type="text" name="location" placeholder="Location"><br><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "ecommerce_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone    = $_POST['phone'];
    $location = $_POST['location'];

    $sql = "INSERT INTO resellers (name, email, password, phone, location)
            VALUES ('$name', '$email', '$password', '$phone', '$location')";

    if ($conn->query($sql) === TRUE) {
        echo "Reseller registered successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
