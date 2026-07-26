<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SWAMI — Contact Us</title>
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
      <li><a href="index.php">Home</a></li>
      <li><a href="shop.php">Shop</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="contact.php" class="active">Contact us</a></li>
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

<section class="contact-page">
  <h2>Get in Touch</h2>
  <p class="contact-subtitle">Have a question or want to book a table? Drop us a message!</p>

  <div class="contact-form-container">
    <h3>Send us a Message</h3>
    
    <div class="contact-info">
      <div class="info-block">
        <h4>Address</h4>
        <p>New Link Road, Malad West, Mumbai 400064</p>
      </div>
      <div class="info-block">
        <h4>Email</h4>
        <p>swami@info.com</p>
      </div>
      <div class="info-block">
        <h4>Phone</h4>
        <p>022-49677680</p>
      </div>
    </div>

    <form class="contact-form">
      <div class="form-row">
        <div class="form-group">
          <label>Name</label>
          <input type="text" required>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" required>
        </div>
      </div>
      
      <div class="form-group full-width">
        <label>Subject</label>
        <input type="text" required>
      </div>
      
      <div class="form-group full-width">
        <label>Message</label>
        <textarea rows="4" required></textarea>
      </div>

      <button type="submit" class="btn btn-dark">Send Message</button>
    </form>
  </div>
</section>

<footer>
  <div class="footer-container">
    <div class="footer-column">
      <h4>Contact</h4>
      <p>SWAMI</p>
      <p>Mumbai 400064</p>
    </div>
    <div class="footer-column">
      <p>Tel: 022-49677680</p>
      <p>Email: swami@info.com</p>
      <div class="social-icons">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-youtube"></i></a>
      </div>
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