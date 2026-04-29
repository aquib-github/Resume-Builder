<?php
    // Login Page — authenticates users via email and password
    require_once __DIR__ . '/../../../app/bootstrap.php';
    $title = 'Login | Resume Builder';
    require_once __DIR__ . '/../../../app/components/header.php';
    $fn->nonAuthPage();
?>

<div class="d-flex align-items-center" style="height:100vh">
    <div class="w-100">
        <main class="form-signin w-100 m-auto bg-white shadow rounded">
            <form method="post" action="<?= BASE_URL ?>app/actions/auth/login.action.php">
                <div class="d-flex gap-2 justify-content-center">
                    <img class="mb-4" src="<?= BASE_URL ?>public/assets/images/logo.png" alt="Logo" height="70">
                    <div>
                        <h1 class="h3 fw-normal my-1"><b>Resume</b> Builder</h1>
                        <p class="m-0">Login to your account</p>
                    </div>
                </div>
                <div class="form-floating">
                    <input type="email" class="form-control" name="email_id" id="floatingEmail" placeholder="name@example.com" required>
                    <label for="floatingEmail"><i class="bi bi-envelope"></i> Email address</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password" required>
                    <label for="floatingPassword"><i class="bi bi-key"></i> Password</label>
                </div>
                <button class="btn btn-primary w-100 py-2" type="submit">Login
                    <i class="bi bi-box-arrow-in-right"></i>
                </button>
                <div class="d-flex justify-content-between my-3">
                    <a href="<?= BASE_URL ?>public/pages/public/forgot-password.php" class="text-decoration-none">Forgot Password ?</a>
                    <a href="<?= BASE_URL ?>public/pages/public/register.php" class="text-decoration-none">Register</a>
                </div>
            </form>
        </main>
    </div>
</div>

<?php
    require_once __DIR__ . '/../../../app/components/footer.php';
?>



