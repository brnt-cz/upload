<?php
/**
 * Upload souborů - hlavní vstupní bod
 */

header('Content-Type: text/html; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

// Zpracování POST požadavků
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['upload'])) {
        handleUpload();
    } elseif (isset($_POST['delete'])) {
        handleDelete();
    }
}

// Data pro šablonu
$files = getUploadedFiles();
$fileCount = count($files);
$message = getFlashMessage();

// Renderování šablony
require __DIR__ . '/templates/layout.php';
