<!-- Navbar Component — top navigation for authenticated pages -->
<nav class="navbar bg-body-tertiary shadow">
    <div class="container">
        <a class="navbar-brand" href="<?= BASE_URL ?>public/pages/internal/myresumes.php">
            <img src="<?= BASE_URL ?>public/assets/images/logo.png" alt="Logo" height="35" class="d-inline-block align-text-top">
            Resume Builder
        </a>
        <div>
            <a href="<?= BASE_URL ?>public/pages/internal/account.php" class="btn btn-sm btn-dark"><i class="bi bi-person-circle"></i> Account</a>
            <a href="<?= BASE_URL ?>app/actions/auth/logout.action.php" class="btn btn-sm btn-danger"><i class="bi bi-box-arrow-left"></i></a>
        </div>
    </div>
</nav>
