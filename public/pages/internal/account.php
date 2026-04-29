<?php
    // Account Page — update profile name, email, and password
    require_once __DIR__ . '/../../../app/bootstrap.php';
    $title = 'Account | Resume Builder';
    require_once __DIR__ . '/../../../app/components/header.php';
    require_once __DIR__ . '/../../../app/components/navbar.php';
    $fn->authPage();

    $user_id = $fn->Auth()['id'];
    $stmt = $db->prepare("SELECT full_name, email_id FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();
?>

    <div class="container">
        <div class="bg-white rounded shadow p-2 mt-4">
            <div class="d-flex justify-content-between border-bottom">
                <h5>Edit Account</h5>
                <div>
                    <a href="<?= BASE_URL ?>public/pages/internal/myresumes.php" class="text-decoration-none"><i class="bi bi-arrow-left-circle"></i> Back</a>
                </div>
            </div>
            <div>
                <form method="post" action="<?= BASE_URL ?>app/actions/auth/updateprofile.action.php" class="row g-3 p-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" placeholder="Your Name" value="<?=$fn->esc($user['full_name'] ?? '')?>" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email_id" placeholder="name@example.com" value="<?=$fn->esc($user['email_id'] ?? '')?>" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" placeholder="Leave blank to keep current" class="form-control">
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Update
                            Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
    require_once __DIR__ . '/../../../app/components/footer.php';
?>


