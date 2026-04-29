<?php
    // Create Resume Page — form to build a new resume
    require_once __DIR__ . '/../../../app/bootstrap.php';
    $title = 'Create Resume | Resume Builder';
    require_once __DIR__ . '/../../../app/components/header.php';
    require_once __DIR__ . '/../../../app/components/navbar.php';
    $fn->authPage();
?>

    <div class="container">

        <div class="bg-white rounded shadow p-2 mt-4" style="min-height:80vh">
            <div class="d-flex justify-content-between border-bottom">
                <h5>Create Resume</h5>
                <div>
                    <a href="<?= BASE_URL ?>public/pages/internal/myresumes.php" class="text-decoration-none"><i class="bi bi-arrow-left-circle"></i> Back</a>
                </div>
            </div>

            <div>

                <form method="post" action="<?= BASE_URL ?>app/actions/resume/createresume.action.php" class="row g-3 p-3">
                    <h5 class="mt-3 text-secondary"><i class="bi bi-person-badge"></i> Personal Information</h5>
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" placeholder="Your Name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email_id" placeholder="name@example.com" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Resume Title</label>
                        <input type="text" name="resume_title" placeholder="Web Developer" value="resume<?=time()?>" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Objective</label>
                        <textarea class="form-control" name="objective" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mobile No</label>
                        <input type="number" name="mobile_no" min="1111111111" placeholder="Your Number" max="9999999999" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date Of Birth</label>
                        <input type="date" name="dob" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select class="form-select" name="gender">
                            <option>Male</option>
                            <option>Female</option>
                            <option>Transgender</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Religion</label>
                        <select class="form-select" name="religion">
                            <option>Hindu</option>
                            <option>Muslim</option>
                            <option>Sikh</option>
                            <option>Christian</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nationality</label>
                        <select class="form-select" name="nationality">
                            <option>Indian</option>
                            <option>Non Indian</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Marital Status</label>
                        <select class="form-select" name="marital_status">
                            <option>Married</option>
                            <option>Single</option>
                            <option>Divorced</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Hobbies</label>
                        <input type="text" name="hobbies" placeholder="Reading Books, Watching Movies" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Languages Known</label>
                        <input type="text" name="languages" placeholder="Hindi, English" class="form-control" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" placeholder="Your Address" required>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Add
                            Resume</button>
                    </div>
                </form>
            </div>

        </div>

    </div>

<?php
    require_once __DIR__ . '/../../../app/components/footer.php';
?>


