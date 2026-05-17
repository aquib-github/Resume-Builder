<?php
// Action: Send OTP verification code via email (PHPMailer)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once __DIR__ . '/../../bootstrap.php';
require __DIR__ . '/../../../vendor/phpmailer/src/Exception.php';
require __DIR__ . '/../../../vendor/phpmailer/src/PHPMailer.php';
require __DIR__ . '/../../../vendor/phpmailer/src/SMTP.php';

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
                $mail->isSMTP();
                $mail->Host       = $_ENV['MAIL_HOST']     ?? 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = $_ENV['MAIL_USERNAME'] ?? '';
                $mail->Password   = $_ENV['MAIL_PASSWORD'] ?? '';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = (int)($_ENV['MAIL_PORT'] ?? 465);

                $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'] ?? '', $_ENV['MAIL_FROM_NAME'] ?? 'Resume Builder');
                $mail->addAddress($email_id);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Forgot Password - Verification Code';
                $mail->Body    = 'Your 6 Digit Verification Code is <b>' . $otp . '</b>';

                $mail->send();

                $fn->setSession('otp', $otp);
                $fn->setSession('email', $email_id);
                $fn->setAlert('OTP sent successfully!');
                $fn->redirect(BASE_URL . 'public/pages/public/verification.php');
            } catch (Exception $e) {
                $fn->setError('Failed to send email. Please try again later.');
                $fn->redirect(BASE_URL . 'public/pages/public/forgot-password.php');
            }
        } else {
            $fn->setError('This email is not registered.');
            $fn->redirect(BASE_URL . 'public/pages/public/forgot-password.php');
        }
    } else {
        $fn->setError('Please enter your email!');
        $fn->redirect(BASE_URL . 'public/pages/public/forgot-password.php');
    }
} else {
    $fn->redirect(BASE_URL . 'public/pages/public/forgot-password.php');
}

