<?php
require_once __DIR__ . '/includes/bootstrap.php'; require_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('my-reports.php');
verify_csrf(); $id = filter_input(INPUT_POST, 'report_id', FILTER_VALIDATE_INT);
$stmt = database()->prepare("UPDATE item_reports SET status = 'withdrawn' WHERE id = ? AND user_id = ? AND status IN ('active', 'under_review')");
$stmt->execute([$id ?: 0, current_user()['id']]); flash('success', $stmt->rowCount() ? 'Report withdrawn.' : 'The report could not be withdrawn.'); redirect('my-reports.php');
