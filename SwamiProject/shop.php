<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SWAMI — Shop</title> 
  
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
      <li><a href="shop.php" class="active">Shop</a></li>
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

<section class="shop-page" ng-controller="ShopController">
  <h2>Our Menu</h2>
  <div class="shop-grid">
    <div class="shop-item" ng-repeat="item in products">
      <div class="shop-item-image">
        <span class="badge" ng-class="item.badge" ng-if="item.badge">{{ item.badgeText }}</span>
        <img ng-src="{{ item.image }}" alt="{{ item.name }}">
      </div>
      <div class="item-text">
        <h3>{{ item.name }}</h3>
        <p>₹{{ item.price | number:2 }}</p>
        
        <form class="add-to-cart-form" ng-submit="addToCart(item)">
          <input type="number" class="cart-quantity" ng-model="quantities[item.id]" min="1" required>
          <button type="submit" id="btn-{{item.id}}" class="btn btn-light btn-add-to-cart">Add to Cart</button>
        </form>
      </div>
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