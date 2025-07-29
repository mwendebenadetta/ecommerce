<?php
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$conn = new mysqli("localhost", "root", "", "ecommerce_db");

$sql = "
    SELECT o.id, o.customer_name, o.phone, o.address, p.name AS product_name, r.name AS reseller_name
    FROM orders o
    JOIN product p ON o.product_id = p.id
    LEFT JOIN resellers r ON p.reseller_id = r.id
";
$result = $conn->query($sql);

// Generate HTML
$html = "<h2 style='text-align:center;'>📄 All Orders Report (Admin)</h2>";
$html .= "<table border='1' cellpadding='10' cellspacing='0' width='100%'>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Reseller</th>
            </tr>";

$count = 1;
while ($row = $result->fetch_assoc()) {
    $html .= "<tr>
                <td>{$count}</td>
                <td>{$row['product_name']}</td>
                <td>{$row['customer_name']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['address']}</td>
                <td>{$row['reseller_name']}</td>
              </tr>";
    $count++;
}
$html .= "</table>";

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("all_orders_report.pdf", array("Attachment" => false));
exit();
?>
