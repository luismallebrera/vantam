# Changelog

All notable changes to this project will be documented in this file.

## [1.0.5-independent] - 2025-12-02

### Changed - Theme Independence Update
- **BREAKING:** Plugin no longer requires VamTam theme to function
- Modified to work with any WordPress theme
- Changed plugin name from "VamTam Elementor Integration (Execor)" to "Elementor Integration Extended"
- Updated author information
- Updated text domain from `vamtam-elementor-integration` to `elementor-integration-extended`

### Removed
- Removed `vamtam_pre_vei_checks()` function and all theme validation logic
- Removed dependency on VamTam theme directories (`VAMTAM_CSS`, `VAMTAM_CSS_DIR`)
- Removed theme compatibility checks and admin notices
- Removed requirement for `current_theme_supports('vamtam-elementor-widgets')`

### Modified
- `vamtam_theme_supports()` now returns `true` by default instead of `false`
- Widget modifications now load automatically for all themes
- Asset paths now point to plugin directory instead of theme directory
- Constants `VAMTAM_ELEMENTOR_STYLES_URI` and `VAMTAM_ELEMENTOR_STYLES_DIR` now use plugin paths

### Added
- New `/assets/css/` directory for plugin stylesheets
- Placeholder `style.css` file for custom styles
- Comprehensive documentation:
  - `README.md` - Complete plugin overview
  - `INSTALLATION.md` - Installation guide
  - `MIGRATION.md` - Technical migration details
  - `DEVELOPER.md` - Developer quick reference
  - `CHANGELOG.md` - This file

### Fixed
- Plugin now activates successfully without VamTam theme
- Widget enhancements work on any WordPress theme
- No more theme compatibility warnings

---

## [1.0.5] - Original Release

### Features (Original VamTam Version)
- Enhanced Elementor widgets (Button, Container, Form, Icon, Nav Menu, Page)
- Dynamic tags (Author Profile Picture, Popup)
- Theme site settings integration
- Custom JavaScript injection points (head, body, footer)
- Elementor experiments configuration
- Performance optimizations
- Integration with VamTam themes
- Widget-specific enhancements:
  - Button: Content alignment fixes, theme icon styles
  - Container: Sticky header controls, clip-path sections
  - Form: Button hover animations
  - Icon: Theme-specific styling
  - Nav Menu: Advanced navigation options
  - Page: Custom page controls

### Requirements (Original)
- WordPress 5.0+
- PHP 7.0+
- Elementor 2.0.0+
- **VamTam theme** (removed in 1.0.5-independent)

---

## Migration Notes

If upgrading from original VamTam version:

### What Stays the Same
- All widget enhancements continue to work
- Dynamic tags remain functional
- Site Settings panel unchanged
- JavaScript injection features intact
- Elementor experiments configuration preserved

### What Changed
- No longer checks for VamTam theme
- Works with any WordPress theme
- Features enabled by default instead of requiring theme support
- Asset paths moved from theme to plugin directory

### Upgrade Path
1. Deactivate old plugin version
2. Replace plugin files with new version
3. Reactivate plugin
4. Clear all caches
5. Regenerate Elementor CSS (Tools > Regenerate CSS)

### Compatibility
- ✅ Works with VamTam themes (backwards compatible)
- ✅ Works with any WordPress theme
- ✅ Existing VamTam theme configurations are respected
- ✅ New installations get all features by default

---

## Version History

- **1.0.5-independent** - Theme-independent version (2025-12-02)
- **1.0.5** - Original VamTam release
- Earlier versions - Maintained by VamTam

---

## Future Roadmap

Potential enhancements being considered:

### v1.1.0 (Planned)
- [ ] Complete text domain migration
- [ ] Rename internal functions from `vamtam_*` prefix
- [ ] Add dedicated plugin settings page
- [ ] Enhanced documentation with video guides
- [ ] Additional widget enhancements

### v1.2.0 (Planned)
- [ ] Custom icon set for widgets
- [ ] Visual style builder for widgets
- [ ] Template library integration
- [ ] Multi-language support expansion
- [ ] Performance optimization dashboard

### v2.0.0 (Future)
- [ ] Complete rewrite with modern architecture
- [ ] React-based settings panel
- [ ] Advanced widget builder
- [ ] Theme compatibility checker
- [ ] Automatic updates system

---

## Contributing

Contributions are welcome! Please:
1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## Credits

- **Original Development:** VamTam (http://vamtam.com)
- **Theme Independence Modification:** Luis Mallebrera (https://github.com/luismallebrera)
- **Built For:** Elementor Page Builder

## License

This plugin inherits its license from the original VamTam Elementor Integration.

---

*For detailed technical changes, see [MIGRATION.md](MIGRATION.md)*
*For installation instructions, see [INSTALLATION.md](INSTALLATION.md)*
*For development guide, see [DEVELOPER.md](DEVELOPER.md)*
