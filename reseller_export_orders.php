<?php
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

session_start();
$conn = new mysqli("localhost", "root", "", "ecommerce_db");

if (!isset($_SESSION['reseller_id'])) {
    echo "Access denied. Please login as a reseller.";
    exit();
}

$reseller_id = $_SESSION['reseller_id'];

// Get reseller-specific orders
$sql = "
    SELECT o.id, o.customer_name, o.phone, o.address, p.name AS product_name
    FROM orders o
    JOIN product p ON o.product_id = p.id
    WHERE p.reseller_id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $reseller_id);
$stmt->execute();
$result = $stmt->get_result();

// Generate HTML
$html = "<h2 style='text-align:center;'>📄 Reseller Order Report</h2>";
$html .= "<table border='1' cellpadding='10' cellspacing='0' width='100%'>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Address</th>
            </tr>";

$count = 1;
while ($row = $result->fetch_assoc()) {
    $html .= "<tr>
                <td>{$count}</td>
                <td>{$row['product_name']}</td>
                <td>{$row['customer_name']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['address']}</td>
              </tr>";
    $count++;
}
$html .= "</table>";

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("reseller_orders_report.pdf", array("Attachment" => false));
exit();
?>
