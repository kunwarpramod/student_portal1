<?php
// includes/header.php — Common header with nav
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Grade Portal</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body class="<?php echo htmlspecialchars($theme); ?>">
  <nav class="container">
    <strong>Student Grade Portal</strong>
    <?php if (!empty($_SESSION['logged_in'])): ?>
      <a href="dashboard.php">Dashboard</a>
      <a href="preference.php">Preference</a>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
    <?php endif; ?>
  </nav>
  <main class="container">
  </main>
</body>
</html>
