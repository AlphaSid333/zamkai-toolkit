<?php

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class zk_admin_menu{

private $option_name = 'zk_toolkit_settings';

function __construct() {
    add_action('admin_menu', array($this,'zk_toolkit_admin_menu'));
}

function zk_toolkit_admin_menu() {
    add_menu_page(
        'Zamkai Toolkit', 
        'Tookit',                    
        'manage_options',
        'zamkai-toolkit', 
        array($this,'zk_toolkit_menu_render'),
        'dashicons-admin-generic',      
        80                              
    );
    }

/**
 * Renders the main admin page for the Zamkai Toolkit plugin.
 */
function zk_toolkit_menu_render() {
    $options = get_option('zk_debug_options', [
        'wp_debug' => defined('WP_DEBUG') ? WP_DEBUG : false,
        'wp_debug_display' => defined('WP_DEBUG_DISPLAY') ? WP_DEBUG_DISPLAY : false,
        'wp_debug_log' => defined('WP_DEBUG_LOG') ? WP_DEBUG_LOG : false,
    ]);
    ?>
    <div class="zk-menu-wrap">
        <h1><?php esc_html_e('Zamkai Toolkit', 'zamkai-toolkit'); ?></h1>
        
        <div class="zk-menu-card card">
            <h3>Debug controls:</h3>
            
            <form method="post" action="options.php">
                <?php settings_fields('zk_toolkit_settings'); ?>
                
                <label>
                    <input type="checkbox" name="zk_debug_check" value="1">
                    Enable WP_DEBUG
                </label>
                
                <?php submit_button('Save Settings'); ?>
            </form>
        </div>
    </div>
    <?php
}
}
new zk_admin_menu();