# Changelog

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
