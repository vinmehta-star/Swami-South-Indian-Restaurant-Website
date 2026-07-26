<?php
session_start();
require 'db_connect.php';
$error = "";
$email = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Email and password are required.";
    } else {
        $sql = "SELECT user_id, username, password_hash FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password_hash'])) {
                session_regenerate_id(true);
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit;
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Invalid email or password.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SWAMI — Login</title>
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
        <a href="login.php" class="nav-auth-link active">Login</a>
        <a href="register.php" class="nav-auth-link">Register</a>
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
    <h2>Login</h2>
    
    <div class="auth-message">
      <?php
        if (!empty($error)) {
          echo '<p class="error">' . htmlspecialchars($error) . '</p>';
        }
        
        if (isset($_GET['status']) && $_GET['status'] == 'reg_success') {
          echo '<p class="success">Registration successful! Please login.</p>';
        }
      ?>
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-dark">Login</button>
    <p class="auth-switch">Don't have an account? <a href="register.php">Register here</a></p>
  </form>
</section>
<footer>
  <div class="footer-container">
    </div>
</footer>
</body>
</html>