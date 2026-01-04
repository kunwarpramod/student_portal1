<?php
require __DIR__ . '/db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If already logged in, redirect
if (!empty($_SESSION['logged_in'])) {
    header('Location: dashboard.php');
    exit;
}

$errors = [];
$registered = isset($_GET['registered']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = trim($_POST['student_id'] ?? '');
    $password   = $_POST['password'] ?? '';

    if ($student_id === '' || $password === '') {
        $errors[] = 'Student ID and password are required.';
    } else {
        try {
            $stmt = $pdo->prepare('SELECT id, full_name, password_hash FROM students WHERE student_id = ?');
            $stmt->execute([$student_id]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['logged_in'] = true;
                $_SESSION['student_id'] = $student_id;
                $_SESSION['full_name'] = $user['full_name'];
                header('Location: dashboard.php');
                exit;
            } else {
                $errors[] = 'Invalid credentials.';
            }
        } catch (Exception $e) {
            $errors[] = 'Login failed.';
        }
    }
}

include __DIR__ . '/includes/header.php';
?>

<h2>Login</h2>
<?php if ($registered): ?>
  <p style="color:green;">Registration successful. Please log in.</p>
<?php endif; ?>

<?php foreach ($errors as $e): ?>
  <p style="color:crimson;"><?php echo htmlspecialchars($e); ?></p>
<?php endforeach; ?>

<form method="post" autocomplete="off">
  <label>Student ID</label>
  <input type="text" name="student_id" required>

  <label>Password</label>
  <input type="password" name="password" required>

  <button type="submit">Login</button>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>
