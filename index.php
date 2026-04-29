<?php
/**
 * Root Entry Point
 * 
 * This is the main entry point for the application (http://localhost/resumebuilder/).
 * It bootstraps the app and redirects traffic based on authentication status:
 *   - Logged-in users  → Dashboard (myresumes.php)
 *   - Guest users      → Landing page (home.php)
 */
require_once __DIR__ . '/app/bootstrap.php';

if ($fn->Auth()) {
    $fn->redirect(BASE_URL . 'public/pages/internal/myresumes.php');
} else {
    $fn->redirect(BASE_URL . 'public/home.php');
}
