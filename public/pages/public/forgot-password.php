<?php
    // Forgot Password Page — sends OTP code to user's email
    require_once __DIR__ . '/../../../app/bootstrap.php';
    $title = 'Forgot Password | Resume Builder';
    require_once __DIR__ . '/../../../app/components/header.php';
    $fn->nonAuthPage();
?>

<div class="d-flex align-items-center" style="height:100vh">
    <div class="w-100">
        <main class="form-signin w-100 m-auto bg-white shadow rounded">
            <form method="post" action="<?= BASE_URL ?>app/actions/auth/sendcode.action.php">
                <div class="d-flex gap-2 justify-content-center">
                    <img class="mb-4" src="<?= BASE_URL ?>public/assets/images/logo.png" alt="Logo" height="70">
                    <div>
                        <h1 class="h3 fw-normal my-1"><b>Resume</b> Builder</h1>
                        <p class="m-0">Forgot your password</p>
                    </div>
                </div>
                <div class="form-floating mb-4">
                    <input type="email" class="form-control" name="email_id" id="floatingEmail" placeholder="name@example.com" required>
                    <label for="floatingEmail"><i class="bi bi-envelope"></i> Email address</label>
                </div>
                <button class="btn btn-primary w-100 py-2" type="submit"><i class="bi bi-send"></i> Send Verification
                    Code
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



