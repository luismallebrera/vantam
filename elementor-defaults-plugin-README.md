# Elementor Global Defaults Plugin

A lightweight WordPress plugin that automatically applies predefined global colors and typography to Elementor on first activation.

## Features

- ✅ **Automatic Application** - No user interaction needed, applies defaults on first load
- ✅ **One-Time Operation** - Only runs once, won't override your future changes
- ✅ **9 System Colors** - Professional color palette (Accent 1-8 + Sticky Header)
- ✅ **7 System Typography** - Complete heading hierarchy (Primary Font + H1-H6)
- ✅ **4 Custom Colors** - Extended palette (Accent 9-10, Body Text, Background Blur)
- ✅ **9 Custom Typography** - Specialized styles (Accent Title, Body S/L, Quote, Menu, Button, etc.)
- ✅ **Minimal Code** - Single file plugin, no dependencies beyond Elementor

## Installation

1. Upload `elementor-defaults-plugin.php` to `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Defaults are automatically applied to your active Elementor kit
4. Done! Check Elementor → Site Settings → Global Colors & Global Fonts

## Requirements

- WordPress 5.0 or higher
- PHP 7.0 or higher
- Elementor (free or pro) installed and activated

## What Gets Applied

### System Colors
- **Accent 1**: `#0F3D3A` (Dark Teal)
- **Accent 2**: `#C8F8A9` (Light Green)
- **Accent 3**: `#F2F5F1` (Off White)
- **Accent 4**: `#F8F7F3` (Warm White)
- **Accent 5**: `#FFFFFF` (Pure White)
- **Accent 6**: `#000000` (Black)
- **Accent 7**: `#0000001A` (Black 10% opacity)
- **Accent 8**: `#00000099` (Black 60% opacity)
- **Sticky Header Bg**: `#0F3D3ACC` (Dark Teal 80% opacity)

### System Typography
- **Primary Font**: DM Sans, 15px, 1.5 line-height
- **H1**: DM Sans, 46px (responsive)
- **H2**: DM Sans, 40px (responsive)
- **H3**: DM Sans, 30px (responsive)
- **H4**: DM Sans, 24px
- **H5**: DM Sans, 20px
- **H6**: DM Sans, 16px

### Custom Colors
- **Accent 9**: `#FFFFFF80` (White 50% opacity)
- **Accent 10**: `#1F6E69` (Medium Teal)
- **Body Text**: `#000000BF` (Black 75% opacity)
- **Background Blur**: `#0F3D3A66` (Dark Teal 40% opacity)

### Custom Typography
- **Accent Title**: Forum, 56px (decorative heading)
- **Body S**: 12px (small text)
- **Body L**: 17px (large text)
- **Quote**: Forum, 21px
- **Menu**: DM Sans, 16px, weight 500
- **Button**: DM Sans, 14px, weight 500
- **Title Label**: DM Sans, 12px, weight 500
- **Statistics Numbers**: DM Sans, 66px, weight 200
- **Handwrite**: Nothing You Could Do, 20px

## How It Works

1. Plugin checks if Elementor is active
2. On `elementor/init` hook, checks if defaults have been applied before
3. If not, retrieves active Elementor kit ID
4. Merges default colors and typography into kit settings
5. Clears Elementor cache
6. Marks as applied (stored in `elementor_global_defaults_applied` option)

## Reset/Reapply

To reapply defaults:
```php
delete_option('elementor_global_defaults_applied');
```

Or via WP-CLI:
```bash
wp option delete elementor_global_defaults_applied
```

Then refresh your WordPress admin dashboard.

## Customization

To modify the defaults before activation, edit the `get_defaults()` method in the plugin file. Change colors, fonts, sizes, or add/remove items as needed.

## License

GPL v2 or later

## Author

Luis Mallebrera - [GitHub](https://github.com/luismallebrera)

## Changelog

### 1.0.0
- Initial release
- Automatic defaults application
- Complete color and typography system
