<?php

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class zk_admin_menu{

private $option_name = 'zk_toolkit_settings';

    function __construct() {

        $option_name = 'zk_toolkit_settings'; // WIthout redifining some weird issue happens, so I have declared it twice
        
        add_action('admin_menu', array($this,'zk_toolkit_admin_menu'));
        add_action('init', [$this, 'register_settings']);
        add_action("update_option_$option_name", [$this, 'enable_debug_settings']);
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
                
                <?php submit_button('Save Settings'); ?>
            </form>
        </div>
    </div>
    <?php
    echo '<pre>Saved value: ';
var_dump( get_option('zk_toolkit_settings') );
echo '</pre>';
}

/**
 * This appends the lines.
 */
    public function enable_debug_settings() {
        $settings = get_option($this->option_name, []);
        $appended_content = "
/** Zamkai Debug Lines, remove them if any error occurs.*/
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );";

        $file = ABSPATH.'wp-config.php';
        

        if ( is_array($settings) && !empty($settings['debug_check']) && $settings['debug_check'] == 1 ) {
            if (str_contains(file_get_contents($file), $appended_content)) {
            return;
            }
            else {
                file_put_contents(
                $file,
                $appended_content,
                FILE_APPEND | LOCK_EX
                );
            }
        }
         if ( is_string($settings) && (empty($settings['debug_check']) || $settings['debug_check'] == 0) ){

            $content = file_get_contents($file);

            if (str_contains($content, $appended_content)) {
                $pattern = '/' . preg_quote($appended_content, '/') . '/';
                $content = preg_replace($pattern, '', $content);
                file_put_contents($file, $content, LOCK_EX);
            }
        }
    }
}
new zk_admin_menu();