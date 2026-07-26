<?php
session_start();
require 'db_connect.php';
header('Content-Type: application/json');

$session_id = session_id();
$sql = "SELECT * FROM cart WHERE session_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $session_id);
$stmt->execute();
$result = $stmt->get_result();

$cart = [];
$subtotal = 0;
while ($row = $result->fetch_assoc()) {
    $cart[] = $row;
    $subtotal += ($row['price'] * $row['quantity']);
}

$tax = $subtotal * 0.05;
$total = $subtotal + $tax;

echo json_encode([
    'success' => true,
    'cart' => $cart,
    'totals' => [
        'subtotal' => number_format($subtotal, 2),
        'tax' => number_format($tax, 2),
        'total' => number_format($total, 2)
    ]
]);
?>