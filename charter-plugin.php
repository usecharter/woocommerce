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

function start_session(): void {
	if (!session_id()) {
		session_start();
	}
    if (!WC()->session) {
        return;
    }
	$wc_session_uuid = WC()->session->get('_uuid');
	$php_session_uuid = $_SESSION['_uuid'];

	if (($wc_session_uuid && $php_session_uuid && $wc_session_uuid !== $php_session_uuid) || !$wc_session_uuid && $php_session_uuid) {
		WC()->session->set('_uuid', $php_session_uuid);
	} else if ($wc_session_uuid && !$php_session_uuid) {
		$_SESSION['_uuid'] = $wc_session_uuid;
	}
}

add_action('woocommerce_init', 'start_session', 1);


function enqueue_script(): void {
    wp_enqueue_script('charter-pixel', 'https://localhost:5173/pixel.js', array(), '1.0', true);

	// Pass the nonce and ajax URL to the script
	wp_localize_script('charter-pixel', 'charter', array(
		'url' => admin_url('admin-ajax.php'),
		'secure' => wp_create_nonce('secure')
	));
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
	    'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCA1NTUgNTU2IiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgogICAgPGcgY2xpcC1wYXRoPSJ1cmwoI2NsaXAwXzI2NV8xNzMwKSI+CiAgICAgICAgPHBhdGggZD0iTTM5LjkzNjUgMTg5LjQyNkw0ODMuMzI1IDcwLjYyMDhDNDk4LjI0NSA2Ni4yMzEyIDUyNi4yMiA2Mi40MDg5IDU0NS41MTYgNzEuNDQ1QzU2MS4zNCA3OC44NTUzIDU0NS4yNTUgOTUuNTQ4NiA1MTguOTYxIDEwNy43MDhMMjQ5Ljg1IDIyNS40NzNDMTkyLjExNiAyNTQuNTY0IDE0Ni41MjEgMjYxLjgyOCAxNDkuMTYyIDMyOS4yMjhDMTU1Ljc2MyA0OTcuNjc1IDE1My43MjYgNTE2LjQ3OSAxMTIuODA1IDQ2MS4zNzZDODAuNjQ1MSA0MDMuOTI2IDEzLjk5MzEgMjgwLjMyMiA0LjY2NTkzIDI0NS41MTNDLTQuNjYxMjYgMjEwLjcwMyAyNC4yOTM0IDE5My42MTggMzkuOTM2NSAxODkuNDI2WiIgZmlsbD0iIzlDQTJBNyIvPgogICAgPC9nPgo8L3N2Zz4K', // Base64 encoded SVG
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
        <h1>Charter</h1>
<!--        <p>This is an empty admin page created for the Hello World Plugin.</p>-->


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

function get_basket_uuid_handler(): void {
	if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
		wp_send_json_error('Invalid request method', 405);
		exit;
	}
    if (!isset($_GET['secure']) || !wp_verify_nonce($_GET['secure'], 'secure')) {
        wp_send_json_error('Bad request', 400);
        exit;
    }
    $wc_session_uuid = WC()->session->get('_uuid');
    $php_session_uuid = $_SESSION['_uuid'];

    $basket_uuid = $wc_session_uuid ?? $php_session_uuid ?? null;

    wp_send_json_success(['uuid' => $basket_uuid]);
	exit;
}
add_action('wp_ajax_nopriv_get_basket_uuid', 'get_basket_uuid_handler');
add_action('wp_ajax_get_basket_uuid', 'get_basket_uuid_handler');


function set_basket_uuid_handler(): void {
	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
		wp_send_json_error('Invalid request method', 405);
		exit;
	}
	if (!isset($_POST['secure']) || !wp_verify_nonce($_POST['secure'], 'secure')) {
		wp_send_json_error('Bad request', 400);
		exit;
	}
	$basket_uuid = $_POST['uuid'];
	try {
		WC()->session->set('_uuid', $basket_uuid);
	} catch (Exception $e) {}
	try {
		$_SESSION['_uuid'] = $basket_uuid;
	} catch (Exception $e) {}

	wp_send_json_success([]);
	exit;
}
add_action('wp_ajax_nopriv_set_basket_uuid', 'set_basket_uuid_handler');
add_action('wp_ajax_set_basket_uuid', 'set_basket_uuid_handler');


function my_custom_function_after_payment($order_id) {
	// Get the order object
	$order = wc_get_order($order_id);

	// Example: Get order total
	$order_total = $order->get_total();

	// Example: Get customer email
	$customer_email = $order->get_billing_email();

	// Add your custom code here
	// For example, send an email or update a custom field
	error_log('Payment complete for Order ID: ' . $order_id . ' | Order Total: ' . $order_total . ' | Customer Email: ' . $customer_email);
}
add_action('woocommerce_payment_complete', 'my_custom_function_after_payment');

