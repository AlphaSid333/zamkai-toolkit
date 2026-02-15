<?php

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class ZK_toolkit_admin_menu{

private $option_name = 'zk_toolkit_settings';

    function __construct() {
        
        add_action('admin_menu', array($this,'zk_toolkit_admin_menu'));
        add_action('admin_enqueue_scripts', [$this, 'zk_admin_scripts_load']);
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

    function zk_admin_scripts_load(){
        wp_enqueue_script(
            'ztk-admin.js',
            plugin_dir_url(__FILE__) . "js/ztk-admin.js",
            [],
            '0.0.0',
            true
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
            <div class = "ztk-display-checkbox" id = "zk-debug-display"style="display:none" >
                <label>
                    <input type="checkbox" id = "debug_display_check" name="<?= esc_attr($this->option_name)?>[debug_display_check]"
                               <?php if(isset($settings['debug_check']) && ($settings['debug_check']) == 0 ){
                                    echo 'value= 0';
                                    echo checked(1, $settings['debug_display_check'] ?? 0, false);
                                } else{ 
                                    echo "value= 1"; 
                                    echo checked(1, $settings['debug_display_check'] ?? 0, false);
                                     } ?>>
                    Enable WP_DEBUG_DISPLAY
                </label>
            </div>
                <?php submit_button('Save Settings'); ?>
            </form>
        </div>
        <?php
          
            require_once ZAMKAI_TOOLKIT_PATH . 'includes/admin parts/log-preview.php';
            zkytLogPreview();
            
            ?>
        </div> 
        
        <?php
}
}