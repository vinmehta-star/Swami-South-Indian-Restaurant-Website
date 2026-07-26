<?php
session_start();
require 'db_connect.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$session_id = session_id();
$product_id = $data['id'];
$quantity = $data['quantity'];
$name = $data['name'];
$price = $data['price'];
$image = $data['image'];

$check = $conn->prepare("SELECT quantity FROM cart WHERE session_id=? AND product_id=?");
$check->bind_param("si", $session_id, $product_id);
$check->execute();
$res = $check->get_result();

if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $new_qty = $row['quantity'] + $quantity;
    $upd = $conn->prepare("UPDATE cart SET quantity=? WHERE session_id=? AND product_id=?");
    $upd->bind_param("isi", $new_qty, $session_id, $product_id);
    $upd->execute();
} else {
    $ins = $conn->prepare("INSERT INTO cart (session_id, product_id, quantity, product_name, price, image_path) VALUES (?, ?, ?, ?, ?, ?)");
    $ins->bind_param("siisds", $session_id, $product_id, $quantity, $name, $price, $image);
    $ins->execute();
}
echo json_encode(['success' => true]);
?>