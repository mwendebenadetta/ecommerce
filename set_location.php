<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $location = $_POST['location'] ?? '';
    setcookie('user_location', $location, time() + (86400 * 30), "/"); // 30 days
    header('Location: index.php');
    exit();
}
