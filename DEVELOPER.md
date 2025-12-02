# Developer Quick Reference

## Plugin Architecture

### Core Files

```
vamtam-elementor-integration.php     Main plugin class, initialization
includes/vamtam-elementor-hooks.php  Elementor action/filter hooks
includes/theme-overrides/functions.php  Theme support compatibility layer
```

### Key Classes & Functions

#### Main Plugin Class
```php
VamtamElementorIntregration::instance()  // Singleton instance
VamtamElementorIntregration::after_theme_setup()  // Load widget overrides
```

#### Helper Functions
```php
vamtam_theme_supports( $feature )  // Check feature support (always true by default)
\Vamtam_Elementor_Utils::is_widget_mod_active( $widget_name )  // Check if widget modifications are enabled
\Vamtam_Elementor_Utils::get_theme_site_settings( $setting_key, $in_editor )  // Get site setting value
```

## Widget Enhancement Pattern

### Basic Widget Override Structure

```php
<?php
namespace VamtamElementor\Widgets\WidgetName;

if ( ! \Vamtam_Elementor_Utils::is_widget_mod_active( 'widget-name' ) ) {
    return; // Exit if modifications disabled
}

// Add controls to widget
function add_custom_controls( $controls_manager, $widget ) {
    $widget->add_control(
        'custom_control_id',
        [
            'label' => __( 'Custom Control', 'vamtam-elementor-integration' ),
            'type' => $controls_manager::SWITCHER,
            'default' => '',
        ]
    );
}

// Hook into Elementor
add_action( 'elementor/element/widget-name/section_name/before_section_end', 
    function( $widget, $args ) {
        add_custom_controls( \Elementor\Plugin::$instance->controls_manager, $widget );
    }, 10, 2 
);
```

### Adding Custom CSS Classes

```php
function add_prefix_class( $controls_manager, $widget ) {
    \Vamtam_Elementor_Utils::add_control_options( 
        $controls_manager, 
        $widget, 
        'control_name', 
        [
            'prefix_class' => 'my-custom-',
        ] 
    );
}
```

### Modifying Existing Controls

```php
function modify_control( $controls_manager, $widget ) {
    \Vamtam_Elementor_Utils::replace_control_options( 
        $controls_manager, 
        $widget, 
        'existing_control', 
        [
            'default' => 'new-default-value',
            'options' => [
                'option1' => 'Label 1',
                'option2' => 'Label 2',
            ]
        ] 
    );
}
```

## Hooks & Filters

### Plugin Hooks

```php
// After plugin is loaded
do_action( 'VamtamElementorIntregration/loaded' );
```

### Elementor Hooks Used

```php
// Editor scripts
add_action( 'elementor/editor/before_enqueue_scripts', 'callback' );

// Frontend scripts
add_action( 'elementor/frontend/before_enqueue_scripts', 'callback' );

// Plugin initialization
add_action( 'elementor/init', 'callback' );

// Widget attribute modification
add_action( 'elementor/element/after_add_attributes', 'callback' );

// Image HTML filter
add_filter( 'elementor/image_size/get_attachment_image_html', 'callback', 11, 4 );
```

## Dynamic Tags

### Creating a Custom Dynamic Tag

```php
<?php
namespace VamtamElementor\DynamicTags;

use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module;

class Custom_Tag extends Tag {
    public function get_name() {
        return 'custom-tag';
    }

    public function get_title() {
        return __( 'Custom Tag', 'vamtam-elementor-integration' );
    }

    public function get_group() {
        return Module::POST_GROUP;
    }

    public function get_categories() {
        return [ Module::TEXT_CATEGORY ];
    }

    public function render() {
        echo 'Custom output';
    }
}

// Register the tag
add_action( 'elementor/dynamic_tags/register', function( $dynamic_tags ) {
    $dynamic_tags->register( new Custom_Tag() );
});
```

## Site Settings

### Adding Custom Settings

