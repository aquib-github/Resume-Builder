<?php
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../classes/Functions.php';
$fn->authPage();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id             = intval($_POST['id'] ?? 0);
    $slug           = trim($_POST['slug'] ?? '');
    $full_name      = trim($_POST['full_name'] ?? '');
    $email_id       = trim($_POST['email_id'] ?? '');
    $resume_title   = trim($_POST['resume_title'] ?? '');
    $objective      = trim($_POST['objective'] ?? '');
    $mobile_no      = trim($_POST['mobile_no'] ?? '');
    $dob            = trim($_POST['dob'] ?? '');
    $gender         = trim($_POST['gender'] ?? '');
    $religion       = trim($_POST['religion'] ?? '');
    $nationality    = trim($_POST['nationality'] ?? '');
    $marital_status = trim($_POST['marital_status'] ?? '');
    $hobbies        = trim($_POST['hobbies'] ?? '');
    $languages      = trim($_POST['languages'] ?? '');
    $address        = trim($_POST['address'] ?? '');

    if ($id && $slug && $full_name && $email_id && $resume_title && $objective && $mobile_no && $dob && $gender && $religion && $nationality && $marital_status && $hobbies && $languages && $address) {
        $updated_at = time();
        $user_id    = $fn->Auth()['id'];

        $stmt = $db->prepare(
            "UPDATE resumes SET full_name=?, email_id=?, resume_title=?, objective=?, mobile_no=?, dob=?, gender=?, religion=?, nationality=?, marital_status=?, hobbies=?, languages=?, address=?, updated_at=?
             WHERE id=? AND slug=? AND user_id=?"
        );
        $stmt->bind_param(
            "sssssssssssssisis",
            $full_name, $email_id, $resume_title, $objective, $mobile_no,
            $dob, $gender, $religion, $nationality, $marital_status,
            $hobbies, $languages, $address, $updated_at,
            $id, $slug, $user_id
        );

        try {
            $stmt->execute();
            $stmt->close();
            $fn->setAlert('Resume successfully updated!');
            $fn->redirect('../updateresume.php?resume=' . urlencode($slug));
        } catch (Exception $error) {
            $stmt->close();
            $fn->setError('Failed to update resume. Please try again.');
            $fn->redirect('../updateresume.php?resume=' . urlencode($slug));
        }
    } else {
        $fn->setError('Please fill the form!');
        $fn->redirect('../updateresume.php?resume=' . urlencode($slug));
    }
} else {
    $fn->redirect('../myresumes.php');
}