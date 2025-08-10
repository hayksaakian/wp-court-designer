# Changelog

All notable changes to the WP Court Designer plugin will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.2.0] - 2024-08-10

### Added
- Color indicators on area selection tabs showing current color for each area
- "Currently Selected: [Color Name]" display when choosing colors
- Visual feedback showing which color is selected for each court area

### Changed
- Improved user interface for better color selection clarity
- "Choose Color" text updated to "Choose a Color" for better grammar

## [1.1.0] - 2024-08-10

### Changed
- **BREAKING**: Logo upload moved from frontend to admin settings only
- Logo is now persistent across all court designs (company branding)
- Logo no longer defaults to CourtCo logo when empty

### Added
- Company logo setting in WordPress admin panel
- Media uploader integration for logo selection
- Logo preview in admin settings

### Removed
- Frontend logo upload functionality
- Per-session logo customization

## [1.0.2] - 2024-08-10

### Fixed
- Settings link now correctly points to options-general.php?page=court-designer-settings

## [1.0.1] - 2024-08-10

### Added
- Settings link in WordPress plugins list for quick access to configuration
- Versioning documentation and principles
- CHANGELOG.md for tracking changes
- Automatic plugin build on git commit

### Changed
- Updated plugin authorship to Hayk Saakian
- Plugin URI now points to GitHub repository

## [1.0.0] - 2024-08-05

### Added
- Initial release of WP Court Designer
- Support for Tennis, Basketball, and Pickleball courts
- 17 standard court colors with LEED certification info
- Real-time color customization
- Download court designs as PNG
- WordPress shortcode support: `[court_designer type="tennis"]`
- Gutenberg block integration
- Responsive design for all devices
- Accessibility features (ARIA labels, keyboard navigation)
- Admin settings page for configuration
- SVG-based rendering for crisp visuals

### Technical
- Client-side rendering (no server requests for color changes)
- Lightweight implementation with vanilla JavaScript
- WordPress 5.8+ compatibility
- PHP 7.4+ compatibility

---

## Version Guidelines

When updating this file:

1. Keep "Unreleased" section for ongoing work
2. Move "Unreleased" items to a new version section when releasing
3. Use these categories:
   - **Added** for new features
   - **Changed** for changes in existing functionality
   - **Deprecated** for soon-to-be removed features
   - **Removed** for now removed features
   - **Fixed** for any bug fixes
   - **Security** for vulnerability fixes

4. Version bump triggers:
   - Bug fixes only = PATCH (1.0.x)
   - New features = MINOR (1.x.0)
   - Breaking changes = MAJOR (x.0.0)