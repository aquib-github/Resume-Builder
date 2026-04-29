<?php
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../classes/Functions.php';
$fn->authPage();

$slug    = trim($_GET['resume'] ?? '');
$user_id = $fn->Auth()['id'];

if (!$slug) {
    $fn->redirect('../myresumes.php');
}

// Fetch original resume
$stmt = $db->prepare("SELECT * FROM resumes WHERE slug = ? AND user_id = ?");
$stmt->bind_param("si", $slug, $user_id);
$stmt->execute();
$resume = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$resume) {
    $fn->setError('Resume not found.');
    $fn->redirect('../myresumes.php');
}

$resume_id = $resume['id'];

// Fetch related data
$stmt = $db->prepare("SELECT * FROM experiences WHERE resume_id = ?");
$stmt->bind_param("i", $resume_id);
$stmt->execute();
$exps = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$stmt = $db->prepare("SELECT * FROM educations WHERE resume_id = ?");
$stmt->bind_param("i", $resume_id);
$stmt->execute();
$edus = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$stmt = $db->prepare("SELECT * FROM skills WHERE resume_id = ?");
$stmt->bind_param("i", $resume_id);
$stmt->execute();
$skills = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Create cloned resume
$new_slug       = $fn->randomString();
$new_title      = 'Clone_' . time();
$new_updated_at = time();

$stmt = $db->prepare(
    "INSERT INTO resumes (user_id, full_name, email_id, resume_title, mobile_no, dob, gender, religion, nationality, marital_status, hobbies, languages, address, objective, slug, updated_at, background, font)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param(
    "issssssssssssssis",
    $user_id, $resume['full_name'], $resume['email_id'], $new_title,
    $resume['mobile_no'], $resume['dob'], $resume['gender'], $resume['religion'],
    $resume['nationality'], $resume['marital_status'], $resume['hobbies'],
    $resume['languages'], $resume['address'], $resume['objective'],
    $new_slug, $new_updated_at, $resume['background'], $resume['font']
);

try {
    $stmt->execute();
    $new_resume_id = $db->insert_id;
    $stmt->close();

    // Clone experiences
    $stmt_exp = $db->prepare("INSERT INTO experiences (resume_id, position, company, job_desc, started, ended) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($exps as $exp) {
        $stmt_exp->bind_param("isssss", $new_resume_id, $exp['position'], $exp['company'], $exp['job_desc'], $exp['started'], $exp['ended']);
        $stmt_exp->execute();
    }
    $stmt_exp->close();

    // Clone educations
    $stmt_edu = $db->prepare("INSERT INTO educations (resume_id, course, institute, started, ended) VALUES (?, ?, ?, ?, ?)");
    foreach ($edus as $edu) {
        $stmt_edu->bind_param("issss", $new_resume_id, $edu['course'], $edu['institute'], $edu['started'], $edu['ended']);
        $stmt_edu->execute();
    }
    $stmt_edu->close();

    // Clone skills
    $stmt_skill = $db->prepare("INSERT INTO skills (resume_id, skill) VALUES (?, ?)");
    foreach ($skills as $skill) {
        $stmt_skill->bind_param("is", $new_resume_id, $skill['skill']);
        $stmt_skill->execute();
    }
    $stmt_skill->close();

    $fn->setAlert('Clone successfully created!');
    $fn->redirect('../myresumes.php');
} catch (Exception $error) {
    $fn->setError('Failed to clone resume. Please try again.');
    $fn->redirect('../myresumes.php');
}