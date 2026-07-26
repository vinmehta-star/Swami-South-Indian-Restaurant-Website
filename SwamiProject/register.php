<?php

session_start();
require 'db_connect.php';

$error = "";
$username = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } else {
        
        $sql_check = "SELECT user_id FROM users WHERE username = ? OR email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("ss", $username, $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $error = "Username or email already taken.";
        } else {
            
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $sql_insert = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("sss", $username, $email, $password_hash);

            if ($stmt_insert->execute()) {
                header("Location: login.php?status=reg_success");
                exit;
            } else {
                $error = "Registration failed. Please try again.";
            }
            $stmt_insert->close();
        }
        $stmt_check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SWAMI — Register</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="script.js" defer></script>
</head>
<body>

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
        <a href="register.php" class="nav-auth-link active">Register</a>
      <?php endif; ?>

      <a href="cart.php" class="cart-icon">
        <i class="fas fa-shopping-cart"></i>
        <span class="cart-badge">0</span>
      </a>
    </div>

  </nav>
</header>

<section class="auth-page">
  <form class="auth-form" action="" method="POST">
    <h2>Create Account</h2>
    
    <div class="auth-message">
      <?php
        if (!empty($error)) {
          echo '<p class="error">' . htmlspecialchars($error) . '</p>';
        }
      ?>
    </div>
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
    </div>
    <div class="form-group">
      <label for="confirm_password">Confirm Password</label>
      <input type="password" id="confirm_password" name="confirm_password" required>
    </div>
    <button type="submit" class="btn btn-dark">Register</button>
    <p class="auth-switch">Already have an account? <a href="login.php">Login here</a></p>
  </form>
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