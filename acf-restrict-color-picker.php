<?php
/*
    Plugin Name: ACF - Restrict Color Picker Options
    Plugin URI:
    Description: Restrict ACF's color picker field to a specific subset of custom colors.
    Version: 1.0
    Author: Vital
    Author URI: http://vtldesign.com
    Text Domain: vitaldesign
    License: GPLv2

    Copyright 2015  VITAL DESIGN  (email : developer@vtldesign.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Exit if accessed directly
if (! defined('ABSPATH')) exit;

class ACF_Restrict_Color_Picker_Options {

    private $plugin_path;
    private $plugin_url;
    private $color_settings;

    /**
     * Initialize plugin
     */
    public function __construct() {

        $this->plugin_path    = plugin_dir_path(__FILE__);
        $this->plugin_url     = plugin_dir_url(__FILE__);
        $this->color_settings = get_option('acf_rcpo_settings');

        if (!empty($this->color_settings) && !in_array('', $this->color_settings)) {
            add_action('acf/input/admin_enqueue_scripts', array($this, 'register_scripts'));
            add_action('acf/input/admin_enqueue_scripts', array($this, 'register_styles'));
            add_action('acf/input/admin_enqueue_scripts', array($this, 'localize_options'));
        }

        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'action_links'));

        require $this->plugin_path . 'admin.php';

    }

    /**
     * Add Settings link to plugin on plugins list
     */
    public function action_links($links) {
        $custom_links = array(
           '<a href="' . admin_url('edit.php?post_type=acf-field-group&page=acf-restrict-color-picker') . '">Settings</a>',
           );
        return array_merge($custom_links, $links);
    }

    /**
     * Enqueue JavaScript
     */
    public function register_scripts() {

        wp_enqueue_script('acf_restrict_color_picker_js', $this->plugin_url . 'assets/acf-restrict-color-picker.js', array('jquery'), '1.0', true);
    }

    /**
     * Enqueue stylesheet
     */
    public function register_styles() {

        wp_enqueue_style('acf_restrict_color_picker_cs', $this->plugin_url . 'assets/acf-restrict-color-picker.css', false, '1.0');
    }

    /**
     * Localize color options
     */
    public function localize_options() {

        $color_options = array();

        // Get color options setting
        $color_restrictions = $this->color_settings;
        // Remove any whitespace
        $color_restrictions = preg_replace('/\s+/', '', $color_restrictions);
        // Convert to array
        $color_restrictions = explode(',', $color_restrictions['color']);
        $color_options = $color_restrictions;

        // Encode for JS
        $color_json = json_encode($color_options);

        // Pass values along to plugin JS file
        wp_localize_script('acf_restrict_color_picker_js', 'acfRCPOptions', array(
            'colorPickerOptions' => $color_json
        ));

    }

}

new ACF_Restrict_Color_Picker_Options();
