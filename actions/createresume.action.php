<?php
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../classes/Functions.php';
$fn->authPage();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    if ($full_name && $email_id && $resume_title && $objective && $mobile_no && $dob && $gender && $religion && $nationality && $marital_status && $hobbies && $languages && $address) {
        $user_id    = $fn->Auth()['id'];
        $slug       = $fn->randomString();
        $updated_at = time();

        $stmt = $db->prepare(
            "INSERT INTO resumes (full_name, email_id, resume_title, objective, mobile_no, dob, gender, religion, nationality, marital_status, hobbies, languages, address, user_id, slug, updated_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "sssssssssssssis",
            $full_name, $email_id, $resume_title, $objective, $mobile_no,
            $dob, $gender, $religion, $nationality, $marital_status,
            $hobbies, $languages, $address, $user_id, $slug, $updated_at
        );

        try {
            $stmt->execute();
            $stmt->close();
            $fn->setAlert('Resume successfully added!');
            $fn->redirect('../myresumes.php');
        } catch (Exception $error) {
            $stmt->close();
            $fn->setError('Failed to create resume. Please try again.');
            $fn->redirect('../createresume.php');
        }
    } else {
        $fn->setError('Please fill the form!');
        $fn->redirect('../createresume.php');
    }
} else {
    $fn->redirect('../createresume.php');
}