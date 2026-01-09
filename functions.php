<?php
/**
 * Pomocné funkce aplikace
 */

// =============================================================================
// CSRF ochrana
// =============================================================================

/**
 * Vygeneruje CSRF token a uloží do session
 */
function generateCsrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Ověří CSRF token z POST požadavku
 */
function validateCsrfToken(): bool {
    $token = $_POST['csrf_token'] ?? '';
    return !empty($token) && hash_equals($_SESSION['csrf_token'] ?? '', $token);
}

// =============================================================================
// Flash messages (PRG pattern)
// =============================================================================

/**
 * Uloží zprávu do session pro zobrazení po redirectu
 */
function setFlashMessage(string $message, string $type = 'error'): void {
    $_SESSION['flash_message'] = ['text' => $message, 'type' => $type];
}

/**
 * Vrátí a smaže flash message ze session
 */
function getFlashMessage(): ?array {
    $message = $_SESSION['flash_message'] ?? null;
    unset($_SESSION['flash_message']);
    return $message;
}

/**
 * Přesměruje na danou URL (PRG pattern)
 */
function redirect(string $url = ''): void {
    $location = $url ?: $_SERVER['PHP_SELF'];
    header('Location: ' . $location);
    exit;
}

// =============================================================================
// Validace souborů
// =============================================================================

/**
 * Odstraní nepovolené znaky z názvu souboru
 */
function sanitizeFilename(string $filename): string {
    $len = strlen($filename);
    $chars = [];

    for ($i = 0; $i < $len; $i++) {
        $c = ord($filename[$i]);
        // Povolené: A-Z, a-z, 0-9, . - _
        if (($c >= 65 && $c <= 90) || ($c >= 97 && $c <= 122) ||
            ($c >= 48 && $c <= 57) || $c === 46 || $c === 45 || $c === 95) {
            $chars[] = $filename[$i];
        }
    }

    return strtolower(implode('', $chars));
}

/**
 * Kontroluje, zda je přípona souboru blokovaná
 */
function isBlockedExtension(string $filename): bool {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return in_array($ext, BLOCKED_EXTENSIONS, true);
}

/**
 * Ověří, že cesta je v rámci upload adresáře
 */
function isPathSafe(string $filename): bool {
    $fullPath = realpath(UPLOAD_DIR . '/' . $filename);
    $uploadDirReal = realpath(UPLOAD_DIR);

    if ($fullPath === false || $uploadDirReal === false) {
        return false;
    }

    return strpos($fullPath, $uploadDirReal . DIRECTORY_SEPARATOR) === 0;
}

// =============================================================================
// Operace se soubory
// =============================================================================

/**
 * Vrátí seznam souborů v upload adresáři
 */
function getUploadedFiles(): array {
    $files = @scandir(UPLOAD_DIR);

    if ($files === false) {
        return [];
    }

    $result = array_filter($files, fn($f) => !in_array($f, EXCLUDED_FILES, true));
    sort($result);

    return array_values($result);
}

/**
 * Zpracuje upload souboru
 */
function handleUpload(): void {
    if (!validateCsrfToken()) {
        setFlashMessage(t('msg_csrf_invalid'));
        redirect();
        return;
    }

    if (!isset($_FILES['file'])) {
        setFlashMessage(t('msg_no_file'));
        redirect();
        return;
    }

    $file = $_FILES['file'];

    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        setFlashMessage(t('msg_no_file'));
        redirect();
        return;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        setFlashMessage(t('msg_upload_error', $file['error']));
        redirect();
        return;
    }

    $filename = sanitizeFilename(basename($file['name']));
    $targetPath = UPLOAD_DIR . '/' . $filename;

    if ($filename === '') {
        setFlashMessage(t('msg_invalid_filename'));
        redirect();
        return;
    }

    if ($file['size'] > MAX_FILE_SIZE) {
        setFlashMessage(t('msg_file_too_large', (int) round(MAX_FILE_SIZE / 1024 / 1024)));
        redirect();
        return;
    }

    if (file_exists($targetPath)) {
        setFlashMessage(t('msg_file_exists', esc($filename)));
        redirect();
        return;
    }

    if (isBlockedExtension($filename)) {
        setFlashMessage(t('msg_script_blocked', esc($filename)));
        redirect();
        return;
    }

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        setFlashMessage(t('msg_upload_success', esc($filename)), 'success');
    } else {
        setFlashMessage(t('msg_upload_failed'));
    }

    redirect();
}

/**
 * Zpracuje smazání souboru
 */
function handleDelete(): void {
    if (!validateCsrfToken()) {
        setFlashMessage(t('msg_csrf_invalid'));
        redirect();
        return;
    }

    $filename = basename($_POST['delete'] ?? '');

    if ($filename === '' || in_array($filename, EXCLUDED_FILES, true)) {
        setFlashMessage(t('msg_invalid_file'));
        redirect();
        return;
    }

    if (!isPathSafe($filename)) {
        setFlashMessage(t('msg_access_denied'));
        redirect();
        return;
    }

    $targetPath = UPLOAD_DIR . '/' . $filename;

    if (!file_exists($targetPath)) {
        setFlashMessage(t('msg_file_not_found'));
        redirect();
        return;
    }

    if (@unlink($targetPath)) {
        setFlashMessage(t('msg_delete_success'), 'success');
    } else {
        setFlashMessage(t('msg_delete_failed'));
    }

    redirect();
}

// =============================================================================
// Pomocné funkce
// =============================================================================

/**
 * Escapuje HTML
 */
function esc(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * Vrátí přeložený text
 */
function t(string $key, ...$args): string {
    static $lang = null;

    if ($lang === null) {
        $lang = require __DIR__ . '/lang/cs.php';
    }

    $text = $lang[$key] ?? $key;

    return $args ? sprintf($text, ...$args) : $text;
}