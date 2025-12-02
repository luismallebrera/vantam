# Elementor Default Settings

This directory contains default Elementor configuration files that can be imported when activating the plugin.

## Files

### elementor-global-defaults.php
PHP array containing default global colors and typography styles for Elementor. This includes:
- **System Colors**: 9 accent colors plus sticky header background
- **System Typography**: Primary font and heading styles (H1-H6)
- **Custom Colors**: Additional 4 custom colors
- **Custom Typography**: 9 custom typography styles including accent titles, body variants, quotes, menu, buttons, etc.

### elementor-global-defaults.json
JSON version of the global defaults (legacy format, PHP version is preferred).

### elementor-settings.json
Elementor plugin settings including:
- Theme builder conditions for templates
- CPT support configuration
- Color and typography scheme settings
- Viewport settings

## Auto-Import Feature

Upon first activation with Elementor active, the plugin will display an admin notice offering to import these defaults. Users can:
- **Import Defaults**: Apply all predefined colors and typography to their Elementor kit
- **Skip**: Dismiss the notice and use their own settings

The importer will:
1. Load the default styles from `elementor-global-defaults.php`
2. Apply them to the active Elementor kit
3. Import compatible plugin settings from `elementor-settings.json`
4. Clear Elementor cache
5. Mark import as complete (won't show again)

## Manual Import

If you need to manually apply these defaults:

1. Go to **Elementor → Settings → Style**
2. In the **Colors** section, manually add the colors from `elementor-global-defaults.php`
3. In the **Typography** section, manually add the fonts from the same file
4. Save changes

## Customization

You can customize these defaults before activation:

1. Edit `elementor-global-defaults.php` 
2. Modify the color hex values or typography settings
3. Add/remove custom colors or typography styles
4. Save the file

The changes will be applied when the import runs.

## Developer Notes

- The importer class is located in `includes/helpers/elementor-defaults-importer.php`
- Import status is stored in `vamtam_elementor_defaults_imported` option
- The importer only runs once per site
- Requires Elementor to be active
- Requires user with `manage_options` capability
- Non-destructive: Only imports if kit exists and user approves

## Color Palette

Default colors included:
- Accent 1-8: Theme accent colors
- Accent 9-10: Extended accent colors  
- Body Text: Default text color
- Background Blur: Semi-transparent background
- Sticky Header Bg: Header background when sticky

## Typography Styles

Default typography included:
- Primary Font + H1-H6: Base typography system
- Accent Title: Decorative heading style
- Body S/L: Small and large body text variants
- Quote: Blockquote styling
- Menu: Navigation styling
- Button: CTA button text
- Title Label: Small labels
- Statistics Numbers: Large number displays
- Handwrite: Decorative handwritten style
