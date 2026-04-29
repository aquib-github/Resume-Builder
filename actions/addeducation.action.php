<?php
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../classes/Functions.php';
$fn->authPage();

$slug = trim($_POST['slug'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resume_id = intval($_POST['resume_id'] ?? 0);
    $course    = trim($_POST['course'] ?? '');
    $institute = trim($_POST['institute'] ?? '');
    $started   = trim($_POST['started'] ?? '');
    $ended     = trim($_POST['ended'] ?? '');

    if ($resume_id && $course && $institute && $started && $ended) {
        // Verify resume belongs to user
        $user_id = $fn->Auth()['id'];
        $check = $db->prepare("SELECT id FROM resumes WHERE id = ? AND user_id = ?");
        $check->bind_param("ii", $resume_id, $user_id);
        $check->execute();
        if (!$check->get_result()->fetch_assoc()) {
            $check->close();
            $fn->setError('Unauthorized action.');
            $fn->redirect('../myresumes.php');
        }
        $check->close();

        $stmt = $db->prepare("INSERT INTO educations (resume_id, course, institute, started, ended) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $resume_id, $course, $institute, $started, $ended);

        try {
            $stmt->execute();
            $stmt->close();
            $fn->setAlert('Education successfully added!');
        } catch (Exception $error) {
            $stmt->close();
            $fn->setError('Failed to add education.');
        }
        $fn->redirect('../updateresume.php?resume=' . urlencode($slug));
    } else {
        $fn->setError('Please fill the form!');
        $fn->redirect('../updateresume.php?resume=' . urlencode($slug));
    }
} else {
    $fn->redirect('../myresumes.php');
}