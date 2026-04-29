<?php
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../classes/Functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email_id  = trim($_POST['email_id'] ?? '');
    $password  = trim($_POST['password'] ?? '');

    if ($full_name && $email_id && $password) {
        // Check if email already exists
        $stmt = $db->prepare("SELECT COUNT(*) as user_count FROM users WHERE email_id = ?");
        $stmt->bind_param("s", $email_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($result['user_count'] > 0) {
            $fn->setError($fn->esc($email_id) . ' is already registered!');
            $fn->redirect('../login.php');
        }

        $password_hash = md5($password);

        $stmt = $db->prepare("INSERT INTO users (full_name, email_id, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $full_name, $email_id, $password_hash);

        try {
            $stmt->execute();
            $stmt->close();
            $fn->setAlert('You registered successfully!');
            $fn->redirect('../login.php');
        } catch (Exception $error) {
            $stmt->close();
            $fn->setError('Registration failed. Please try again.');
            $fn->redirect('../register.php');
        }
    } else {
        $fn->setError('Please fill the form!');
        $fn->redirect('../register.php');
    }
} else {
    $fn->redirect('../register.php');
}
