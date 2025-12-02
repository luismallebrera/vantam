# Elementor Integration Extended

An enhanced Elementor integration plugin that extends the Elementor page builder with additional widgets and customizations. This plugin works with **any WordPress theme** - no specific theme required.

## Description

This plugin was originally designed for VamTam themes but has been modified to work independently with any WordPress theme. It provides:

- Enhanced Elementor widgets (Button, Container, Form, Icon, Nav Menu, Page)
- Dynamic tags for advanced content display
- Custom site settings integration
- Performance optimizations
- Additional JavaScript injection points (head, body, footer)

## Requirements

- WordPress 5.0 or higher
- PHP 7.0 or higher
- Elementor 2.0.0 or higher

## Installation

1. Upload the `vamtam-elementor-integration-execor` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. The plugin will automatically extend Elementor with additional features

## Features

### Enhanced Widgets

The plugin extends these Elementor widgets with additional controls and styling options:

- **Button**: Enhanced icon styles and content alignment
- **Container**: Sticky header controls and clip-path sections
- **Form**: Button hover animations
- **Icon**: Theme-specific icon styling
- **Nav Menu**: Advanced navigation options
- **Page**: Custom page controls

### Dynamic Tags

- Author Profile Picture
- Popup integration

### Customization

All widget enhancements are enabled by default. You can disable them via Elementor Site Settings > Theme Settings.

### Additional JS

Add custom JavaScript in three locations through the WordPress Customizer (Appearance > Customize > Additional JS):
- Before `</head>`
- After `<body>`
- Before `</body>`

## Experiments & Features

The plugin automatically configures Elementor experiments:
- **Enabled by default**: Container, Nested Elements, Mega Menu
- **Disabled**: Additional Custom Breakpoints, Font Icon SVG

## Theme Support

While this plugin works with any theme, themes can optionally declare support for specific features using:

```php
add_theme_support( 'vamtam-elementor-widgets', 'feature-name' );
```

If no theme support is declared, all features are enabled by default.

## Development

### File Structure

```
vamtam-elementor-integration-execor/
├── vamtam-elementor-integration.php (Main plugin file)
├── assets/
│   ├── css/ (Stylesheet directory)
│   └── js/ (JavaScript files)
├── includes/
│   ├── vamtam-elementor-hooks.php (Elementor hooks)
│   ├── dynamic-tags/ (Custom dynamic tags)
│   ├── helpers/ (Utility functions)
│   ├── kits/ (Kit overrides)
│   ├── site-settings/ (Theme settings panel)
│   ├── theme-overrides/ (Theme compatibility functions)
│   └── widgets/ (Widget enhancements)
└── languages/ (Translation files)
```

## Credits

Originally based on VamTam Elementor Integration (Execor) by VamTam.
Modified by Luis Mallebrera to work independently without theme dependency.

## License

This plugin inherits its license from the original VamTam integration.