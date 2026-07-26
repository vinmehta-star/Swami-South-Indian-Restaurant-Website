<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SWAMI — Cart</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
  <script src="angular-app.js"></script>
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

<section class="cart-page" ng-controller="CartController">
  <h2>Your Shopping Cart</h2>

  <div class="cart-container">
    
    <div class="cart-items-list">
      
      <p ng-if="isLoading" style="text-align:center;">Loading cart...</p>

      <p class="cart-empty-message" ng-if="!isLoading && cart.length === 0" ng-cloak>
        Your cart is currently empty.
      </p>

      <div class="cart-item" ng-repeat="item in cart" ng-cloak>
        <img ng-src="{{ item.image_path }}" alt="{{ item.product_name }}">
        <div class="cart-item-info">
          <h3>{{ item.product_name }}</h3>
          <p>₹{{ item.price }}</p>
          <input type="number" 
                 class="cart-item-quantity" 
                 ng-model="item.quantity" 
                 ng-change="updateQty(item)"
                 min="1">
        </div>
        <button class="cart-item-remove" ng-click="removeItem(item.product_id)">
            <i class="fas fa-trash"></i>
        </button>
      </div>

    </div>

    <div class="cart-summary" ng-if="cart.length > 0" ng-cloak>
      <h3>Summary</h3>
      <div class="summary-row">
        <span>Subtotal</span>
        <span>₹{{ totals.subtotal }}</span>
      </div>
      <div class="summary-row">
        <span>Taxes (5%)</span>
        <span>₹{{ totals.tax }}</span>
      </div>
      <div class="summary-row total">
        <span>Total</span>
        <span>₹{{ totals.total }}</span>
      </div>
      <button class="btn btn-dark btn-checkout" ng-click="checkout()">Proceed to Checkout</button>
    </div>

  </div>
</section>

<footer>
  <div class="footer-container">
    <div class="footer-column">
      <h4>Contact</h4>
      <p>SWAMI</p>
      <p>New Link Road,</p>
      <p>Beside Goregaon Cabins</p>
      <p>Complex,</p>
      <p>Malad West,</p>
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
      <h4>Subscribe to Get My Newsletter</h4>
      <form class="subscribe-form">
        <input type="email" placeholder="Enter your email here">
        <button type="submit" class="btn btn-dark">Join</button>
      </form>
    </div>
  </div>
</footer>

</body>
</html>