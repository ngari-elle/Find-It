<?php
require_once __DIR__ . '/includes/bootstrap.php'; require_login();
$stmt = database()->prepare("SELECT c.*, l.item_name AS lost_name, f.item_name AS found_name FROM recovery_requests c JOIN match_suggestions m ON m.id = c.match_id JOIN item_reports l ON l.id = m.lost_report_id JOIN item_reports f ON f.id = m.found_report_id WHERE c.claimant_id = ? ORDER BY c.created_at DESC"); $stmt->execute([current_user()['id']]); $claims = $stmt->fetchAll();
$pageTitle = 'My claims'; require __DIR__ . '/includes/header.php';
?>
<main class="page-shell"><div class="container"><p class="eyebrow">Recovery requests</p><h1>My claims</h1><div class="grid grid-2"><?php foreach ($claims as $claim): ?><article class="card"><h2><?= e($claim['lost_name']) ?> ↔ <?= e($claim['found_name']) ?></h2><p class="muted"><?= e($claim['private_details']) ?></p><span class="status status-<?= e($claim['status'] === 'pending' ? 'pending' : ($claim['status'] === 'rejected' ? 'rejected' : 'approved')) ?>"><?= e(ucfirst($claim['status'])) ?></span></article><?php endforeach; ?></div><?php if (!$claims): ?><div class="empty-state"><h2>No recovery requests</h2><p>When a match looks right, submit a private recovery request.</p><a class="button" href="my-matches.php">View matches</a></div><?php endif; ?></div></main>
<?php require __DIR__ . '/includes/footer.php'; ?>
