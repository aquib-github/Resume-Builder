<?php
// Action: Add a skill to a resume
require_once __DIR__ . '/../../bootstrap.php';
$fn->authPage();

$slug = trim($_POST['slug'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resume_id = intval($_POST['resume_id'] ?? 0);
    $skill     = trim($_POST['skill'] ?? '');

    if ($resume_id && $skill) {
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

        $stmt = $db->prepare("INSERT INTO skills (resume_id, skill) VALUES (?, ?)");
        $stmt->bind_param("is", $resume_id, $skill);

        try {
            $stmt->execute();
            $stmt->close();
            $fn->setAlert('Skill successfully added!');
        } catch (Exception $error) {
            $stmt->close();
            $fn->setError('Failed to add skill.');
        }
        $fn->redirect(BASE_URL . 'public/pages/internal/updateresume.php?resume=' . urlencode($slug));
    } else {
        $fn->setError('Please fill the form!');
        $fn->redirect(BASE_URL . 'public/pages/internal/updateresume.php?resume=' . urlencode($slug));
    }
} else {
    $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
}
