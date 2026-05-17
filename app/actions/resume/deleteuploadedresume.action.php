<?php
// Action: Delete uploaded resume
require_once __DIR__ . '/../../bootstrap.php';
$fn->authPage();

$id = intval($_GET['id'] ?? 0);
$user_id = $fn->Auth()['id'];

if ($id > 0) {
    // Get file path before deleting
    $stmt = $db->prepare("SELECT file_path FROM uploaded_resumes WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $file_path = __DIR__ . '/../../../public/assets/uploads/' . $row['file_path'];
        
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        
        $stmt->close();
        
        // Delete record
        $stmt2 = $db->prepare("DELETE FROM uploaded_resumes WHERE id = ? AND user_id = ?");
        $stmt2->bind_param("ii", $id, $user_id);
        
        try {
            $stmt2->execute();
            $fn->setAlert('Uploaded resume deleted successfully!');
        } catch (Exception $e) {
            $fn->setError('Failed to delete uploaded resume.');
        }
        $stmt2->close();
    } else {
        $fn->setError('Resume not found or access denied.');
    }
}

$fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
