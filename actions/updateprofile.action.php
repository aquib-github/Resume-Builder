<?php
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../classes/Functions.php';
$fn->authPage();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email_id  = trim($_POST['email_id'] ?? '');
    $password  = trim($_POST['password'] ?? '');
    $user_id   = $fn->Auth()['id'];

    if ($full_name && $email_id) {
        // Check if email is taken by another user
        $stmt = $db->prepare("SELECT COUNT(*) as user_count FROM users WHERE email_id = ? AND id != ?");
        $stmt->bind_param("si", $email_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($result['user_count'] > 0) {
            $fn->setError($fn->esc($email_id) . ' is already registered!');
            $fn->redirect('../account.php');
        }

        if ($password !== "") {
            $password_hash = md5($password);
            $stmt = $db->prepare("UPDATE users SET full_name = ?, email_id = ?, password = ? WHERE id = ?");
            $stmt->bind_param("sssi", $full_name, $email_id, $password_hash, $user_id);
        } else {
            $stmt = $db->prepare("UPDATE users SET full_name = ?, email_id = ? WHERE id = ?");
            $stmt->bind_param("ssi", $full_name, $email_id, $user_id);
        }

        $stmt->execute();
        $stmt->close();

        // Update session data
        $fn->setAuth(['id' => $user_id, 'full_name' => $full_name]);
        $fn->setAlert('Profile is updated!');
        $fn->redirect('../account.php');
    } else {
        $fn->setError('Please fill the form!');
        $fn->redirect('../account.php');
    }
} else {
    $fn->redirect('../account.php');
}
