<?php
session_start();
require 'db_connect.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$session_id = session_id();
$product_id = $data['product_id'];
$action = $data['action'];

if ($action == 'remove_item') {
    $stmt = $conn->prepare("DELETE FROM cart WHERE session_id=? AND product_id=?");
    $stmt->bind_param("si", $session_id, $product_id);
    $stmt->execute();
} elseif ($action == 'update_quantity') {
    $qty = $data['quantity'];
    $stmt = $conn->prepare("UPDATE cart SET quantity=? WHERE session_id=? AND product_id=?");
    $stmt->bind_param("isi", $qty, $session_id, $product_id);
    $stmt->execute();
}

echo json_encode(['success' => true]);
?>