=== Advanced Custom Fields: Restrict Color Picker Options ===
Contributors: adamwalter,seanseansean,antishow,makkal
Tags: custom fields, acf, color
Requires at least: 4.0
Tested up to: 5.8
Requires PHP: 7.0
Stable tag: 1.3.1 / Edited for PHP 8.2
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Restrict Advanced Custom Fields color picker to a specific subset of colors. Removes color wheel from the field UI so user can't pick other colors.

== Description ==

Restrict Advanced Custom Fields color picker field to a specific subset of custom colors. Removes the color wheel and slider from the field UI so the user can't pick any other colors

= Features =

**Include the color palette from the current theme** by enabling the option on the plugin settings page.

**Get the current color options palette** in your template code with the `acfrcpo_get_color_options` function.


== Installation ==

1. Upload `acf-restrict-color-picker` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= I have a question =

Leave your question in the support tab and we'll respond!

== Screenshots ==

1. Comma-separated list of HEX color values used to define the color options. Optionally include the current theme's color palette as well.
2. Simple color swatches allow the user to easily choose from your color set.

== Changelog ==

= 1.3.1 =
* Bug fix: Adds check for false return from get_theme_support (Thanks @faketib0 and Dan Mensinger!)

= 1.3 =
* Adds option to include the current theme's colors. Thank you to @mrwweb for this idea!
* Adds acfrcpo_get_color_options function to get the current color palette. Thank you to @badjesus for the feature request!

= 1.2.1 =
* Fixes $l10n parameter syntax in wp_localize_script.

= 1.2 =
* Finally fixes long standing issue with multiple instances of color pickers.

= 1.1 =
* Change the plugin name to better match similar plugins in the ACF world.

= 1.0 =
* First version of the plugin
