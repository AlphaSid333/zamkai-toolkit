<?php

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class ZK_debug_appender{

private $option_name = 'zk_toolkit_settings';

/**
* This appends the lines.
*/
  private function enable_debug_settings() {
        $settings = get_option($this->option_name, []);
        $start = "/* ZAMKAI DEBUG START */";
        $end   = "/* ZAMKAI DEBUG END */";
        $appended_content = "\n$start
            if ( ! defined('WP_DEBUG') ) define('WP_DEBUG', true);
            if ( ! defined('WP_DEBUG_LOG') ) define('WP_DEBUG_LOG', true);
            if ( ! defined('WP_DEBUG_DISPLAY') ) define('WP_DEBUG_DISPLAY', false);
            $end\n";
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