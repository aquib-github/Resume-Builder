<?php
    $title = 'My Resumes | Resume Builder';
    require './includes/header.php';
    require './includes/navbar.php';
    $fn->authPage();

    $user_id = $fn->Auth()['id'];
    $stmt = $db->prepare("SELECT * FROM resumes WHERE user_id = ? ORDER BY id DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $resumes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
?>

    <div class="container">
        <div class="bg-white rounded shadow p-2 mt-4" style="min-height:80vh">
            <div class="d-flex justify-content-between border-bottom">
                <h5>Resumes</h5>
                <div>
                    <a href="createresume.php" class="text-decoration-none"><i class="bi bi-file-earmark-plus"></i> Add New</a>
                </div>
            </div>
            <?php if ($resumes) { ?>
            <div class="d-flex flex-wrap">
            <?php foreach ($resumes as $resume) { ?>
                <div class="col-12 col-md-6 p-2">
                    <div class="p-2 border rounded">
                        <h5><?=$fn->esc($resume['resume_title'])?></h5>
                        <p class="small text-secondary m-0" style="font-size:16px"><i class="bi bi-clock-history"></i>
                            Last Updated <?=date('d M, y h:i A', $resume['updated_at'])?>
                        </p>
                        <div class="d-flex gap-2 mt-1">
                            <a href="resume.php?resume=<?=urlencode($resume['slug'])?>" target="_blank" class="text-decoration-none small"><i class="bi bi-file-text"></i> Open</a>
                            <a href="updateresume.php?resume=<?=urlencode($resume['slug'])?>" class="text-decoration-none small"><i class="bi bi-pencil-square"></i> Edit</a>
                            <a href="actions/deleteresume.action.php?id=<?=intval($resume['id'])?>" class="text-decoration-none small" onclick="return confirm('Are you sure you want to delete this resume?')"><i class="bi bi-trash2"></i> Delete</a>
                            <a href="actions/clonecv.action.php?resume=<?=urlencode($resume['slug'])?>" class="text-decoration-none small"><i class="bi bi-copy"></i> Clone</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
            </div>
            <?php } else { ?>
                <div class="text-center py-3 border rounded mt-3" style="background-color: rgba(236, 236, 236, 0.56);">
                <i class="bi bi-file-text"></i> No Resumes Available
                </div>
            <?php } ?>
        </div>
    </div>

<?php
    require './includes/footer.php';
?>
