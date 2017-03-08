<?php
/**
 * Plugin Settings Page
 */
class ACF_RCPO_Settings_Page {

    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Initialize
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'add_plugin_page'), 100);
        add_action('admin_init', array($this, 'page_init'));
    }

    /**
     * Add options page as a sub-item to the ACF menu
     */
    public function add_plugin_page() {

        add_submenu_page(
            'edit.php?post_type=acf-field-group',
            'Restrict Color Picker Options',
            'Restrict Color Picker Options',
            'manage_options',
            'acf-restrict-color-picker',
            array($this, 'create_admin_page')
        );

    }

    /**
     * Options page callback
     */
    public function create_admin_page() {
        $this->options = get_option('acf_rcpo_settings');
        ?>
        <div class="wrap">
            <h2>Restrict Color Picker Options</h2>
            <form method="post" action="options.php">
            <?php
                settings_fields('acf_rcpo');
                do_settings_sections('acf-restrict-color-picker');
                submit_button('Save Color Options');
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init() {
        register_setting(
            'acf_rcpo',
            'acf_rcpo_settings',
            array($this, 'sanitize')
        );

        add_settings_section(
            'acf_rcpo_settings_section',
            '',
            array($this, 'print_section_info'),
            'acf-restrict-color-picker'
        );

        add_settings_field(
            'colors',
            'Color Options',
            array($this, 'colors_callback'),
            'acf-restrict-color-picker',
            'acf_rcpo_settings_section'
        );
    }

    /**
     * Sanitize each setting field as needed
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize($input) {
        $new_input = array();

        if (isset( $input['color']))
            $new_input['color'] = sanitize_text_field($input['color']);

        return $new_input;
    }

    /**
     * Print section text
     */
    public function print_section_info() {
        print 'This plugin removes the color wheel from all ACF color picker fields and restricts the user to a specific set of colors defined here.<br /><br />';
        print 'When configuring a color picker field, if the \'Default Value\' is set, this will override the master color options (defined below) for that field. You may prepend <code>default-</code> to a hex value to enable that color by default.<br /><br />';
        print '<strong>Examples: </strong><br />';
        print '<code>#333, #666, #999</code><br />';
        print '<code>#ff0000, #00ff00, default-#0000ff</code><br />';
    }

    /**
     * Get the settings and print its values
     */
    public function colors_callback() {

        if (isset($this->options['color'])) {
            $color = esc_attr($this->options['color']);
        } else {
            $color = '';
        }

        $output = "<input style='width: 100%;' type='text' id='color' name='acf_rcpo_settings[color]' value='{$color}' placeholder='#e3762e,#00ab8e,#de4e2e,#008ba3,#888178,#636463'/>";
        $output .= '<p class="description" id="admin-email-description">Comma-separated list of HEX color values.</p>';

        echo $output;
    }
}

if (is_admin())
    $acf_rcpo_settings_page = new ACF_RCPO_Settings_Page();
