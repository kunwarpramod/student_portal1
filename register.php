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
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = trim($_POST['student_id'] ?? '');
    $full_name  = trim($_POST['full_name'] ?? '');
    $password   = $_POST['password'] ?? '';

    if ($student_id === '' || $full_name === '' || $password === '') {
        $errors[] = 'All fields are required.';
    }

    if (!$errors) {
        try {
            // Check if student_id exists
            $stmt = $pdo->prepare('SELECT id FROM students WHERE student_id = ?');
            $stmt->execute([$student_id]);
            if ($stmt->fetch()) {
                $errors[] = 'Student ID already exists.';
            } else {
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $ins = $pdo->prepare('INSERT INTO students (student_id, full_name, password_hash) VALUES (?, ?, ?)');
                $ins->execute([$student_id, $full_name, $hash]);
                // Redirect to login
                header('Location: login.php?registered=1');
                exit;
            }
        } catch (Exception $e) {
            $errors[] = 'Registration failed.';
        }
    }
}

include __DIR__ . '/includes/header.php';
?>

<h2>Register</h2>
<?php foreach ($errors as $e): ?>
  <p style="color:crimson;"><?php echo htmlspecialchars($e); ?></p>
<?php endforeach; ?>

<form method="post" autocomplete="off">
  <label>Student ID</label>
  <input type="text" name="student_id" required>

  <label>Full Name</label>
  <input type="text" name="full_name" required>

  <label>Password</label>
  <input type="password" name="password" required>

  <button type="submit">Create Account</button>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>
