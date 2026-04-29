<?php
// Action: Update password after OTP verification
require_once __DIR__ . '/../../bootstrap.php';

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
        $fn->redirect(BASE_URL . 'public/pages/public/login.php');
    } else {
        $fn->setError('Please enter your new password!');
        $fn->redirect(BASE_URL . 'public/pages/internal/change-password.php');
    }
} else {
    $fn->redirect(BASE_URL . 'public/pages/internal/change-password.php');
}

