<?php
/*
 Plugin Name: Charter
 Plugin URI: https://usecharter.io/
 Description: Paid ads, simplified
 Version: 1.0
 Author: Charter
 Author URI: https://usecharter.io/
 License: proprietary
*/

if (!defined('ABSPATH')) { exit; }

// Admin UI
require_once plugin_dir_path( __FILE__ ) . 'admin/menu.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/register-api-token-setting.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/page.php';

// Pixel / ad click tracking
require_once plugin_dir_path( __FILE__ ) . 'pixel/sync-session-uuids.php';
require_once plugin_dir_path( __FILE__ ) . 'pixel/add-script.php';
require_once plugin_dir_path( __FILE__ ) . 'pixel/endpoints/get-basket-uuid.php';
require_once plugin_dir_path( __FILE__ ) . 'pixel/endpoints/set-basket-uuid.php';

// Conversion recording
require_once plugin_dir_path( __FILE__ ) . 'conversion/record-conversion.php';
