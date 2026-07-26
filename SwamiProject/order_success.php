<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed — SWAMI</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="style.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <script src="script.js" defer></script>
</head>
<body ng-app="swamiApp">
    <header>
      <nav class="navbar">
        <img src="images/logo.png" alt="Swami Logo" class="logo">
        <ul class="nav-links">
          <li><a href="index.php">Home</a></li>
          <li><a href="shop.php">Shop</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="contact.php">Contact us</a></li>
        </ul>

        <div class="navbar-right">
          <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <span class="nav-welcome">Hi, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            <a href="logout.php" class="nav-auth-link">Logout</a>
          <?php else: ?>
            <a href="login.php" class="nav-auth-link">Login</a>
            <a href="register.php" class="nav-auth-link">Register</a>
          <?php endif; ?>

          <a href="cart.php" class="cart-icon">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-badge">0</span>
          </a>
        </div>
      </nav>
    </header>
    <section class="success-page">
        <div class="success-container">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Thank You!</h1>
            <p>Your order has been placed successfully.</p>
            
            <p>Order ID: <span class="success-order-id">#<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '---'; ?></span></p>
            
            <a href="index.php" class="btn-home">Return to Home</a>
        </div>
    </section>

    <footer>
      <div class="footer-container">
        <div class="footer-column">
          <h4>Contact</h4>
          <p>SWAMI</p>
          <p>New Link Road, Malad West</p>
          <p>Mumbai 400064</p>
        </div>
        <div class="footer-column">
          <p>Tel: 022-49677680</p>
          <p>Email: swami@info.com</p>
        </div>
        <div class="footer-column">
          <h4>Subscribe</h4>
          <form class="subscribe-form">
            <input type="email" placeholder="Enter your email">
            <button type="submit" class="btn btn-dark">Join</button>
          </form>
        </div>
      </div>
    </footer>
</body>
</html>