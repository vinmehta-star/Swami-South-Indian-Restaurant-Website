<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['loggedin'])) { header("Location: login.php"); exit; }
$user_id = $_SESSION['user_id'];
$session_id = session_id();
$address = $_POST['address'] . ", " . $_POST['city'] . " " . $_POST['zip'];

$res = $conn->query("SELECT * FROM cart WHERE session_id='$session_id'");
$total = 0;
while($row = $res->fetch_assoc()) { $total += ($row['price'] * $row['quantity']); }
$total = $total * 1.05; 

$stmt = $conn->prepare("INSERT INTO orders (user_id, shipping_address, total_price) VALUES (?, ?, ?)");
$stmt->bind_param("isd", $user_id, $address, $total);
$stmt->execute();
$order_id = $conn->insert_id;

$res->data_seek(0);
while($row = $res->fetch_assoc()) {
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, quantity, price_at_purchase) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisid", $order_id, $row['product_id'], $row['product_name'], $row['quantity'], $row['price']);
    $stmt->execute();
}

$stmt = $conn->prepare("DELETE FROM cart WHERE session_id = ?");
$stmt->bind_param("s", $session_id);
$stmt->execute();
header("Location: order_success.php?id=$order_id");
?>