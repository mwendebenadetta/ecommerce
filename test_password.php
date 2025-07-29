<?php
$input_password = "admin123";
$hashed_password_from_db = '$2y$10$L4B5kaFjSKKhPEa9VfRI2uUN9xFwd0RwC4CmJ8LItjlHXyXnloTw6'; // this must match exactly

if (password_verify($input_password, $hashed_password_from_db)) {
    echo "✅ Password is CORRECT!";
} else {
    echo "❌ Password is INCORRECT!";
}
?>
