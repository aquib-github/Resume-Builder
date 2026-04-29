<?php
    // Verification Page — verifies OTP code for password reset
    require_once __DIR__ . '/../../../app/bootstrap.php';
    $title = 'Verification | Resume Builder';
    require_once __DIR__ . '/../../../app/components/header.php';
    $fn->nonAuthPage();

    $email = $fn->getSession('email');
    if ($email === '') {
        $fn->redirect(BASE_URL . 'public/pages/public/forgot-password.php');
    }
?>

<style>
    .form-signin {
        max-width: 550px;
        padding: 1rem;
    }
</style>
<div class="d-flex align-items-center p-3" style="height:100vh">
    <div class="w-100">
        <main class="form-signin w-100 m-auto bg-white shadow rounded">
            <form method="post" action="<?= BASE_URL ?>app/actions/auth/verifyotp.action.php">
                <div class="d-flex gap-2 justify-content-center">
                    <img class="mb-4" src="<?= BASE_URL ?>public/assets/images/logo.png" alt="Logo" height="70">
                    <div>
                        <h1 class="h3 fw-normal my-1"><b>Resume</b> Builder</h1>
                        <p class="m-0">Verify your email</p>
                    </div>
                </div>
                <div class="mb-3">A 6-digit code was sent to
                    <span class="mb-3 fw-bold"><?=$fn->esc($email)?></span>
                </div>
                <div class="form-floating mb-4">
                    <input type="number" class="form-control" name="otp" id="floatingOtp" placeholder="Enter Code" required>
                    <label for="floatingOtp"><i class="bi bi-patch-check"></i> Enter 6 Digit Code</label>
                </div>
                <button class="btn btn-primary w-100 py-2" type="submit"><i class="bi bi-envelope-check-fill"></i>
                    Verify Email
                </button>
                <div class="d-flex justify-content-between my-3">
                    <a href="<?= BASE_URL ?>public/pages/public/register.php" class="text-decoration-none">Register</a>
                    <a href="<?= BASE_URL ?>public/pages/public/login.php" class="text-decoration-none">Login</a>
                </div>
            </form>
        </main>
    </div>
</div>

<?php
    require_once __DIR__ . '/../../../app/components/footer.php';
?>



