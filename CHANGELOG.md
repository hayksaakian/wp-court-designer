# Changelog

All notable changes to the WP Court Designer plugin will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.6.0] - 2025-10-15

### Added
- Pickleball + Half-Court Basketball combo court type (`pb-halfbasketball`)
- New SVG court layout with accurate measurements from shop drawings
- Gray non-volley zone (kitchen) as colorable area
- Basketball half-court overlay with key, free throw line, 3-point arc, and basket
- Support for 5 colorable areas: court, border, nonVolleyZone, primaryLines (pickleball), secondaryLines (basketball)
- Default colors: Blue court, Forest Green border, Gray kitchen, White pickleball lines, Cyan basketball lines

### Changed
- Enhanced combo court dropdown with new "Pickleball + Half Basketball" option
- Updated designer template to support non-volley zone in combo courts
- Improved JavaScript area mapping for new court type

## [1.4.0] - 2024-08-24

### Added
- Line color customization for all court types
- White and Black colors added to palette
- Filtered color palettes - different colors for lines vs fills
- Lines only show specific colors (white, black, blues, greens, red, gray, yellow)
- Fills exclude white and black from selection

### Changed
- Updated color palette to client's exact hex values
- Tennis court dimensions updated to match shop drawings (120' x 60' total area)
- Pickleball court margins increased for better proportions (64' x 40' total area)
- Color swatches dynamically update based on selected area

### Removed
- LEED labels and references from color interface (per client request)

### Fixed
- Basketball court lines now all change color correctly
- Pickleball court lines now all change color correctly
- White color swatch now has border for visibility

## [1.3.3] - 2024-08-19

### Fixed
- JavaScript enqueuing - moved inline scripts to separate admin-settings.js file
- Properly enqueue admin scripts using wp_enqueue_script()
- Pass translatable strings via wp_localize_script()

### Changed
- Removed screenshot files from plugin distribution (WordPress.org compliance)
- Screenshots now only in SVN repository, not in plugin zip
- Updated build script to explicitly exclude screenshots

## [1.3.2] - 2024-08-10

### Fixed
- All WordPress.org Plugin Check errors resolved
- Replaced _e() with proper escaping functions (esc_html__, esc_attr__)
- Added proper input validation for $_POST data
- Removed deprecated load_plugin_textdomain() function

### Changed
- Updated tested up to WordPress 6.8
- Reduced plugin tags to 5 (WordPress.org limit)
- Shortened plugin description to under 150 characters
- Improved code to meet WordPress coding standards

## [1.3.1] - 2024-08-10

### Fixed
- Reset colors button now properly updates color indicators
- Basketball and Pickleball color indicators now display correctly when switching court types
- Color indicators properly rebuild when changing court types

## [1.3.0] - 2024-08-10

### Security Enhancement
- **MAJOR SECURITY IMPROVEMENT**: Removed URL input for logos completely
- Logo uploads now ONLY through WordPress Media Library (no external URLs)
- Logos stored as attachment IDs instead of URLs for better security
- Eliminated all URL validation vulnerabilities

### Added
- Automatic migration from old logo URLs to attachment IDs for existing users
- Better integration with WordPress Media Library
- Image type filtering in media uploader (only images allowed)

### Changed
- Logo setting now uses attachment ID instead of URL
- Simplified admin interface - single button for logo selection
- More secure data storage using WordPress attachment system

### Removed
- URL input field for logo uploads (security improvement)
- URL validation code (no longer needed)

## [1.2.1] - 2024-08-10

### Security
- Enhanced URL validation for logo uploads using esc_url_raw() and FILTER_VALIDATE_URL
- Added error handling for JSON file loading and parsing
- Improved file inclusion with existence checks
- Better input validation and sanitization throughout

### Fixed
- JavaScript initialization for dynamically loaded scripts
- Error handling for missing template files
- JSON parsing errors now handled gracefully

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