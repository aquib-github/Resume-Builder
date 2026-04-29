<?php
// Action: Destroy session and log out user
require_once __DIR__ . '/../../bootstrap.php';

session_unset();
session_destroy();
header('Location:' . BASE_URL . 'public/pages/public/login.php');
exit();