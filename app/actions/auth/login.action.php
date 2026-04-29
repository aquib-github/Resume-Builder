<?php
// Action: Authenticate user with email and password
require_once __DIR__ . '/../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_id = trim($_POST['email_id'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email_id && $password) {
        $password_hash = md5($password);

        $stmt = $db->prepare("SELECT id, full_name FROM users WHERE email_id = ? AND password = ?");
        $stmt->bind_param("ss", $email_id, $password_hash);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($result) {
            session_regenerate_id(true);
            $fn->setAuth($result);
            $fn->setAlert('Logged in!');
            $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
        } else {
            $fn->setError('Incorrect email id or password');
            $fn->redirect(BASE_URL . 'public/pages/public/login.php');
        }
    } else {
        $fn->setError('Please fill the form!');
        $fn->redirect(BASE_URL . 'public/pages/public/login.php');
    }
} else {
    $fn->redirect(BASE_URL . 'public/pages/public/login.php');
}

