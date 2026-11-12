<?php
require_once __DIR__ . '/includes/bootstrap.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$stmt = database()->prepare("SELECT r.*, u.full_name FROM item_reports r JOIN users u ON u.id = r.user_id WHERE r.id = ? AND r.status <> 'withdrawn'");
$stmt->execute([$id ?: 0]); $report = $stmt->fetch();
if (!$report) { http_response_code(404); exit('Report not found.'); }
$pageTitle = $report['item_name']; require __DIR__ . '/includes/header.php';
?>
<main class="page-shell"><div class="container narrow"><p class="breadcrumbs"><a href="browse.php">Browse reports</a> / Report details</p><article class="card"><span class="type-label"><?= e($report['report_type']) ?> item</span><h1><?= e($report['item_name']) ?></h1><p class="muted"><?= e($report['description']) ?></p><dl class="definition-list"><dt>Category</dt><dd><?= e($report['category']) ?></dd><dt>Colour</dt><dd><?= e($report['colour'] ?: 'Not provided') ?></dd><dt>Location</dt><dd><?= e($report['location']) ?></dd><dt>Date</dt><dd><?= e($report['incident_date']) ?></dd><dt>Status</dt><dd><span class="status status-active"><?= e(str_replace('_', ' ', ucfirst($report['status']))) ?></span></dd></dl><?php if (current_user() && (int) current_user()['id'] !== (int) $report['user_id']): ?><p style="margin-top:1.5rem"><a class="button" href="my-matches.php">Check possible matches</a></p><?php elseif (!current_user()): ?><p style="margin-top:1.5rem"><a class="button" href="login.php">Log in to report or claim an item</a></p><?php endif; ?></article></div></main>
<?php require __DIR__ . '/includes/footer.php'; ?>
