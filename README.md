# File Upload

A simple and secure PHP application for uploading and managing files.

## Features

- **Drag & Drop Upload** - Simply drag files onto the dropzone
- **File Management** - View, download, and delete uploaded files
- **Security First** - CSRF protection, path traversal prevention, script blocking
- **Localization** - Multi-language support (Czech, English)
- **Responsive Design** - Works on desktop and mobile devices

## Requirements

- PHP 7.4 or higher
- Web server (Apache/Nginx)
- Write permissions for the `data/` directory

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/brnt-cz/upload.git
   ```

2. Set write permissions for the upload directory:
   ```bash
   chmod 755 data/
   ```

3. Configure your web server to point to the project directory.

4. (Optional) Adjust settings in `config.php`:
   ```php
   const UPLOAD_DIR = 'data';           // Upload directory
   const MAX_FILE_SIZE = 15728640;      // Max file size (15 MB)
   ```

## Configuration

### `config.php`

| Constant | Default | Description |
|----------|---------|-------------|
| `UPLOAD_DIR` | `'data'` | Directory for uploaded files |
| `MAX_FILE_SIZE` | `15728640` | Maximum file size in bytes (15 MB) |
| `BLOCKED_EXTENSIONS` | *array* | File extensions that cannot be uploaded |
| `EXCLUDED_FILES` | `['.', '..', 'index.php']` | Files excluded from listing |

### Blocked File Extensions

Scripts and executable files are blocked by default:

- **PHP**: `php`, `phtml`, `php3`, `php4`, `php5`, `phar`
- **JavaScript/TypeScript**: `js`, `ts`, `jsx`, `tsx`, `mjs`, `cjs`, `mts`, `cts`
- **ASP**: `asp`, `aspx`
- **Other**: `cgi`, `pl`, `py`, `rb`, `sh`, `bash`

## Localization

The application supports multiple languages. Language files are located in the `lang/` directory.

### Switching Languages

Modify the `t()` function in `functions.php` to select the desired language:

```php
function t(string $key, ...$args): string {
    static $lang = null;

    if ($lang === null) {
        // Change 'cs' to 'en' for English
        $lang = require __DIR__ . '/lang/cs.php';
    }

    $text = $lang[$key] ?? $key;
    return $args ? sprintf($text, ...$args) : $text;
}
```

### Adding a New Language

1. Copy `lang/en.php` to `lang/xx.php` (where `xx` is the language code)
2. Translate all values in the array
3. Update the `t()` function to load your language file

## Project Structure

```
├── data/                   # Uploaded files directory
│   └── index.php           # Directory access protection
├── lang/                   # Language files
│   ├── cs.php              # Czech
│   └── en.php              # English
├── templates/              # View templates
│   ├── layout.php          # Main layout
│   └── partials/           # Partial templates
│       ├── header.php
│       ├── message.php
│       ├── upload-form.php
│       ├── sidebar.php
│       └── modal.php
├── config.php              # Configuration
├── functions.php           # Business logic
├── index.php               # Entry point (controller)
├── style.css               # Styles
├── app.js                  # JavaScript
└── README.md               # This file
```

## Security

### CSRF Protection
All forms include a CSRF token that is validated on every POST request.

### Path Traversal Prevention
File paths are validated to ensure they remain within the upload directory.

### Filename Sanitization
Only alphanumeric characters, dots, hyphens, and underscores are allowed in filenames.

### PRG Pattern
Post-Redirect-Get pattern prevents form resubmission on page refresh.

### HTTP Security Headers
```
X-Content-Type-Options: nosniff
X-Frame-Options: DENY
```

## License

MIT License

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request
