<?php
require_once __DIR__ . '/includes/bootstrap.php';
if (current_user()) redirect('index.php');
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf(); $email = strtolower(post_string('email', 190)); $password = (string) ($_POST['password'] ?? '');
    $stmt = database()->prepare('SELECT id, full_name, email, password_hash, role FROM users WHERE email = ? LIMIT 1'); $stmt->execute([$email]); $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) { unset($user['password_hash']); session_regenerate_id(true); $_SESSION['user'] = $user; redirect('index.php'); }
    $error = 'The email or password is not correct.';
}
$pageTitle = 'Log in'; require __DIR__ . '/includes/header.php';
?>
<main class="page-shell"><div class="container"><div class="form-card card"><p class="eyebrow">Welcome back</p><h1>Log in</h1><?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?><form method="post" class="stack"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><div class="form-field"><label for="email">Email</label><input id="email" name="email" type="email" required></div><div class="form-field"><label for="password">Password</label><input id="password" name="password" type="password" required></div><button class="button" type="submit">Log in</button></form><p>Need an account? <a href="register.php">Create one</a>.</p></div></div></main>
<?php require __DIR__ . '/includes/footer.php'; ?>
