<?php
/**
 * Plugin Name: Swing Dance School / Business Extensions
 * Plugin URI: https://nathandias.com
 * Description: Custom post types and utilities related to swing dance classes and events
 * Version: 0.1
 * Text Domain: swingbiz
 * Author: Nathan Dias
 * Author URI: https://nathandias.com
 */

require __DIR__ . '/vendor/autoload.php';

include __DIR__ . '/bands.php';
include __DIR__ . '/deejays.php';
include __DIR__ . '/teachers.php';
// include __DIR__ . '/class_descriptions.php';

function create_home_menu(){
    add_menu_page('SwingBiz', 'SwingBiz', 'manage_options', 'swingbiz', 'swingbiz-page', 'dashicons-groups');
}
add_action('admin_menu', 'create_home_menu');