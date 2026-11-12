<?php
require_once __DIR__ . '/includes/bootstrap.php'; require_login();
$sql = "SELECT m.*, l.item_name AS lost_name, l.category AS lost_category, f.item_name AS found_name, f.category AS found_category, l.user_id AS lost_owner, f.user_id AS found_owner
FROM match_suggestions m JOIN item_reports l ON l.id = m.lost_report_id JOIN item_reports f ON f.id = m.found_report_id
WHERE (l.user_id = ? OR f.user_id = ?) AND m.status = 'suggested' ORDER BY m.score DESC";
$stmt = database()->prepare($sql); $stmt->execute([current_user()['id'], current_user()['id']]); $matches = $stmt->fetchAll();
$pageTitle = 'My matches'; require __DIR__ . '/includes/header.php';
?>
<main class="page-shell"><div class="container"><p class="eyebrow">Suggested connections</p><h1>My matches</h1><p class="lead">Suggestions are stored in the database by the matching process. Review private ownership details only through a claim.</p><div class="grid grid-2"><?php foreach ($matches as $match): ?><article class="card"><div class="score"><strong><?= (int) $match['score'] ?>%</strong><div><h2><?= e($match['lost_name']) ?> ↔ <?= e($match['found_name']) ?></h2><div class="score-track"><span style="width:<?= (int) $match['score'] ?>%"></span></div></div></div><ul class="reason-list"><?php foreach (explode('|', $match['match_reasons']) as $reason): ?><li><?= e($reason) ?></li><?php endforeach; ?></ul><p style="margin-top:1rem"><a class="button small-button" href="claim.php?match_id=<?= (int) $match['id'] ?>">Submit recovery request</a></p></article><?php endforeach; ?></div><?php if (!$matches): ?><div class="empty-state" style="margin-top:1.5rem"><h2>No match suggestions yet</h2><p>As reports are added, compatible lost and found reports can be linked here.</p></div><?php endif; ?></div></main>
<?php require __DIR__ . '/includes/footer.php'; ?>
