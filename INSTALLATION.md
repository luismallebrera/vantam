# Installation Guide

## Quick Installation

### Method 1: Manual Installation

1. **Download the Plugin**
   - Download or clone this repository
   - Locate the `vamtam-elementor-integration-execor` folder

2. **Upload to WordPress**
   ```bash
   # Via FTP or file manager
   Upload 'vamtam-elementor-integration-execor' to /wp-content/plugins/
   ```

3. **Activate the Plugin**
   - Go to WordPress Admin > Plugins
   - Find "Elementor Integration Extended"
   - Click "Activate"

### Method 2: ZIP Installation

1. Create a ZIP file of the `vamtam-elementor-integration-execor` folder
2. In WordPress Admin, go to Plugins > Add New > Upload Plugin
3. Choose the ZIP file and click "Install Now"
4. Click "Activate Plugin"

## Post-Installation

### Verify Installation

After activation, check:
- ✅ No error messages appear
- ✅ Elementor is installed and active
- ✅ New options appear in Elementor settings

### Configure Settings

1. **Go to Elementor Site Settings**
   - Open Elementor editor
   - Click hamburger menu (☰) 
   - Select "Site Settings"
   - Look for "Theme Settings" tab

2. **Customize Additional JS** (Optional)
   - Go to Appearance > Customize
   - Find "Additional JS" section
   - Add custom JavaScript for head, body, or footer

### Troubleshooting

**Problem: Plugin won't activate**
- Solution: Ensure Elementor is installed and active first

**Problem: Features not appearing**
- Solution: Clear all caches (WordPress, Elementor, and browser)
- Regenerate Elementor assets: Tools > Regenerate CSS

**Problem: Styles not loading**
- Solution: Check that the `/assets/css/` directory is writable
- Regenerate Elementor CSS and JS

## Renaming the Plugin (Optional)

If you want to completely rebrand this plugin:

1. **Rename the folder** from `vamtam-elementor-integration-execor` to your desired name
2. **Update the main plugin file** name from `vamtam-elementor-integration.php`
3. **Search and replace** in all PHP files:
   - `vamtam-elementor-integration` → `your-plugin-slug`
   - `VamtamElementor` → `YourPrefix`
   - `Vamtam_Elementor_Utils` → `Your_Prefix_Utils`

4. **Update the text domain** in the plugin header and all translation functions

## Development Setup

For developers who want to modify the plugin:

```bash
# Clone the repository
git clone https://github.com/luismallebrera/vantam.git
cd vantam/vamtam-elementor-integration-execor

# Symlink to WordPress plugins directory
ln -s $(pwd) /path/to/wordpress/wp-content/plugins/vamtam-elementor-integration-execor

# Enable WordPress debug mode in wp-config.php
define('WP_DEBUG', true);
define('SCRIPT_DEBUG', true);
```

## Uninstallation

1. Deactivate the plugin via WordPress Admin > Plugins
2. Click "Delete" to remove plugin files
3. (Optional) Remove these database options if desired:
   - `vamtam-set-experiments-default-state`
   - `vamtam_additional_js`
   - Any options starting with `elementor_experiment-`

## Next Steps

After successful installation:
- Read the [README.md](README.md) for feature overview
- Explore enhanced widgets in Elementor editor
- Configure theme settings as needed
- Add custom styles to `assets/css/style.css`
