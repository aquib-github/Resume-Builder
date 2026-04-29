<?php
// Action: Verify OTP code for password reset
require_once __DIR__ . '/../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = trim($_POST['otp'] ?? '');

    if ($otp) {
        $stored_otp = $fn->getSession('otp');

        if ($stored_otp && $stored_otp == $otp) {
            // Clear OTP after successful verification to prevent reuse
            $fn->setSession('otp', '');
            $fn->setAlert('Email is verified!');
            $fn->redirect(BASE_URL . 'public/pages/internal/change-password.php');
        } else {
            $fn->setError('Incorrect OTP entered!');
            $fn->redirect(BASE_URL . 'public/pages/public/verification.php');
        }
    } else {
        $fn->setError('Please enter the 6-digit code sent to your email!');
        $fn->redirect(BASE_URL . 'public/pages/public/verification.php');
    }
} else {
    $fn->redirect(BASE_URL . 'public/pages/public/verification.php');
}

