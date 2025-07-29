<?php
// recent.php
include 'db.php'; // if you need DB access
include 'header.php'; // optional, if you have a shared header

echo "<h2>Recently Viewed Products</h2>";

if (isset($_COOKIE['viewed_products'])) {
    $viewed = json_decode($_COOKIE['viewed_products']);
    if (!empty($viewed)) {
        echo "<ul>";
        foreach ($viewed as $id) {
            // You can fetch full product info from DB if needed
            echo "<li><a href='product_details.php?id=$id'>View Product #$id</a></li>";
        }
        echo "</ul>";
    } else {
        echo "<p>You haven't viewed any products yet.</p>";
    }
} else {
    echo "<p>No recently viewed products found.</p>";
}

include 'footer.php'; // optional, if you have a shared footer
?>
