<?php
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../classes/Functions.php';
$fn->authPage();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resume_id = intval($_POST['resume_id'] ?? 0);
    $font      = trim($_POST['font'] ?? '');
    $user_id   = $fn->Auth()['id'];

    // Whitelist allowed fonts
    $allowed_fonts = [
        "'Assistant', sans-serif",
        "'Ruge Boogie', serif",
        "'Playfair Display', serif",
        "'Pacifico', serif",
        "'Edu AU VIC WA NT Hand', serif",
        "'Dancing Script', serif",
        "'Bodoni Moda SC', serif",
        "'Bebas Neue', serif",
        "'Agdasima', serif",
    ];

    if ($resume_id > 0 && in_array($font, $allowed_fonts, true)) {
        $stmt = $db->prepare("UPDATE resumes SET font = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("sii", $font, $resume_id, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}