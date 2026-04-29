<?php
// Action: Delete a work experience entry
require_once __DIR__ . '/../../bootstrap.php';
$fn->authPage();

$slug = trim($_GET['slug'] ?? '');

if (isset($_GET['id']) && isset($_GET['resume_id'])) {
    $id        = intval($_GET['id']);
    $resume_id = intval($_GET['resume_id']);
    $user_id   = $fn->Auth()['id'];

    if ($id > 0 && $resume_id > 0) {
        // Verify resume belongs to user
        $check = $db->prepare("SELECT id FROM resumes WHERE id = ? AND user_id = ?");
        $check->bind_param("ii", $resume_id, $user_id);
        $check->execute();
        if (!$check->get_result()->fetch_assoc()) {
            $check->close();
            $fn->setError('Unauthorized action.');
            $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
        }
        $check->close();

        $stmt = $db->prepare("DELETE FROM experiences WHERE id = ? AND resume_id = ?");
        $stmt->bind_param("ii", $id, $resume_id);

        try {
            $stmt->execute();
            $stmt->close();
            $fn->setAlert('Experience successfully deleted!');
        } catch (Exception $error) {
            $stmt->close();
            $fn->setError('Failed to delete experience.');
        }
        $fn->redirect(BASE_URL . 'public/pages/internal/updateresume.php?resume=' . urlencode($slug));
    } else {
        $fn->setError('Invalid request.');
        $fn->redirect(BASE_URL . 'public/pages/internal/updateresume.php?resume=' . urlencode($slug));
    }
} else {
    $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
}
