<?php
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../classes/Functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = trim($_POST['password'] ?? '');
    $email    = $fn->getSession('email');

    if ($password && $email) {
        $password_hash = md5($password);

        $stmt = $db->prepare("UPDATE users SET password = ? WHERE email_id = ?");
        $stmt->bind_param("ss", $password_hash, $email);
        $stmt->execute();
        $stmt->close();

        // Clear session data
        $fn->setSession('email', '');
        $fn->setSession('otp', '');

        $fn->setAlert('Password is changed!');
        $fn->redirect('../login.php');
    } else {
        $fn->setError('Please enter your new password!');
        $fn->redirect('../change-password.php');
    }
} else {
    $fn->redirect('../change-password.php');
}
