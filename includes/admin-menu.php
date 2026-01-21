<?php

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class ZK_toolkit_admin_menu{

private $option_name = 'zk_toolkit_settings';

    function __construct() {
        
        add_action('admin_menu', array($this,'zk_toolkit_admin_menu'));
        add_action('admin_init', [$this, 'register_settings']);
    }

    function zk_toolkit_admin_menu() {
        add_menu_page(
            'Zamkai Toolkit', 
            'Toolkit',                    
            'manage_options',
            'zamkai-toolkit', 
            array($this,'zk_toolkit_menu_render'),
            'dashicons-admin-generic',      
            80                              
        );
    }

    function register_settings(){
        register_setting(
            'zk_toolkit_settings_group',
            $this->option_name
        );
    }
/**
 * Renders the main admin page for the Zamkai Toolkit plugin.
 */
function zk_toolkit_menu_render() {
    settings_errors('zktoolkit_messages');
    $settings = (array)get_option( $this->option_name, []);
    ?>
    <div class="zk-menu-wrap">
        <h1><?php esc_html_e('Zamkai Toolkit', 'zamkai-toolkit'); ?></h1>
        
        <div class="zk-menu-card card">
            <h3>Debug controls:</h3>
            
            <form method="post" action="options.php">
                <?php settings_fields('zk_toolkit_settings_group'); ?>
                
                <label>
                    <input type="checkbox" id = "debug_check" name="<?= esc_attr($this->option_name) ?>[debug_check]"
                               value="1"
                               <?= checked(1, $settings['debug_check'] ?? 0, false) ?>>
                    Enable WP_DEBUG
                </label>

                <label>
                    <input type="checkbox" id = "debug_display_check" name="<?= esc_attr($this->option_name) ?>[debug_display_check]"
                               value="1"
                               <?= checked(1, $settings['debug_display_check'] ?? 0, false) ?>>
                    Enable WP_DEBUG_DISPLAY
                </label>
                
                <?php submit_button('Save Settings'); ?>
            </form>
        </div>
    </div>
    <?php
    echo '<pre>Saved value: ';
var_dump( get_option('zk_toolkit_settings') );
echo '</pre>';
}
}