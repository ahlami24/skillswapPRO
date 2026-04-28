<?php
session_start();
define('BASE_URL', 'http://localhost/skillswap_pro/');

// Helper for clean redirects
function redirect($path) {
    header("Location: " . BASE_URL . $path);
    exit();
}
?>