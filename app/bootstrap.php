<?php
// Application Bootstrap — loads session, config, database, and helpers
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/core/config.php';
require_once __DIR__ . '/core/database.php';
require_once __DIR__ . '/core/functions.php';
