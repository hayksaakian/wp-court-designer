# WP Court Designer

A free, open-source WordPress plugin that allows site owners to embed an interactive court designer for tennis, basketball, and pickleball courts with customizable colors.

## Features

- **Three Court Types**: Tennis, Basketball, and Pickleball
- **Real-time Color Customization**: Instant preview of color changes
- **17 Standard Colors**: Professional court colors including LEED-certified options
- **Responsive Design**: Works on desktop, tablet, and mobile devices
- **Multiple Integration Methods**: Shortcode and Gutenberg block support
- **Download Functionality**: Export court designs as PNG images
- **Accessibility**: ARIA labels and keyboard navigation support
- **Lightweight**: Client-side rendering with no database calls

## Installation

### Method 1: WordPress Admin Dashboard

1. Download the plugin as a ZIP file
2. Go to WordPress Admin → Plugins → Add New
3. Click "Upload Plugin" and select the ZIP file
4. Click "Install Now" and then "Activate"

### Method 2: Manual Installation

1. Clone or download this repository
2. Upload the `wp-court-designer` folder to `/wp-content/plugins/`
3. Activate the plugin through the 'Plugins' menu in WordPress

### Method 3: Development Installation

```bash
# Clone the repository
git clone https://github.com/hayksaakian/wp-court-designer.git

# Navigate to the plugin directory
cd wp-court-designer

# Install dependencies (optional, for development)
npm install

# Create ZIP for distribution
npm run zip
```

## Usage

### Shortcode

Add the court designer to any post or page using the shortcode:

```
[court_designer type="tennis"]
[court_designer type="basketball"]
[court_designer type="pickleball"]
```

### Gutenberg Block

1. In the block editor, search for "Court Designer"
2. Add the block to your page
3. Select the court type in the block settings

## Court Areas

### Tennis
- **Court**: Inner play area
- **Border**: Outer area

### Basketball
- **Court**: Main playing surface
- **Border**: Surrounding area
- **3-Point Area**: Three-point line area
- **Key**: Paint area near basket
- **Top of Key**: Arc at the top of the key
- **Center Court Circle**: Center jump circle

### Pickleball
- **Court**: Main playing area
- **Border**: Surrounding area
- **Non-Volley Zone**: Kitchen area near the net

## Available Colors

The plugin includes 17 standard court colors:

- Ice Blue (LEED SRI 62)
- Light Blue
- Blue
- Light Green (LEED SRI 31)
- Forest Green
- Dark Green
- Tournament Purple
- Black
- Maroon
- Red (LEED SRI 36)
- Brite Red
- Orange
- Yellow
- Sandstone (LEED SRI 46)
- Beige
- Dove Gray (LEED SRI 33)
- Brown (ColorPlus fusion blend)

## Customization

### Modifying Colors

Edit the `assets/data/colors.json` file to add or modify colors:

```json
{
    "name": "Custom Blue",
    "hex": "#1234AB",
    "leed": {"sri": 50, "credit": true}
}
```

### Adding Court Types

To add new court types:
1. Create an SVG file in `assets/images/courts/`
2. Use appropriate IDs for colorable areas
3. Update the JavaScript and PHP files to include the new court type

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Requirements

- WordPress 5.8 or higher
- PHP 7.4 or higher

## Development

### Building Assets

```bash
# Install dependencies
npm install

# Start development build
npm run start

# Production build
npm run build

# Lint JavaScript
npm run lint:js

# Lint CSS
npm run lint:css

# Create distribution ZIP
npm run zip
```

## License

This plugin is licensed under GPL-2.0+. See LICENSE file for details.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## Support

For issues, questions, or suggestions, please [open an issue](https://github.com/hayksaakian/wp-court-designer/issues) on GitHub.

## Credits

Developed by [Hayk Saakian](https://github.com/hayksaakian)

## Disclaimer

This is an independent project and is not affiliated with SportMaster or any court surfacing manufacturer. Colors are approximations and may vary from actual products.