<?php
    // Update Resume Page — edit resume details, experience, education, and skills
    require_once __DIR__ . '/../../../app/bootstrap.php';
    $title = 'Update Resume | Resume Builder';
    require_once __DIR__ . '/../../../app/components/header.php';
    require_once __DIR__ . '/../../../app/components/navbar.php';
    $fn->authPage();

    $slug = trim($_GET['resume'] ?? '');
    $user_id = $fn->Auth()['id'];

    if (!$slug) {
        $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
    }

    $stmt = $db->prepare("SELECT * FROM resumes WHERE slug = ? AND user_id = ?");
    $stmt->bind_param("si", $slug, $user_id);
    $stmt->execute();
    $resume = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$resume) {
        $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
    }

    $resume_id = $resume['id'];

    $stmt = $db->prepare("SELECT * FROM experiences WHERE resume_id = ?");
    $stmt->bind_param("i", $resume_id);
    $stmt->execute();
    $exps = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $stmt = $db->prepare("SELECT * FROM educations WHERE resume_id = ?");
    $stmt->bind_param("i", $resume_id);
    $stmt->execute();
    $edus = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $stmt = $db->prepare("SELECT * FROM skills WHERE resume_id = ?");
    $stmt->bind_param("i", $resume_id);
    $stmt->execute();
    $skills = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
