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
        </div><?php
            $log_file = ABSPATH . "wp-content/debug.log";
            
            if ( isset($_POST['ztk_clear_log_btn']) ) {
                $empty = "";
                file_put_contents($log_file, $empty);
                    add_settings_error(
                        'zktoolkit_messages',
                        'zktoolkit_log_clear',
                        'Logs cleared!',
                        'success');//not working rn
                wp_redirect([]); 
            }
            if(file_exists($log_file)){
                $logContent = file_get_contents($log_file);
                ?>
                <div class="ztk-log-card">
                    <div class="ztk-title" style ="display: flex; align-items: center;" ><h3>Text File Preview</h3>
                        <div class = "ztk-clear-log-btn" style= "padding: 0px 10px 0px 10px;">
                            <form method="post" style="display: inline;"> <button
                            type="submit" 
                            name="ztk_clear_log_btn" 
                            class="button button-primary button-large"> Clear logs</button>
                        </form> </div>
                </div>
                    <p>Preview of your text file (first 50KB shown):</p>
                    <!-- Text preview in <pre> for formatting -->
                        <pre style="background: #f9f9f9; border: 1px solid #ddd; padding: 15px; max-height: 600px; overflow-y: auto; font-family: monospace; font-size: 12px;">
                            <?php echo esc_html($logContent); ?>
                        </pre>
                </div> <?
            }
            else{
                echo "Ran into an error here";
            }
            
            ?>
        </div> <?php
        echo '<pre>Saved value: ';
            var_dump( get_option('zk_toolkit_settings') );
        echo '</pre>';
}
}