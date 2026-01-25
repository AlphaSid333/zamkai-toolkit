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
        $settings = (array)get_option($this->option_name, []);
        $start = "/* ZAMKAI DEBUG START */";
        $end   = "/* ZAMKAI DEBUG END */";
        $display_setting = isset($settings['debug_display_check']);

        $debug_content_1 = "\n$start
            if ( ! defined('WP_DEBUG') ) define('WP_DEBUG', true);
            if ( ! defined('WP_DEBUG_LOG') ) define('WP_DEBUG_LOG', true);
            if ( ! defined('WP_DEBUG_DISPLAY') ) define('WP_DEBUG_DISPLAY', false);
            \n$end";
        $debug_content_2 = "\n$start
            if ( ! defined('WP_DEBUG') ) define('WP_DEBUG', true);
            if ( ! defined('WP_DEBUG_LOG') ) define('WP_DEBUG_LOG', true);
            if ( ! defined('WP_DEBUG_DISPLAY') ) define('WP_DEBUG_DISPLAY', true);
            \n$end";

        if(isset($settings['debug_display_check']) == 1){
            $appended_content = $debug_content_2;
            $appended_content_2 = $debug_content_1;
        }else{
            $appended_content = $debug_content_1;
            $appended_content_2 = $debug_content_2;
        }

        $file = ABSPATH.'wp-config.php';
        $content = file_get_contents($file);
                
        if (is_writable($file)) {
            $class = "notice-error";
            if(isset($settings['debug_check']) == "1"){
                if (str_contains($content, $appended_content)){
                    add_settings_error(
                            'zktoolkit_messages',
                            'zktoolkit_write_check',
                            'Debug Setting Already Active!',
                            'info');
                    }
                    if (str_contains($content, $appended_content_2)){
                        $pattern = '/' . preg_quote($appended_content_2, '/') . '/';
                        $content = preg_replace($pattern, '', $content);
                        $updated_content =$content.$appended_content;
                        file_put_contents(
                            $file,
                            $updated_content, LOCK_EX
                            );
                        add_settings_error(
                            'zktoolkit_messages',
                            'zktoolkit_write_check',
                            'Debug settings updated!',
                            'success');
                        }else{
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
            elseif( empty($settings['debug_check']) || ($settings['debug_check']) == "0"){
                $settings['debug_display_check'] = "0";

                remove_action('update_option_' . $this->option_name, [$this, 'enable_debug_settings']); // prevents infinite loop and double notice.

                update_option( $this->option_name, $settings );

                add_action('update_option_' . $this->option_name, [$this, 'enable_debug_settings']); //better way might be to use pre_update_option but i'm lazy ;P

                if (str_contains($content, $appended_content)){
                    $pattern = '/' . preg_quote($appended_content, '/') . '/';
                    $content = preg_replace($pattern, '', $content);
                    file_put_contents($file, $content, LOCK_EX);
                    add_settings_error(
                        'zktoolkit_messages',
                        'zktoolkit_write_check',
                        'Debug Setting Removed!',
                        'success');
                }
                elseif(str_contains($content, $appended_content_2)){
                        $pattern = '/' . preg_quote($appended_content_2, '/') . '/';
                        $content = preg_replace($pattern, '', $content);
                        file_put_contents($file, $content, LOCK_EX);
                    }
                    else{
                        add_settings_error(
                            'zktoolkit_messages',
                            'zktoolkit_write_check',
                            'No debug lines found to remove!',
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