?>

    <div class="container">

        <div class="bg-white rounded shadow p-2 mt-4" style="min-height:80vh">
            <div class="d-flex justify-content-between border-bottom">
                <h5>Update Resume</h5>
                <div>
                    <a href="<?= BASE_URL ?>public/pages/internal/myresumes.php" class="text-decoration-none"><i class="bi bi-arrow-left-circle"></i> Back</a>
                </div>
            </div>

            <div>

                <form method="post" action="<?= BASE_URL ?>app/actions/resume/updateresume.action.php" class="row g-3 p-3">
                <input type="hidden" name="id" value="<?=intval($resume['id'])?>" />
                <input type="hidden" name="slug" value="<?=$fn->esc($resume['slug'])?>" />
                    <h5 class="mt-3 text-secondary"><i class="bi bi-person-badge"></i> Personal Information</h5>
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" placeholder="Your Name" value="<?=$fn->esc($resume['full_name'])?>" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email_id" placeholder="name@example.com" value="<?=$fn->esc($resume['email_id'])?>" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Resume Title</label>
                        <input type="text" name="resume_title" placeholder="Web Developer" value="<?=$fn->esc($resume['resume_title'])?>" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputAddress" class="form-label"> Objective</label>
                        <textarea class="form-control" name="objective" required><?=$fn->esc($resume['objective'])?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mobile No</label>
                        <input type="number" name="mobile_no" min="1111111111" placeholder="Your Number" value="<?=$fn->esc($resume['mobile_no'])?>" max="9999999999" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date Of Birth</label>
                        <input type="date" name="dob" value="<?=$fn->esc($resume['dob'])?>" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select class="form-select" name="gender">
                            <option <?=($resume['gender']=='Male')?'selected':''?>>Male</option>
                            <option <?=($resume['gender']=='Female')?'selected':''?>>Female</option>
                            <option <?=($resume['gender']=='Transgender')?'selected':''?>>Transgender</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Religion</label>
                        <select class="form-select" name="religion">
                            <option <?=($resume['religion']=='Hindu')?'selected':''?>>Hindu</option>
                            <option <?=($resume['religion']=='Muslim')?'selected':''?>>Muslim</option>
                            <option <?=($resume['religion']=='Sikh')?'selected':''?>>Sikh</option>
                            <option <?=($resume['religion']=='Christian')?'selected':''?>>Christian</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nationality</label>
                        <select class="form-select" name="nationality">
                            <option <?=($resume['nationality']=='Indian')?'selected':''?>>Indian</option>
                            <option <?=($resume['nationality']=='Non Indian')?'selected':''?>>Non Indian</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Marital Status</label>
                        <select class="form-select" name="marital_status">
                            <option <?=($resume['marital_status']=='Married')?'selected':''?>>Married</option>
                            <option <?=($resume['marital_status']=='Single')?'selected':''?>>Single</option>
                            <option <?=($resume['marital_status']=='Divorced')?'selected':''?>>Divorced</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Hobbies</label>
                        <input type="text" name="hobbies" placeholder="Reading Books, Watching Movies" value="<?=$fn->esc($resume['hobbies'])?>" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Languages Known</label>
                        <input type="text" name="languages" placeholder="Hindi,English" value="<?=$fn->esc($resume['languages'])?>" class="form-control" required>
                    </div>

                    <div class="col-12">
                        <label for="inputAddress" class="form-label"> Address</label>
                        <input type="text" class="form-control" name="address" id="inputAddress" placeholder="Your Address" value="<?=$fn->esc($resume['address'])?>" required>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <h5 class=" text-secondary"><i class="bi bi-briefcase"></i> Experience</h5>
                        <div>
                            <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#addexp"><i class="bi bi-file-earmark-plus"></i> Add New</a>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap">

                    <?php
                    if ($exps) {
                        foreach ($exps as $exp) {
                            ?>
                            <div class="col-12 col-md-6 p-2">
                            <div class="p-2 border rounded">
                                <div class="d-flex justify-content-between">
                                    <h6><?=$fn->esc($exp['position'])?></h6>
                                    <a href="<?= BASE_URL ?>app/actions/resume/deleteexperience.action.php?id=<?=intval($exp['id'])?>&resume_id=<?=intval($resume['id'])?>&slug=<?=urlencode($resume['slug'])?>" onclick="return confirm('Delete this experience?')"><i class="bi bi-x-lg"></i></a>
                                </div>

                                <p class="small text-secondary m-0">
                                    <i class="bi bi-buildings"></i> <?=$fn->esc($exp['company'])?> (<?=$fn->esc($exp['started'] . '-' . $exp['ended'])?>)
                                </p>
                                <p class="small text-secondary m-0">
                                    <?=$fn->esc($exp['job_desc'])?>
                                </p>

                            </div>
                        </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="col-12 col-md-6 p-2">
                            <div class="p-2 border rounded">
                                <div class="d-flex justify-content-between">
                                    <h6>I am a Fresher</h6>
                                </div>
                                <p class="small text-secondary m-0">
                                    If you have experience you can add it
                                </p>

                            </div>
                        </div>
                        <?php
                    }
                    ?>



                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <h5 class=" text-secondary"><i class="bi bi-journal-bookmark"></i> Education</h5>
                        <div>
                            <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#addedu"><i class="bi bi-file-earmark-plus"></i> Add New</a>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap">

                    <?php
                    if ($edus) {
                        foreach ($edus as $edu) {
                            ?>
                            <div class="col-12 col-md-6 p-2">
                            <div class="p-2 border rounded">
                                <div class="d-flex justify-content-between">
                                    <h6><?=$fn->esc($edu['course'])?></h6>
                                    <a href="<?= BASE_URL ?>app/actions/resume/deleteeducation.action.php?id=<?=intval($edu['id'])?>&resume_id=<?=intval($resume['id'])?>&slug=<?=urlencode($resume['slug'])?>" onclick="return confirm('Delete this education?')"><i class="bi bi-x-lg"></i></a>
                                </div>

                                <p class="small text-secondary m-0">
                                    <i class="bi bi-book"></i> <?=$fn->esc($edu['institute'])?>
                                </p>
                                <p class="small text-secondary m-0">
                                    <?=$fn->esc($edu['started'] . '-' . $edu['ended'])?>
                                </p>

                            </div>
                        </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="col-12 col-md-6 p-2">
                            <div class="p-2 border rounded">
                                <div class="d-flex justify-content-between">
                                    <h6>I have no education</h6>
                                </div>
                                <p class="small text-secondary m-0">
                                    If you have education you can add it
                                </p>

                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    </div>

                    <hr>
                    <div class="d-flex justify-content-between">
                        <h5 class=" text-secondary"><i class="bi bi-boxes"></i> Skills</h5>
                        <div>
                            <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#addskill"><i class="bi bi-file-earmark-plus"></i> Add New</a>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap">

                    <?php
                    if ($skills) {
                        foreach ($skills as $skill) {
                            ?>
                            <div class="col-12 col-md-6 p-2">
                            <div class="p-2 border rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6><i class="bi bi-caret-right"></i> <?=$fn->esc($skill['skill'])?></h6>
                                    <a href="<?= BASE_URL ?>app/actions/resume/deleteskill.action.php?id=<?=intval($skill['id'])?>&resume_id=<?=intval($resume['id'])?>&slug=<?=urlencode($resume['slug'])?>" onclick="return confirm('Delete this skill?')"><i class="bi bi-x-lg"></i></a>
                                </div>
                            </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="col-12 col-md-6 p-2">
                            <div class="p-2 border rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6><i class="bi bi-caret-right"></i> I have no skill</h6>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>


                    </div>



                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Update
                            Resume</button>
                    </div>
                </form>
            </div>




        </div>

    </div>
<!--Modal exp -->
<div class="modal fade" id="addexp" tabindex="-1" aria-labelledby="addExpLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addExpLabel">Add Experience</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="post" action="<?= BASE_URL ?>app/actions/resume/addexperience.action.php" class="row g-3">
        <input type="hidden" name="resume_id" value="<?=intval($resume['id'])?>" />
        <input type="hidden" name="slug" value="<?=$fn->esc($resume['slug'])?>" />
        <div class="col-12">
    <label class="form-label">Position / Job Role</label>
    <input type="text" class="form-control" name="position" placeholder="Web Developer Consultant (2+ Years)" required>
  </div>
  <div class="col-12">
    <label class="form-label">Company</label>
    <input type="text" name="company" placeholder="Dominos, New Delhi" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Joined</label>
    <input type="text" name="started" placeholder="October 2021" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Resigned</label>
    <input type="text" name="ended" placeholder="Currently Pursuing" class="form-control" required>
  </div>
  <div class="col-12">
  <label class="form-label">Job Description</label>
        <textarea class="form-control" name="job_desc" required></textarea>
    </div>
  <div class="col-12 text-end">
    <button type="submit" class="btn btn-primary">Add Experience</button>
  </div>
</form>
      </div>

    </div>
  </div>
</div>
 <!--Modal exp-->

<!--Modal edu-->
<div class="modal fade" id="addedu" tabindex="-1" aria-labelledby="addEduLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addEduLabel">Add Education</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="post" action="<?= BASE_URL ?>app/actions/resume/addeducation.action.php" class="row g-3">
      <input type="hidden" name="resume_id" value="<?=intval($resume['id'])?>" />
      <input type="hidden" name="slug" value="<?=$fn->esc($resume['slug'])?>" />
  <div class="col-12">
    <label class="form-label">Course / Degree</label>
    <input type="text" class="form-control" name="course" placeholder="Completed 12th Class (Arts Stream)" required>
  </div>
  <div class="col-12">
    <label class="form-label">Institute / Board</label>
    <input type="text" name="institute" placeholder="Central Board Of Secondary Education, New Delhi" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Started</label>
    <input type="text" name="started" placeholder="October 2021" class="form-control" required>
  </div>
  <div class="col-md-6">
    <label class="form-label">Ended</label>
    <input type="text" name="ended" placeholder="Currently Pursuing" class="form-control" required>
  </div>
  <div class="col-12 text-end">
    <button type="submit" class="btn btn-primary">Add Education</button>
  </div>
</form>
      </div>

    </div>
  </div>
</div>
 <!--Modal edu-->

 <!--Modal skill-->
<div class="modal fade" id="addskill" tabindex="-1" aria-labelledby="addSkillLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addSkillLabel">Add Skills</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="post" action="<?= BASE_URL ?>app/actions/resume/addskills.action.php" class="row g-3">
      <input type="hidden" name="resume_id" value="<?=intval($resume['id'])?>" />
      <input type="hidden" name="slug" value="<?=$fn->esc($resume['slug'])?>" />
  <div class="col-12">
    <label class="form-label">Skill</label>
    <input type="text" class="form-control" name="skill" placeholder="Basic Knowledge in Computer & Internet" required>
  </div>
  <div class="col-12 text-end">
    <button type="submit" class="btn btn-primary">Add Skill</button>
  </div>
</form>
      </div>

    </div>
  </div>
</div>
 <!--Modal skill-->
 <?php
    require_once __DIR__ . '/../../../app/components/footer.php';
?>


