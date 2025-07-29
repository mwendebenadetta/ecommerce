<?php
require 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$conn = new mysqli("localhost", "root", "", "ecommerce_db");

// Fetch all orders with product and reseller info
$result = $conn->query("
    SELECT 
        o.id,
        o.customer_name,
        o.phone,
        o.address,
        p.name AS product_name,
        r.name AS reseller_name,
        r.location,
        o.created_at
    FROM orders o
    LEFT JOIN product p ON o.product_id = p.id
    LEFT JOIN resellers r ON p.reseller_id = r.id
    ORDER BY o.created_at DESC
");

// Start HTML for PDF
$html = '
    <h2 style="text-align:center;">📋 All Customer Orders</h2>
    <table border="1" cellspacing="0" cellpadding="6" width="100%">
        <thead>
            <tr style="background:#28a745; color:white;">
                <th>#</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Product</th>
                <th>Reseller</th>
                <th>Location</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>';

$count = 1;
while ($row = $result->fetch_assoc()) {
    $html .= '<tr>
        <td>' . $count++ . '</td>
        <td>' . htmlspecialchars($row['customer_name']) . '</td>
        <td>' . htmlspecialchars($row['phone']) . '</td>
        <td>' . htmlspecialchars($row['address']) . '</td>
        <td>' . htmlspecialchars($row['product_name']) . '</td>
        <td>' . htmlspecialchars($row['reseller_name']) . '</td>
        <td>' . htmlspecialchars($row['location']) . '</td>
        <td>' . $row['created_at'] . '</td>
    </tr>';
}

$html .= '</tbody></table>';

// Create PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

// Output PDF to download
$dompdf->stream("admin_orders.pdf", ["Attachment" => 0]);
?>
