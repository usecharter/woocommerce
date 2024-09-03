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

// Prevent direct access to the file.
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function enqueue_script(): void {
    wp_enqueue_script('charter-pixel', 'https://usecharter.io/pixel.js');
}

add_action('wp_enqueue_scripts', 'enqueue_script');
