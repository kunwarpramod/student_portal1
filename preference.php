<?php
require __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

$theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = $_POST['theme'] ?? 'light';
    // Persist for 30 days
    setcookie('theme', $value, time() + 15, '/', '', false, true);
    $theme = $value;
    $message = 'Theme updated.';
}

include __DIR__ . '/includes/header.php';
?>

<h2>Preference</h2>
<?php if ($message): ?>
  <p style="color:green;"><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form method="post">
  <label>Select Theme</label>
  <select name="theme">
    <option value="light" <?php echo $theme === 'light' ? 'selected' : ''; ?>>Light</option>
    <option value="dark"  <?php echo $theme === 'dark'  ? 'selected' : ''; ?>>Dark</option>
  </select>
  <button type="submit">Save Preference</button>
</form>

<p>Current theme: <strong><?php echo htmlspecialchars($theme); ?></strong></p>

<?php include __DIR__ . '/includes/footer.php'; ?>
