<?php
// Action: Upload an existing resume document (PDF)
require_once __DIR__ . '/../../bootstrap.php';
$fn->authPage();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resume_title = trim($_POST['resume_title'] ?? '');
    
    if (isset($_FILES['resume_file']) && $_FILES['resume_file']['error'] === UPLOAD_ERR_OK && $resume_title) {
        $file_tmp = $_FILES['resume_file']['tmp_name'];
        $file_name = $_FILES['resume_file']['name'];
        $file_size = $_FILES['resume_file']['size'];
        $file_type = $_FILES['resume_file']['type'];
        
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['pdf', 'doc', 'docx'];
        
        if (!in_array($ext, $allowed_ext)) {
            $fn->setError('Only PDF, DOC, and DOCX files are allowed.');
            $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
            exit;
        }
        
        if ($file_size > 5 * 1024 * 1024) { // 5MB limit
            $fn->setError('File size must be less than 5MB.');
            $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
            exit;
        }

        $upload_dir = __DIR__ . '/../../../public/assets/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $new_file_name = uniqid('resume_') . '.' . $ext;
        $dest_path = $upload_dir . $new_file_name;

        if (move_uploaded_file($file_tmp, $dest_path)) {
            $user_id    = $fn->Auth()['id'];
            $slug       = $fn->randomString();
            $updated_at = time();

            $stmt = $db->prepare(
                "INSERT INTO uploaded_resumes (user_id, resume_title, file_path, file_type, slug, updated_at, background, font)
                 VALUES (?, ?, ?, ?, ?, ?, 'tile1.png', '\'Assistant\', sans-serif')"
            );
            $stmt->bind_param("issssi", $user_id, $resume_title, $new_file_name, $ext, $slug, $updated_at);
            
            try {
                $stmt->execute();
                $stmt->close();
                $fn->setAlert('Resume successfully uploaded!');
                $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
            } catch (Exception $error) {
                $stmt->close();
                unlink($dest_path); // Remove uploaded file on DB error
                $fn->setError('Database error. Failed to save uploaded resume.');
                $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
            }
        } else {
            $fn->setError('Failed to move uploaded file.');
            $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
        }
    } else {
        $fn->setError('Please provide a title and select a valid file.');
        $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
    }
} else {
    $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
}
