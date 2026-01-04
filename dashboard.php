<?php
require __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

// Theme cookie
$theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';

include __DIR__ . '/includes/header.php';
?>

<h2>Dashboard</h2>
<p>Welcome, <?php echo htmlspecialchars($_SESSION['full_name'] ?? 'Student'); ?>!</p>
<p>Your Student ID: <?php echo htmlspecialchars($_SESSION['student_id'] ?? ''); ?></p>

<ul>
  <li><a href="preference.php">Change Theme Preference</a></li>
  <li><a href="logout.php">Logout</a></li>
</ul>

<?php include __DIR__ . '/includes/footer.php'; ?>
