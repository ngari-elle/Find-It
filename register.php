<?php
require_once __DIR__ . '/includes/bootstrap.php';
if (current_user()) redirect('index.php');
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = post_string('full_name', 120); $email = strtolower(post_string('email', 190));
    $password = (string) ($_POST['password'] ?? ''); $confirmation = (string) ($_POST['password_confirmation'] ?? '');
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a name and a valid email address.';
    if (strlen($password) < 8 || $password !== $confirmation) $errors[] = 'Passwords must match and be at least 8 characters.';
    if (!$errors) {
        try {
            $stmt = database()->prepare('INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)');
            $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
            flash('success', 'Account created. You can now log in.'); redirect('login.php');
        } catch (PDOException $exception) {
            if ($exception->errorInfo[1] === 1062) $errors[] = 'That email address is already registered.';
            else throw $exception;
        }
    }
}
$pageTitle = 'Create account'; require __DIR__ . '/includes/header.php';
?>
<main class="page-shell"><div class="container"><div class="form-card card"><p class="eyebrow">Join FindIt</p><h1>Create an account</h1>
<?php foreach ($errors as $error): ?><div class="alert error"><?= e($error) ?></div><?php endforeach; ?>
<form method="post" class="stack"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><div class="form-field"><label for="full_name">Full name</label><input id="full_name" name="full_name" maxlength="120" required></div><div class="form-field"><label for="email">Email</label><input id="email" name="email" type="email" maxlength="190" required></div><div class="form-field"><label for="password">Password</label><input id="password" name="password" type="password" minlength="8" required></div><div class="form-field"><label for="password_confirmation">Confirm password</label><input id="password_confirmation" name="password_confirmation" type="password" minlength="8" required></div><button class="button" type="submit">Create account</button></form></div></div></main>
<?php require __DIR__ . '/includes/footer.php'; ?>
