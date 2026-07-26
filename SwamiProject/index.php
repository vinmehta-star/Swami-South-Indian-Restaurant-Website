<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SWAMI — Home</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
      <li><a href="index.php" class="active">Home</a></li>
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

<section class="hero" style="background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('images/background.jpg') center/cover no-repeat;">
  <div class="hero-text">
    <h1>SWAMI</h1>
    <p>Celebrate The Culture</p>
    <a href="shop.php" class="btn btn-light btn-menu" style="display: block; margin: 5rem auto 0 auto; width: fit-content;">Show full</a>
  </div>
</section>

<section class="menu" ng-controller="HomeController">
  <h2>Our specialities</h2>

  <div class="carousel-wrapper">
    <button class="carousel-button carousel-button-prev">
      <i class="fas fa-chevron-left"></i>
    </button>
    
    <div class="carousel">
      <div class="carousel-track">
        
        <div class="item carousel-slide" ng-repeat="item in featuredProducts track by $index">
          <img ng-src="{{ item.image }}" alt="{{ item.name }}">
          <div class="item-text">
            <h3>{{ item.name }}</h3>
            <p>₹{{ item.price | number:2 }}</p>
            
            <form class="add-to-cart-form" ng-submit="addToCart(item)">
              <input type="number" class="cart-quantity" ng-model="quantities[item.id]" min="1" required>
              <button type="submit" id="btn-home-{{item.id}}" class="btn-add-to-cart">Add to Cart</button>
            </form>
          </div>
        </div>
        </div>
    </div>

    <button class="carousel-button carousel-button-next">
      <i class="fas fa-chevron-right"></i>
    </button>
  </div>

  <a href="shop.php" class="btn btn-light btn-menu" style="display: block; margin: 8rem auto 0 auto; width: fit-content;">Show full</a>
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