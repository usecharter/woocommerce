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

// Function to display Charter.
function charter_function(): void{
    echo "<p>Hello, World!</p>";
}

// Hook the function to an action or shortcode.
add_action('wp_footer', 'charter_function');