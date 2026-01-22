<?php

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class ZK_debug_appender{

private $option_name = 'zk_toolkit_settings';
private $message = '';

/**
* This appends the lines.
*/

    function __construct(){
        add_action( 'update_option_' . $this->option_name, [ $this, 'enable_debug_settings' ] );
    }
    
    public function enable_debug_settings() {
        $settings = get_option($this->option_name, []);
        $start = "/* ZAMKAI DEBUG START */";
        $end   = "/* ZAMKAI DEBUG END */";
        $appended_content = "\n$start
            if ( ! defined('WP_DEBUG') ) define('WP_DEBUG', true);
            if ( ! defined('WP_DEBUG_LOG') ) define('WP_DEBUG_LOG', true);
            if ( ! defined('WP_DEBUG_DISPLAY') ) define('WP_DEBUG_DISPLAY', false);
            $end\n";
        $file = ABSPATH.'wp-config.php';
                
        if (is_writable($file)) {
            $class = "notice-error";

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
                        add_settings_error(
                        'zktoolkit_messages',
                        'zktoolkit_write_check',
                        'Debug settings added!',
                        'success');
                    }
                    }
                if ( is_string($settings) && (empty($settings['debug_check']) || $settings['debug_check'] == 0) ){

                    $content = file_get_contents($file);

                    if (str_contains($content, $appended_content)) {
                        $pattern = '/' . preg_quote($appended_content, '/') . '/';
                        $content = preg_replace($pattern, '', $content);
                        file_put_contents($file, $content, LOCK_EX);
                        add_settings_error(
                        'zktoolkit_messages',
                        'zktoolkit_write_check',
                        'Debug settings Removed!',
                        'success');
                    }
                }
        }
        else {
            add_settings_error(
                        'zktoolkit_messages',
                        'zktoolkit_write_check',
                        'File is not writable, unable to add define debug constants!',
                        'error');
            $settings = (array)get_option( $this->option_name, []);
            $settings['debug_check'] = "0";

            remove_action('update_option_' . $this->option_name, [$this, 'enable_debug_settings']); // prevents infinite loop and double notice.

            update_option( $this->option_name, $settings );

            add_action('update_option_' . $this->option_name, [$this, 'enable_debug_settings']); //better way might be to use pre_update_option but i'm lazy ;P
            }
    }

function notice_handler(){
    error_log($this->message);
    add_settings_error(
					'zktoolkit_messages',               // Slug (can be anything)
					'zktoolkit_write_check',          // Unique code
					$this->message, 
					'info'                      // Type: 'success', 'error', 'warning', 'info'
        );
}
}