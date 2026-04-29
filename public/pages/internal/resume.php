<?php
    // Resume Preview Page — displays, prints, and exports resume as PDF
    require_once __DIR__ . '/../../../app/bootstrap.php';

    $slug = trim($_GET['resume'] ?? '');
    if (!$slug) {
        $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
    }

    $stmt = $db->prepare("SELECT * FROM resumes WHERE slug = ?");
    $stmt->bind_param("s", $slug);
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Agdasima:wght@400;700&family=Bebas+Neue&family=Bodoni+Moda+SC:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&family=Dancing+Script:wght@400..700&family=Edu+AU+VIC+WA+NT+Hand:wght@400..700&family=Pacifico&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Ruge+Boogie&family=Assistant:wght@200..800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="icon" href="<?= BASE_URL ?>public/assets/images/logo.png">
    <title><?=$fn->esc($resume['full_name'] . ' | ' . $resume['resume_title'])?></title>
</head>

<body>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font-family: 'Poppins', sans-serif;
            font-size: 12pt;

            background: rgb(249, 249, 249);
            background: radial-gradient(circle, rgba(249, 249, 249, 1) 0%, rgba(240, 232, 127, 1) 49%, rgba(246, 243, 132, 1) 100%);
            background-image: url(<?= BASE_URL ?>public/assets/images/tiles/<?=$fn->esc($resume['background'])?>);
            background-attachment: fixed;
        }

        * {
            margin: 0px;
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {

            width: 21cm;
            min-height: 29.7cm;
            padding: 0.5cm;
            margin: 0.5cm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .subpage {


            /* height: 256mm; */


        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }

        * {
            transition: all .2s;
        }

        table {
            border-collapse: collapse;
        }

        .pr {
            padding-right: 30px;
        }

        .pd-table td {
            padding-right: 10px;
            padding-bottom: 3px;
            padding-top: 3px;
        }
    </style>

<?php
if ($fn->Auth() != false && $fn->Auth()['id'] == $resume['user_id']) {
    ?>
        <div class="extra">
    <div class="w-100 py-2 bg-dark d-flex justify-content-center gap-3">
    <?php
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    ?>
    <a href="https://wa.me/?text=<?=urlencode($actual_link)?>" target="_blank" class="btn btn-light btn-sm"><i class="bi bi-whatsapp"></i> Share</a>
    <button class="btn btn-light btn-sm" id="print"><i class="bi bi-printer"></i> Print</button>
    <button class="btn btn-light btn-sm" data-bs-toggle="offcanvas" data-bs-target="#background"><i class="bi bi-backpack4-fill"></i> Background</button>
    <button class="btn btn-light btn-sm" data-bs-toggle="offcanvas" data-bs-target="#fontpanel"><i class="bi bi-file-earmark-font"></i> Font</button>
    <button class="btn btn-light btn-sm" id="downloadpdf"><i class="bi bi-file-earmark-pdf"></i> Download</button>
    </div>
</div>

    <?php
}
?>

<div class="page" style="font-family:<?=$fn->esc($resume['font'])?>">
    <div class="subpage">
        <table class="w-100">
            <tbody>
                <tr>
                    <td colspan="2" class="text-center fw-bold fs-4">Resume</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="personal-info zsection">
                        <div class="fw-bold name"><?=$fn->esc($resume['full_name'])?></div>
                        <div>Mobile : <span class="mobile">+91-<?=$fn->esc($resume['mobile_no'])?></span></div>
                        <div>Email : <span class="email"><?=$fn->esc($resume['email_id'])?></span></div>
                        <div>Address : <span class="address"><?=$fn->esc($resume['address'])?></span></div>
                        <hr>
                    </td>
                </tr>

                <tr class="objective-section zsection">
                    <td class="fw-bold align-top text-nowrap pr title">Objective</td>
                    <td class="pb-3 objective">
                    <?=$fn->esc($resume['objective'])?>
                    </td>
                </tr>

                <tr class="experience-section zsection">
                    <td class="fw-bold align-top text-nowrap pr title">Experience</td>
                    <td class="pb-3 experiences">
                <?php
                if ($exps) {
                    foreach ($exps as $exp) {
                        ?>
                        <div class="experience mb-2">
                            <div class="fw-bold">- <span class="job-role"><?=$fn->esc($exp['position'])?>
                            </div>
                            <div class="company"><?=$fn->esc($exp['company'])?></div>
                            <div><span class="working-from"><?=$fn->esc($exp['started'])?></span> – <span class="working-to"><?=$fn->esc($exp['ended'])?></span></div>
                            <div class="work-description"><?=$fn->esc($exp['job_desc'])?></div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="new">I am a Fresher </div>
                    <div class="new">I have no experience </div>
                    <?php
                }
                ?>

                    </td>
                </tr>

                <tr class="education-section zsection">
                    <td class="fw-bold align-top text-nowrap pr title">Education</td>
                    <td class="pb-3 educations">
                    <?php
                if ($edus) {
                    foreach ($edus as $edu) {
                        ?>
                        <div class="education mb-2">
                            <div class="fw-bold">- <span class="course"><?=$fn->esc($edu['course'])?></span></div>
                            <div class="institute"><?=$fn->esc($edu['institute'])?></div>
                            <div><span class="date"><?=$fn->esc($edu['started'])?></span> – <span class="date"><?=$fn->esc($edu['ended'])?></span></div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="new">I don't have any education </div>
                    <?php
                }
                ?>
                    </td>
                </tr>

                <tr class="skills-section zsection">
                    <td class="fw-bold align-top text-nowrap pr title">Skills</td>
                    <td class="pb-3 skills">
                    <?php
                if ($skills) {
                    foreach ($skills as $skill) {
                        ?>
                        <div class="skill">- <?=$fn->esc($skill['skill'])?></div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="skill">- I have no skill</div>
                    <?php
                }
                ?>
                    </td>
                </tr>

                <tr class="personal-details-section zsection">
                    <td class="fw-bold align-top text-nowrap pr title">Personal Details</td>
                    <td class="pb-3">
                        <table class="pd-table">
                            <tr>
                                <td>Date of Birth</td>
                                <td>: <span class="date-of-birth"><?=date('d M Y', strtotime($resume['dob']))?></span></td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>: <span class="gender"><?=$fn->esc($resume['gender'])?></span></td>
                            </tr>
                            <tr>
                                <td>Religion</td>
                                <td>: <span class="religion"><?=$fn->esc($resume['religion'])?></span></td>
                            </tr>
                            <tr>
                                <td>Nationality</td>
                                <td>: <span class="nationality"><?=$fn->esc($resume['nationality'])?></span></td>
                            </tr>
                            <tr>
                                <td>Marital Status</td>
                                <td>: <span class="marital-status"><?=$fn->esc($resume['marital_status'])?></span></td>
                            </tr>
                            <tr>
                                <td>Hobbies</td>
                                <td>: <span class="hobbies"><?=$fn->esc($resume['hobbies'])?></span></td>
                            </tr>

                        </table>

                    </td>
                </tr>

                <tr class="languages-known-section zsection">
                    <td class="fw-bold align-top text-nowrap pr title">Languages Known</td>
                    <td class="pb-3 languages">
                        <?=$fn->esc($resume['languages'])?>
                    </td>
                </tr>

                <tr class="declaration-section zsection">
                    <td class="fw-bold align-top text-nowrap pr title">Declaration</td>
                    <td class="pb-5 declaration">
                        I hereby declare that above information is correct to the best of my
                        knowledge and can be supported by relevant documents as and when
                        required.
                    </td>
                </tr>

            </tbody>
        </table>
        <div class="d-flex justify-content-between">
                    <div class="px-3">Date : <?=date('d F, Y', $resume['updated_at']);?> </div>
                    <div class="px-3 name text-end"><?=$fn->esc($resume['full_name'])?></div>

            </div>
    </div>

</div>
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="background" style="height:50vh" aria-labelledby="offcanvasBottomLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasBottomLabel">Change Background</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body w-100">
    <style>
        .tile{
            width: 100px;
            height: 100px;
            background-size:cover;
        }
        .tile:hover
        {
            cursor: pointer;
            opacity: 0.7;
        }
        </style>
        <div class="d-flex w-100 gap-2 flex-wrap justify-content-center">
            <?php
            for ($i = 1; $i <= 23; $i++) {
            ?>
            <div class="tile rounded shadow-sm border" data-background="tile<?=$i?>.png" style="background-image:url(<?= BASE_URL ?>public/assets/images/tiles/tile<?=$i?>.png)"></div>
            <?php
            }
            ?>
    </div>
  </div>
</div>

<div class="offcanvas offcanvas-bottom" tabindex="-1" id="fontpanel" aria-labelledby="offcanvasFontLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasFontLabel">Change Font</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <select class="form-control" id="fontselect">
        <option value="'Assistant', sans-serif"style="'Assistant', sans-serif">System Font</option>
        <option value="'Ruge Boogie', serif" style="font-family:'Ruge Boogie', serif">'Ruge Boogie', serif</option>
        <option value="'Playfair Display', serif" style="font-family:'Playfair Display', serif">'Playfair Display', serif</option>
        <option value="'Pacifico', serif" style="font-family:'Pacifico', serif">'Pacifico', serif</option>
        <option value="'Edu AU VIC WA NT Hand', serif" style="font-family:'Edu AU VIC WA NT Hand', serif">'Edu AU VIC WA NT Hand', serif</option>
        <option value="'Dancing Script', serif" style="font-family:'Dancing Script', serif">'Dancing Script', serif</option>
        <option value="'Bodoni Moda SC', serif" style="font-family:'Bodoni Moda SC', serif">'Bodoni Moda SC', serif</option>
        <option value="'Bebas Neue', serif" style="font-family:'Bebas Neue', serif">'Bebas Neue', serif</option>
        <option value="'Agdasima', serif" style="font-family:'Agdasima', serif">'Agdasima', serif</option>
    </select>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>

<script>
$("#fontselect").change(function(){
    let font = $(this).find(":selected").val();
    $(".page").css('font-family',font);

    $.ajax({
    url: '<?= BASE_URL ?>app/actions/resume/changefont.action.php',
    method: 'post',
    data: {
        resume_id: '<?= intval($resume['id']) ?>',
        font: font,
    },
    success: function(res) {
        console.log(res);
    },
    error: function(res) {
        console.log(res);
        alert('Font is not updated');
    }
});
})

$(".tile").click(function(){
    let tile = $(this).data('background');;
    $("body").css('background-image','url(<?= BASE_URL ?>public/assets/images/tiles/'+tile+')');

    $.ajax({
    url: '<?= BASE_URL ?>app/actions/resume/changebackground.action.php',
    method: 'post',
    data: {
        resume_id: '<?= intval($resume['id']) ?>',
        background: tile,
    },
    success: function(res) {
        console.log(res);
    },
    error: function(res) {
        console.log(res);
        alert('Background is not updated');
    }
});
})

$("#print").click(function(){
    $(".extra").hide();

    window.print();

    setTimeout(() => {
        $(".extra").show();
    }, 500);
});

$("#downloadpdf").click(function () {
    window.jsPDF = window.jspdf.jsPDF
    var doc = new jsPDF();

    var page = document.querySelector('.page');

    doc.html(page, {
        callback: function (doc) {
            var fileName = <?=json_encode($fn->esc($resume['full_name']) . '-' . $fn->esc($resume['resume_title']) . '.pdf')?>;
            doc.save(fileName);
        },
        margin: [10, 10, 10, 10],
        x: 10,
        y: 10,
        width: 190,
        windowWidth: 800
    });
});

</script>
</body>
</html>


