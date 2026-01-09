<?php
/**
 * Konfigurace aplikace
 */

// Spuštění session pro CSRF a flash messages
session_start();

// Adresář pro nahrané soubory
const UPLOAD_DIR = 'data';

// Maximální velikost souboru (15 MB)
const MAX_FILE_SIZE = 15728640;

// Blokované přípony souborů (skripty)
const BLOCKED_EXTENSIONS = [
    // PHP
    'php', 'phtml', 'php3', 'php4', 'php5', 'phar',
    // JavaScript / TypeScript
    'js', 'ts', 'jsx', 'tsx', 'mjs', 'cjs', 'mts', 'cts',
    // ASP
    'asp', 'aspx',
    // Ostatní skripty
    'cgi', 'pl', 'py', 'rb', 'sh', 'bash'
];

// Soubory vyloučené ze seznamu
const EXCLUDED_FILES = ['.', '..', 'index.php'];