<?php
require_once __DIR__ . '/includes/bootstrap.php';
$reports = database()->query("SELECT id, report_type, item_name, category, location, incident_date, status FROM item_reports WHERE status = 'active' ORDER BY created_at DESC LIMIT 3")->fetchAll();
$pageTitle = 'Lost and found, brought together';
require __DIR__ . '/includes/header.php';
?>
<main>
  <section class="hero"><div class="container hero-layout"><div>
    <p class="eyebrow">University lost and found</p><h1>Bring a missing thing back into reach.</h1>
    <p class="lead">FindIt gives students and staff one clear place to report, browse, and reconnect with lost belongings around campus.</p>
    <div class="button-row"><a class="button" href="browse.php">Browse reports</a><a class="button secondary" href="register.php">Create an account</a></div>
  </div><aside class="hero-mark"><strong>01</strong><p>One shared noticeboard for the things campus is still looking for.</p></aside></div></section>
  <section class="section"><div class="container"><div class="section-heading"><div><p class="eyebrow">Live activity</p><h2>Recent reports</h2></div><a href="browse.php">View all reports</a></div>
    <div class="grid grid-3">
      <?php foreach ($reports as $report): ?><article class="card report-card"><span class="type-label"><?= e($report['report_type']) ?> item</span><h3><?= e($report['item_name']) ?></h3><p class="muted"><?= e($report['category']) ?> · <?= e($report['location']) ?></p><div class="meta"><span><?= e($report['incident_date']) ?></span><span class="status status-active">Active</span></div><div class="card-footer"><a href="report-details.php?id=<?= (int) $report['id'] ?>">View details</a></div></article><?php endforeach; ?>
      <?php if (!$reports): ?><div class="empty-state"><h2>No active reports yet</h2><p>Be the first to report a lost or found item.</p><a class="button" href="report-create.php">Report an item</a></div><?php endif; ?>
    </div>
  </div></section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
