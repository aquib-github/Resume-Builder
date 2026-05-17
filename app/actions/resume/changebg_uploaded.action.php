<?php
// Action: Change uploaded resume background tile (AJAX)
require_once __DIR__ . '/../../bootstrap.php';
$fn->authPage();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resume_id  = intval($_POST['resume_id'] ?? 0);
    $background = trim($_POST['background'] ?? '');
    $user_id    = $fn->Auth()['id'];

    if ($resume_id > 0 && $background) {
        if (!preg_match('/^tile\d+\.png$/', $background)) {
            http_response_code(400);
            exit('Invalid background.');
        }

        $stmt = $db->prepare("UPDATE uploaded_resumes SET background = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("sii", $background, $resume_id, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}
