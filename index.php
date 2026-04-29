<?php
    $title = 'Home | Resume Builder';
    require './includes/header.php';
    
    // If the user is already logged in, redirect them to the dashboard
    if ($fn->Auth()) {
        $fn->redirect('myresumes.php');
    }
?>

<nav class="navbar bg-body-tertiary shadow mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="./assets/images/logo.png" alt="Logo" height="35" class="d-inline-block align-text-top">
            Resume Builder
        </a>
        <div>
            <a href="login.php" class="btn btn-sm btn-outline-primary me-2"><i class="bi bi-box-arrow-in-right"></i> Login</a>
            <a href="register.php" class="btn btn-sm btn-primary"><i class="bi bi-person-plus"></i> Register</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row align-items-center bg-white rounded shadow p-5">
        <div class="col-md-6">
            <h1 class="display-4 fw-bold">Build Your Professional Resume in Minutes</h1>
            <p class="lead text-secondary mt-3">Create, customize, and download beautiful resumes with our easy-to-use platform. Stand out from the crowd and land your dream job.</p>
            <div class="mt-4">
                <a href="register.php" class="btn btn-primary btn-lg px-4 me-2">Get Started for Free</a>
                <a href="login.php" class="btn btn-outline-secondary btn-lg px-4">Login</a>
            </div>
        </div>
        <div class="col-md-6 text-center mt-4 mt-md-0">
            <i class="bi bi-file-earmark-person" style="font-size: 15rem; color: #0d6efd;"></i>
        </div>
    </div>

    <div class="row mt-5 mb-5 g-4">
        <div class="col-md-4">
            <div class="bg-white rounded shadow p-4 text-center h-100">
                <i class="bi bi-magic fs-1 text-primary"></i>
                <h4 class="mt-3">Easy Customization</h4>
                <p class="text-secondary">Choose from multiple fonts and background patterns to make your resume uniquely yours.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-white rounded shadow p-4 text-center h-100">
                <i class="bi bi-filetype-pdf fs-1 text-danger"></i>
                <h4 class="mt-3">PDF Export</h4>
                <p class="text-secondary">Download your resume as a high-quality PDF ready to be emailed or printed directly.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-white rounded shadow p-4 text-center h-100">
                <i class="bi bi-share fs-1 text-success"></i>
                <h4 class="mt-3">Quick Sharing</h4>
                <p class="text-secondary">Share your resume instantly via WhatsApp or direct link with potential employers.</p>
            </div>
        </div>
    </div>
</div>

<?php
    require './includes/footer.php';
?>
