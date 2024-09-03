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



function custom_action_after_order_created($order_id) {
    $order = wc_get_order($order_id);
    $order_data = $order->get_data();

}
add_action('woocommerce_thankyou', 'custom_action_after_order_created', 10, 1);

function add_admin_page() {
    // Add a new top-level menu
    add_menu_page(
        'Charter',         // Page title
        'Charter',                // Menu title
        'manage_options',             // Capability required to access the page
        'charter',         // Menu slug (used in the URL)
        'admin_page',     // Callback function to display the page content
        'dashicons-smiley',           // Icon URL or Dashicon class
        58                            // Position in the menu (20 means after "Dashboard")
    );
}
function register_settings() {
    register_setting(
        'charter_option_group',   // Option group
        'charter_api_token'       // Option name
    );
}
function admin_page() {
    ?>
    <div class="wrap">
        <h1>Charter storefront</h1>
        <p>This is an empty admin page created for the Hello World Plugin.</p>


        <form method="post" action="options.php" style="width: 100%; max-width: 700px;">
            <?php
            // Output security fields for the registered setting "hello_world_option_group"
            settings_fields( 'charter_option_group' );

            // Output setting sections and their fields
            do_settings_sections( 'charter' );

            // Retrieve the existing API token value
            $api_token = get_option( 'charter_api_token', '' );
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label for="charter_api_token">API Token</label>
                    </th>
                    <td>
                        <input id="charter_api_token" type="text" name="charter_api_token" value="<?php echo esc_attr( $api_token ); ?>" style="width: 100%;">
                    </td>
                </tr>
            </table>
            <?php
            // Output save settings button
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
add_action( 'admin_init', 'register_settings' );
add_action('admin_menu', 'add_admin_page');
