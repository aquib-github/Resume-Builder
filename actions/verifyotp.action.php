<?php
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../classes/Functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = trim($_POST['otp'] ?? '');

    if ($otp) {
        $stored_otp = $fn->getSession('otp');

        if ($stored_otp && $stored_otp == $otp) {
            // Clear OTP after successful verification to prevent reuse
            $fn->setSession('otp', '');
            $fn->setAlert('Email is verified!');
            $fn->redirect('../change-password.php');
        } else {
            $fn->setError('Incorrect OTP entered!');
            $fn->redirect('../verification.php');
        }
    } else {
        $fn->setError('Please enter the 6-digit code sent to your email!');
        $fn->redirect('../verification.php');
    }
} else {
    $fn->redirect('../verification.php');
}
