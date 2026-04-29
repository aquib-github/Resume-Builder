<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/../config/database.php';
require __DIR__ . '/../classes/Functions.php';
require __DIR__ . '/../vendor/phpmailer/src/Exception.php';
require __DIR__ . '/../vendor/phpmailer/src/PHPMailer.php';
require __DIR__ . '/../vendor/phpmailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_id = trim($_POST['email_id'] ?? '');

    if ($email_id) {
        $stmt = $db->prepare("SELECT id, full_name FROM users WHERE email_id = ?");
        $stmt->bind_param("s", $email_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($result) {
            $otp  = rand(100000, 999999);
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'aquib.vcetclg@gmail.com';         // TODO: Move to config file
                $mail->Password   = 'uvsgbakwbppnwpim';               // TODO: Move to config file
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;

                // Recipients
                $mail->setFrom('aquib.vcetclg@gmail.com', 'Resume Builder');
                $mail->addAddress($email_id);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Forgot Password - Verification Code';
                $mail->Body    = 'Your 6 Digit Verification Code is <b>' . $otp . '</b>';

                $mail->send();

                $fn->setSession('otp', $otp);
                $fn->setSession('email', $email_id);
                $fn->setAlert('OTP sent successfully!');
                $fn->redirect('../verification.php');
            } catch (Exception $e) {
                $fn->setError('Failed to send email. Please try again later.');
                $fn->redirect('../forgot-password.php');
            }
        } else {
            $fn->setError('This email is not registered.');
            $fn->redirect('../forgot-password.php');
        }
    } else {
        $fn->setError('Please enter your email!');
        $fn->redirect('../forgot-password.php');
    }
} else {
    $fn->redirect('../forgot-password.php');
}