Settings are added in `includes/site-settings/theme-site-settings.php`:

```php
$kit->add_control(
    'setting_id',
    [
        'label' => __( 'Setting Label', 'vamtam-elementor-integration' ),
        'type' => Controls_Manager::SWITCHER,
        'default' => '',
    ]
);
```

### Retrieving Settings

```php
$value = \Vamtam_Elementor_Utils::get_theme_site_settings( 'setting_id', true );
```

## JavaScript Integration

### Frontend JS

File: `assets/js/vamtam-elementor-frontend.js`

```javascript
jQuery(window).on('elementor/frontend/init', function() {
    // Widget-specific handlers
    elementorFrontend.hooks.addAction('frontend/element_ready/widget.default', function($scope) {
        // Your widget initialization code
    });
});
```

### Editor JS

File: `assets/js/vamtam-elementor.js`

```javascript
jQuery(window).on('elementor:init', function() {
    // Editor customizations
    elementor.hooks.addFilter('panel/elements/regionViews', function(regionViews) {
        // Modify editor UI
        return regionViews;
    });
});
```

## Constants Available

```php
VAMTAM_ELEMENTOR_INT_URL    // Plugin URL
VAMTAM_ELEMENTOR_INT_DIR    // Plugin directory path
VAMTAM_ELEMENTOR_STYLES_URI // Styles URL (assets/css/)
VAMTAM_ELEMENTOR_STYLES_DIR // Styles directory path
```

## Debugging

### Enable Debug Mode

In `wp-config.php`:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('SCRIPT_DEBUG', true);
```

### Check Widget Modifications

```php
$is_active = \Vamtam_Elementor_Utils::is_widget_mod_active( 'button' );
error_log( 'Button mods active: ' . ( $is_active ? 'yes' : 'no' ) );
```

### Check Theme Support

```php
$supported = vamtam_theme_supports( 'button--content-align-fix' );
error_log( 'Feature supported: ' . ( $supported ? 'yes' : 'no' ) );
```

## Common Tasks

### Disable All Widget Modifications
Go to Elementor > Site Settings > Theme Settings
Toggle "Disable All Widget Modifications"

### Add Custom Experiments
Edit `includes/vamtam-elementor-hooks.php`, modify:
```php
$fenable = [
    'container',
    'nested-elements', 
    'mega-menu',
    'your-experiment', // Add here
];
```

### Add New Widget Override
1. Create file in `includes/widgets/your-widget.php`
2. Use the widget enhancement pattern above
3. File auto-loads via `glob()` in main plugin file

### Add Custom Styles
Edit `assets/css/style.css` or create new CSS files in that directory

## Performance Tips

1. Widget modifications only load when Elementor is active
2. Frontend JS is deferred to footer
3. Scripts are minified in production (use `.min.js` files)
4. Check `SCRIPT_DEBUG` constant to load unminified versions

## Code Standards

- Follow WordPress coding standards
- Use namespace `VamtamElementor\` for new classes
- Prefix functions with `vamtam_` if global
- Escape output: `esc_html()`, `esc_attr()`, `esc_url()`
- Sanitize input: `sanitize_text_field()`, etc.
- Check capabilities: `current_user_can()`
- Nonce verification for forms: `wp_verify_nonce()`

## Testing Widget Changes

1. Clear all caches
2. Go to Elementor > Tools > Regenerate CSS
3. Edit a page with Elementor
4. Check if new controls appear in correct widget
5. Test on frontend
6. Check browser console for JS errors

## Common Issues

**Controls not appearing:**
- Check if widget name matches Elementor's internal name
- Verify section name and hook priority
- Clear Elementor cache

**Styles not loading:**
- Check file paths and permissions
- Verify constants are defined correctly
- Regenerate Elementor CSS

**JS not executing:**
- Check console for errors
- Verify jQuery is loaded
- Check hook names and timing

---

**Last Updated:** 2025-12-02
**Version:** 1.0.5
