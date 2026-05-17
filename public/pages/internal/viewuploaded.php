<?php
    // Viewer Page for Uploaded Resumes
    require_once __DIR__ . '/../../../app/bootstrap.php';

    $slug = trim($_GET['resume'] ?? '');
    if (!$slug) {
        $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
    }

    $stmt = $db->prepare("SELECT * FROM uploaded_resumes WHERE slug = ?");
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $resume = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$resume) {
        $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
    }

    $file_url = BASE_URL . 'public/assets/uploads/' . $resume['file_path'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Agdasima:wght@400;700&family=Bebas+Neue&family=Bodoni+Moda+SC:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&family=Dancing+Script:wght@400..700&family=Edu+AU+VIC+WA+NT+Hand:wght@400..700&family=Pacifico&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Ruge+Boogie&family=Assistant:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="icon" href="<?= BASE_URL ?>public/assets/images/logo.png">
    <title><?=$fn->esc($resume['resume_title'])?> | Uploaded Resume</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font-family: 'Poppins', sans-serif;
            background: rgb(249, 249, 249);
            background: radial-gradient(circle, rgba(249, 249, 249, 1) 0%, rgba(240, 232, 127, 1) 49%, rgba(246, 243, 132, 1) 100%);
            background-image: url(<?= BASE_URL ?>public/assets/images/tiles/<?=$fn->esc($resume['background'])?>);
            background-attachment: fixed;
            min-height: 100vh;
        }
        * { margin: 0px; box-sizing: border-box; }
        .page {
            width: 21cm;
            min-height: 29.7cm;
            padding: 0;
            margin: 0.5cm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        @media print {
            .page {
                margin: 0; border: initial; border-radius: initial; width: initial; min-height: initial; box-shadow: initial; background: initial;
            }
            .extra { display: none !important; }
        }
        iframe.document-viewer {
            width: 100%;
            height: 29.7cm;
            border: none;
            flex-grow: 1;
        }
        .fallback-message {
            padding: 2cm;
            text-align: center;
        }
    </style>
</head>
<body>

<?php if ($fn->Auth() != false && $fn->Auth()['id'] == $resume['user_id']) { ?>
<div class="extra">
    <div class="w-100 py-2 bg-dark d-flex justify-content-center gap-3">
        <?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>
        <a href="https://wa.me/?text=<?=urlencode($actual_link)?>" target="_blank" class="btn btn-light btn-sm"><i class="bi bi-whatsapp"></i> Share</a>
        <button class="btn btn-light btn-sm" id="print"><i class="bi bi-printer"></i> Print</button>
        <button class="btn btn-light btn-sm" data-bs-toggle="offcanvas" data-bs-target="#background"><i class="bi bi-backpack4-fill"></i> Background</button>
        <button class="btn btn-light btn-sm" data-bs-toggle="offcanvas" data-bs-target="#fontpanel"><i class="bi bi-file-earmark-font"></i> Font</button>
        <a href="<?= $file_url ?>" download="<?= $fn->esc($resume['resume_title']) . '.' . $resume['file_type'] ?>" class="btn btn-light btn-sm"><i class="bi bi-download"></i> Download File</a>
    </div>
</div>
<?php } ?>

<div class="page" style="font-family:<?=$fn->esc($resume['font'])?>">
    <?php if ($resume['file_type'] === 'pdf') { ?>
        <iframe class="document-viewer" src="<?= $file_url ?>#view=FitH" title="Resume Viewer"></iframe>
    <?php } else { ?>
        <div class="fallback-message">
            <h3><i class="bi bi-file-earmark-word" style="font-size: 3rem;"></i></h3>
            <h4>Word Document</h4>
            <p>This document type cannot be previewed directly in the browser.</p>
            <a href="<?= $file_url ?>" download class="btn btn-primary mt-3"><i class="bi bi-download"></i> Download to View</a>
        </div>
    <?php } ?>
</div>

<!-- Background Offcanvas -->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="background" style="height:50vh">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Change Background</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body w-100">
    <style>
        .tile { width: 100px; height: 100px; background-size:cover; cursor: pointer; transition: 0.2s; }
        .tile:hover { opacity: 0.7; }
    </style>
    <div class="d-flex w-100 gap-2 flex-wrap justify-content-center">
        <?php for ($i = 1; $i <= 23; $i++) { ?>
        <div class="tile rounded shadow-sm border" data-background="tile<?=$i?>.png" style="background-image:url(<?= BASE_URL ?>public/assets/images/tiles/tile<?=$i?>.png)"></div>
        <?php } ?>
    </div>
  </div>
</div>

<!-- Font Offcanvas -->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="fontpanel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Change Font</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <p class="text-muted small mb-2"><i class="bi bi-info-circle"></i> Note: Font changes may only affect the page background and fallback messages, as the uploaded document has its own embedded fonts.</p>
    <select class="form-control" id="fontselect">
        <option value="'Assistant', sans-serif" style="font-family:'Assistant', sans-serif">System Font</option>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$("#fontselect").change(function(){
    let font = $(this).val();
    $(".page").css('font-family', font);
    $.ajax({
        url: '<?= BASE_URL ?>app/actions/resume/changefont_uploaded.action.php',
        method: 'post',
        data: { resume_id: '<?= intval($resume['id']) ?>', font: font }
    });
});

$(".tile").click(function(){
    let tile = $(this).data('background');
    $("body").css('background-image', 'url(<?= BASE_URL ?>public/assets/images/tiles/' + tile + ')');
    $.ajax({
        url: '<?= BASE_URL ?>app/actions/resume/changebg_uploaded.action.php',
        method: 'post',
        data: { resume_id: '<?= intval($resume['id']) ?>', background: tile }
    });
});

$("#print").click(function(){
    window.print();
});
</script>
</body>
</html>
