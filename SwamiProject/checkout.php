<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$session_id = session_id();
$sql = "SELECT * FROM cart WHERE session_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $session_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total_price = 0;
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total_price += ($row['price'] * $row['quantity']);
}
$tax = $total_price * 0.05;
$final_total = $total_price + $tax;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - SWAMI</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header></header>
    <section class="checkout-page">
        <h2>Checkout</h2>
        <div class="checkout-container">
            <div class="order-summary">
                <h3>Order Summary</h3>
                <?php foreach ($cart_items as $item): ?>
                <div class="summary-item">
                    <img src="<?php echo $item['image_path']; ?>" alt="">
                    <div class="item-details">
                        <span><?php echo $item['product_name']; ?> (x<?php echo $item['quantity']; ?>)</span>
                        <span>₹<?php echo $item['price'] * $item['quantity']; ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
                <div class="summary-totals">
                    <div class="summary-row"><span>Total (Inc. Tax)</span><span>₹<?php echo number_format($final_total, 2); ?></span></div>
                </div>
            </div>
            
            <form class="shipping-form" action="place_order.php" method="POST">
                <h3>Shipping Details</h3>
                <input type="text" name="full_name" placeholder="Full Name" required>
                <input type="text" name="address" placeholder="Address" required>
                <input type="text" name="city" placeholder="City" required>
                <input type="text" name="zip" placeholder="Zip Code" required>
                <button type="submit" class="btn btn-place-order">Place Order</button>
            </form>
        </div>
    </section>
    <footer>
  <div class="footer-container">
    <div class="footer-column">
      <h4>Contact</h4>
      <p>SWAMI</p>
      <p>New Link Road,</p>
      <p>Beside Goregaon Cabins</p>
      <p>Complex, Malad West</p>
      <p>Mumbai 400064</p>
    </div>
    <div class="footer-column">
      <p>Tel: 022-49677680</p>
      <p>Email: swami@info.com</p>
      <p><a href="#">Book A Table</a></p>
      <div class="social-icons">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-youtube"></i></a>
      </div>
    </div>
    <div class="footer-column">
      <h4>Subscribe to Newsletter</h4>
      <form class="subscribe-form">
        <input type="email" placeholder="Enter your email">
        <button type="submit" class="btn btn-dark">Join</button>
      </form>
    </div>
  </div>
</footer>
</body>
</html>