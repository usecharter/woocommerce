<?php

function charter_set_basket_uuid_handler(): void {
	if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
		wp_send_json_error('Invalid request method', 405);
	}
    if (!isset($_POST['secure']) || !isset($_POST['uuid'])) {
        wp_send_json_error('Bad request', 400);
        exit;
    }
    $nonce = filter_var(wp_unslash($_POST['secure']), FILTER_SANITIZE_SPECIAL_CHARS);

    if (!wp_verify_nonce($nonce, 'secure')) {
        wp_send_json_error('Bad request', 400);
    }

    $basket_uuid = filter_var(wp_unslash($_POST['uuid']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	try {
		WC()->session->set('_uuid', $basket_uuid);
	} catch (Exception $e) {}
	try {
		$_SESSION['_uuid'] = $basket_uuid;
	} catch (Exception $e) {}

	wp_send_json_success([]);
}
add_action('wp_ajax_nopriv_set_basket_uuid', 'charter_set_basket_uuid_handler');
add_action('wp_ajax_set_basket_uuid', 'charter_set_basket_uuid_handler');
