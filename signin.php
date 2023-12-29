<?php
session_start();

// Redirection si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="x-icon" href="images/favicon-32x32.png">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>
<body>
  <div class="container">
    <form id="signInForm" class="form active" action="login.php" method="POST">
      <h2>Sign In</h2>
      <input type="text" name="signin_username" placeholder="Username" required>
      <input type="password" name="signin_password" placeholder="Password" required>
      <button type="submit">Login</button>
      <p class="toggle-signup">Not a member? <a href="#" id="toggleSignup">Sign Up</a></p>
    </form>
    <form id="signUpForm" class="form" action="login.php" method="POST">
      <h2>Sign Up</h2>
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Register</button>
      <p class="toggle-signup">Already have an account? <a href="#" id="toggleSignin">Sign In</a></p>
    </form>
  </div>

  <script src="js/login.js"></script>
</body>
</html>
