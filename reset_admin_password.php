<?php
$conn = new mysqli("localhost", "root", "", "ecommerce_db");

$new_password = password_hash("admin123", PASSWORD_DEFAULT); // new password is 'admin123'

$sql = "UPDATE admin_users SET password = '$new_password' WHERE username = 'admin'";
if ($conn->query($sql) === TRUE) {
    echo "✅ Password reset successfully to 'admin123'.";
} else {
    echo "❌ Error: " . $conn->error;
}
?>
