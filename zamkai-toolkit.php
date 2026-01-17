<?php
/*
  Plugin Name: Zamkai Toolkit
  Description: A companion for WordPress developers, to help debug, develop and test without needing a lot of plugins.
  Version: 0.1
  Requires at least: 4.0
  Tested up to: 6.9
  License: GPLv2 or later
  Author: zamkaimaster
  Text Domain: zamkai-toolkit
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define('ZAMKAI_TOOLKIT_PATH', plugin_dir_path(__FILE__));
define('ZAMKAI_TOOLKIT_URL',  plugin_dir_url(__FILE__));

require_once ZAMKAI_TOOLKIT_PATH . 'includes/admin-menu.php';