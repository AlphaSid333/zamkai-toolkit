<?php

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';
require_once ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php';

add_action('wp_ajax_zkt_plugin_install', 'zkt_plugin_install');

function zkt_plugin_install(){

    $slug = $_POST['slug'];
    $plugin_file = WP_PLUGIN_DIR . '/' . $slug . '/' . $slug . '.php';
    activate_plugin($plugin_file);

    if(file_exists($plugin_file)){
        activate_plugin($plugin_file);
        wp_send_json_success('Plugin has been activated!');
    }

    $api = plugins_api('plugin_information',[
        'slug'=> $slug,
        'fields' => ['downloadlink' => true]
    ]);

    if (is_wp_error($api)) {
        wp_send_json_error('Could not fetch plugin info');
    }

    $installer = new Plugin_Upgrader(new WP_Ajax_Upgrader_Skin());
    $result = $installer->install($api->download_link);

    if (is_wp_error($result) || !$result) {
        activate_plugin($plugin_file);
        wp_send_json_error('Installation failed, maybe it exists already?');
    }

    activate_plugin($plugin_file);
    wp_send_json_success('Plugin installed and activated!');
}