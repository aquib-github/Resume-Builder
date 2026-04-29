<?php
// Action: Delete a resume and all its related data
require_once __DIR__ . '/../../bootstrap.php';
$fn->authPage();

if (isset($_GET['id'])) {
    $id      = intval($_GET['id']);
    $user_id = $fn->Auth()['id'];

    if ($id > 0) {
        try {
            // Delete related records first
            $stmt = $db->prepare("DELETE FROM skills WHERE resume_id = ? AND resume_id IN (SELECT id FROM resumes WHERE user_id = ?)");
            $stmt->bind_param("ii", $id, $user_id);
            $stmt->execute();
            $stmt->close();

            $stmt = $db->prepare("DELETE FROM educations WHERE resume_id = ? AND resume_id IN (SELECT id FROM resumes WHERE user_id = ?)");
            $stmt->bind_param("ii", $id, $user_id);
            $stmt->execute();
            $stmt->close();

            $stmt = $db->prepare("DELETE FROM experiences WHERE resume_id = ? AND resume_id IN (SELECT id FROM resumes WHERE user_id = ?)");
            $stmt->bind_param("ii", $id, $user_id);
            $stmt->execute();
            $stmt->close();

            // Delete the resume itself
            $stmt = $db->prepare("DELETE FROM resumes WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $id, $user_id);
            $stmt->execute();
            $stmt->close();

            $fn->setAlert('Resume successfully deleted!');
            $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
        } catch (Exception $error) {
            $fn->setError('Failed to delete resume. Please try again.');
            $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
        }
    } else {
        $fn->setError('Invalid resume ID.');
        $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
    }
} else {
    $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
}
