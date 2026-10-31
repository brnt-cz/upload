# Changelog

## v2.1 (2026-10)

### Fixed
- BRNT-6: uploads failed above 2 MB. PHP on the server capped
  `upload_max_filesize` at 2 MB, so files were discarded before the
  application's own 15 MB check and the user only saw "Code: 1".
  `.htaccess` now raises the PHP limits above `MAX_FILE_SIZE`.
- Upload errors are reported in plain words instead of a numeric code.
- A request exceeding `post_max_size` is detected before the CSRF check, which
  previously reported an invalid token for what was really an oversized file.

### Changed
- The size shown in the UI is the real limit, the lowest of `MAX_FILE_SIZE`,
  `upload_max_filesize` and `post_max_size`.
- The browser rejects an oversized file right after it is picked, instead of
  after uploading the whole body.

## v2.0 (2025-01)

### Added
- MVC-like architecture with templates
- Localization support (i18n) - Czech and English
- CSRF protection for all forms
- PRG (Post-Redirect-Get) pattern
- Path traversal protection
- TypeScript extensions blocking (.ts, .tsx, .mjs, .cjs, .mts, .cts)

### Changed
- DELETE operation changed from GET to POST
- Separated templates from business logic
- Moved configuration to dedicated file

### Security
- Added `X-Content-Type-Options: nosniff` header
- Added `X-Frame-Options: DENY` header
- Filename sanitization (only A-Z, a-z, 0-9, ., -, _)

## v1.0

### Added
- Basic file upload functionality
- File deletion
- File listing
- Drag & drop support
- Responsive design
