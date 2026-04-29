<?php
// Action: Add work experience to a resume
require_once __DIR__ . '/../../bootstrap.php';
$fn->authPage();

$slug = trim($_POST['slug'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resume_id = intval($_POST['resume_id'] ?? 0);
    $position  = trim($_POST['position'] ?? '');
    $company   = trim($_POST['company'] ?? '');
    $started   = trim($_POST['started'] ?? '');
    $ended     = trim($_POST['ended'] ?? '');
    $job_desc  = trim($_POST['job_desc'] ?? '');

    if ($resume_id && $position && $company && $started && $ended && $job_desc) {
        // Verify resume belongs to user
        $user_id = $fn->Auth()['id'];
        $check = $db->prepare("SELECT id FROM resumes WHERE id = ? AND user_id = ?");
        $check->bind_param("ii", $resume_id, $user_id);
        $check->execute();
        if (!$check->get_result()->fetch_assoc()) {
            $check->close();
            $fn->setError('Unauthorized action.');
            $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
        }
        $check->close();

        $stmt = $db->prepare("INSERT INTO experiences (resume_id, position, company, job_desc, started, ended) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $resume_id, $position, $company, $job_desc, $started, $ended);

        try {
            $stmt->execute();
            $stmt->close();
            $fn->setAlert('Experience successfully added!');
        } catch (Exception $error) {
            $stmt->close();
            $fn->setError('Failed to add experience.');
        }
        $fn->redirect(BASE_URL . 'public/pages/internal/updateresume.php?resume=' . urlencode($slug));
    } else {
        $fn->setError('Please fill the form!');
        $fn->redirect(BASE_URL . 'public/pages/internal/updateresume.php?resume=' . urlencode($slug));
    }
} else {
    $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
}
