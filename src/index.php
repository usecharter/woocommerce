<?php
/*
 Plugin Name: Charter
 Description: AI-powered ad budgeting
 Version: 1.0.0
 Author: Charter
 Author URI: https://usecharter.io
 License: GPLv2 or later
*/

if (!defined('ABSPATH')) { exit; }

// Admin UI
require_once plugin_dir_path( __FILE__ ) . 'admin/menu.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/register-api-token-setting.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/page.php';

// Record ad clicks
require_once plugin_dir_path( __FILE__ ) . 'ad-clicks/add-pixel-to-storefront.php';
require_once plugin_dir_path( __FILE__ ) . 'ad-clicks/sync-session-uuids.php';
require_once plugin_dir_path( __FILE__ ) . 'ad-clicks/endpoints/get-basket-uuid.php';
require_once plugin_dir_path( __FILE__ ) . 'ad-clicks/endpoints/set-basket-uuid.php';

// Record conversions
require_once plugin_dir_path( __FILE__ ) . 'conversions/record-conversion.php';
