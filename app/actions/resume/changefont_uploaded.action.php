<?php
// Action: Change uploaded resume font (AJAX)
require_once __DIR__ . '/../../bootstrap.php';
$fn->authPage();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resume_id = intval($_POST['resume_id'] ?? 0);
    $font      = trim($_POST['font'] ?? '');
    $user_id   = $fn->Auth()['id'];

    if ($resume_id > 0 && $font) {
        $stmt = $db->prepare("UPDATE uploaded_resumes SET font = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("sii", $font, $resume_id, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}
